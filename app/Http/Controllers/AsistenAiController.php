<?php

namespace App\Http\Controllers;

use App\Models\AsistenAiMessage;
use App\Services\AsistenAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenAiController extends Controller
{
    protected AsistenAiService $aiService;

    public function __construct(AsistenAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $messages = AsistenAiMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        // If no message yet, seed the default greeting matching screenshot
        if ($messages->isEmpty()) {
            $welcomeContent = "Halo! Saya adalah Asisten AI digital untuk Protokol dan Komunikasi Pimpinan Kota Bandung.\nSaya dapat membantu Anda dengan berbagai tugas, seperti:\n\n• Meringkas dokumen surat masuk.\n• Mengecek dan menyusun jadwal pimpinan.\n• Membuat draf naskah sambutan atau press release.\n• Mencari informasi riwayat kegiatan.\n\nApa yang bisa saya bantu hari ini?";

            $welcome = AsistenAiMessage::create([
                'user_id' => $userId,
                'role' => 'assistant',
                'content' => $welcomeContent,
                'created_at' => now(),
            ]);

            $messages = collect([$welcome]);
        }

        $currentApiKey = config('services.gemini.api_key') ?: env('GEMINI_API_KEY') ?: session('gemini_api_key');
        $currentModel = config('services.gemini.model') ?: env('GEMINI_MODEL', 'gemini-1.5-flash');

        return view('asisten-ai.index', compact('messages', 'currentApiKey', 'currentModel'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'prompt' => 'nullable|string|max:2000',
            'file' => 'nullable|file|max:51200', // max 50MB
        ]);

        $userId = Auth::id();
        $prompt = $request->prompt ?: 'Tolong telaah berkas terlampir ini.';
        
        $filePath = null;
        $fileName = null;
        $fileType = null;
        $fileSize = null;
        $fileData = null;

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $fileName = $uploadedFile->getClientOriginalName();
            $fileType = $uploadedFile->getClientOriginalExtension();
            $fileSize = $uploadedFile->getSize();
            $filePath = $uploadedFile->store('asisten-ai/uploads', 'public');

            $fileData = [
                'name' => $fileName,
                'type' => $fileType,
                'size' => $fileSize,
                'path' => $filePath,
            ];
        }

        // Save User Message
        $userMsg = AsistenAiMessage::create([
            'user_id' => $userId,
            'role' => 'user',
            'content' => $prompt,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
        ]);

        // Process AI Response
        $aiResult = $this->aiService->generateResponse($prompt, $userId, $fileData);

        // Save Assistant Message
        $assistantMsg = AsistenAiMessage::create([
            'user_id' => $userId,
            'role' => 'assistant',
            'content' => $aiResult['content'],
            'structured_data' => $aiResult['structured_data'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'user' => [
                'content' => $userMsg->content,
                'time' => $userMsg->created_at->format('H:i'),
                'file_path' => $filePath ? asset('storage/' . $filePath) : null,
                'file_name' => $fileName,
                'file_type' => $fileType,
                'file_size' => $userMsg->formatted_file_size,
                'is_image' => $userMsg->is_image,
                'is_video' => $userMsg->is_video,
                'is_pdf' => $userMsg->is_pdf,
            ],
            'assistant' => [
                'content' => $assistantMsg->content,
                'formatted_content' => $assistantMsg->formatted_content,
                'structured_data' => $assistantMsg->structured_data,
                'time' => $assistantMsg->created_at->format('H:i'),
                'source' => $aiResult['source'] ?? 'local_engine',
            ],
        ]);
    }

    public function saveApiKey(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengubah konfigurasi API Key.');
        }

        $request->validate([
            'gemini_api_key' => 'nullable|string|max:255',
            'gemini_model'   => 'nullable|string|max:100',
        ]);

        $apiKey = trim($request->gemini_api_key ?? '');
        $model = trim($request->gemini_model ?? '') ?: 'gemini-1.5-flash';

        // 1. Simpan permanen ke file .env
        $this->updateEnvFile('GEMINI_API_KEY', $apiKey);
        if ($request->filled('gemini_model')) {
            $this->updateEnvFile('GEMINI_MODEL', $model);
        }

        // 2. Simpan di runtime config & session agar langsung aktif tanpa reload server
        if (!empty($apiKey)) {
            session(['gemini_api_key' => $apiKey]);
            config(['services.gemini.api_key' => $apiKey]);
            config(['services.gemini.model' => $model]);

            return redirect()->back()
                ->with('success', 'Google Gemini API Key berhasil disimpan permanen di sistem (.env). Kunci akan tetap aktif dan tidak akan ter-reset meskipun laptop dimatikan atau di-restart.');
        } else {
            session()->forget('gemini_api_key');
            config(['services.gemini.api_key' => null]);

            return redirect()->back()
                ->with('success', 'Google Gemini API Key berhasil dikosongkan. Sistem beralih ke Engine Database Cerdas Lokal.');
        }
    }

    private function updateEnvFile(string $key, string $value): void
    {
        $envPaths = [
            base_path('.env'),
            base_path('E-Prokopim/.env'),
        ];

        foreach ($envPaths as $envPath) {
            if (!file_exists($envPath)) {
                continue;
            }

            $envContent = file_get_contents($envPath);
            $formattedValue = (str_contains($value, ' ') || str_contains($value, '#')) ? '"' . $value . '"' : $value;

            if (preg_match("/^{$key}=.*/m", $envContent)) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$formattedValue}", $envContent);
            } else {
                $envContent .= "\n{$key}={$formattedValue}\n";
            }

            @file_put_contents($envPath, $envContent);
        }
    }

    public function clearChat()
    {
        $userId = Auth::id();
        AsistenAiMessage::where('user_id', $userId)->delete();

        return redirect()->route('asisten-ai.index')
            ->with('success', 'Riwayat percakapan Asisten AI telah diatur ulang.');
    }
}
