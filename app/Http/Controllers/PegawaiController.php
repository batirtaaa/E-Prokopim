<?php

namespace App\Http\Controllers;

use App\Models\Personel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Personel::orderBy('id', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_kepegawaian')) {
            $statusFilter = $request->status_kepegawaian;
            if (in_array(strtolower($statusFilter), ['outsourcing', 'outsourching'])) {
                $query->where(function($q) {
                    $q->where('status_kepegawaian', 'like', '%outsourc%');
                });
            } else {
                $query->where('status_kepegawaian', $statusFilter);
            }
        }

        if ($request->filled('bidang')) {
            $query->where('bidang', $request->bidang);
        }

        $totalPegawai = Personel::count();
        $perPageParam = $request->input('per_page', '10');
        
        if ($perPageParam === 'all' || (is_numeric($perPageParam) && (int)$perPageParam >= $totalPegawai && $totalPegawai > 0)) {
            $perPage = max(1, $totalPegawai);
        } elseif (is_numeric($perPageParam)) {
            $perPage = max(1, min(500, (int) $perPageParam));
        } else {
            $perPage = 10;
        }

        $pegawai = $query->paginate($perPage)->withQueryString();

        return view('pegawai.index', compact('pegawai', 'totalPegawai', 'perPageParam'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah data pegawai.');
        }
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menambah data pegawai.');
        }
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'status_kepegawaian' => 'required|string|max:50',
            'bidang' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'photo' => 'nullable|image|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pegawai/foto', 'public');
        }

        Personel::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'nip' => $request->nip ?: '-',
            'jabatan' => $request->jabatan,
            'status_kepegawaian' => $request->status_kepegawaian,
            'bidang' => $request->bidang ?: 'protokol',
            'phone' => $request->phone,
            'photo' => $photoPath,
            'status_ketersediaan' => 'standby',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan ke dalam sistem.');
    }

    public function edit(Personel $pegawai)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit data pegawai.');
        }
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Personel $pegawai)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengedit data pegawai.');
        }
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'status_kepegawaian' => 'required|string|max:50',
            'bidang' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'photo' => 'nullable|image|max:5120',
        ]);

        $photoPath = $pegawai->photo;
        if ($request->hasFile('photo')) {
            if ($pegawai->photo) {
                Storage::disk('public')->delete($pegawai->photo);
            }
            $photoPath = $request->file('photo')->store('pegawai/foto', 'public');
        }

        $pegawai->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'nip' => $request->nip ?: '-',
            'jabatan' => $request->jabatan,
            'status_kepegawaian' => $request->status_kepegawaian,
            'bidang' => $request->bidang ?: $pegawai->bidang,
            'phone' => $request->phone,
            'photo' => $photoPath,
        ]);

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Personel $pegawai)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menghapus data pegawai.');
        }
        if ($pegawai->photo) {
            Storage::disk('public')->delete($pegawai->photo);
        }
        $pegawai->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $data = Personel::orderBy('id', 'asc')->get();
        $filename = 'daftar_pegawai_prokopim_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response()->stream(function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama Pegawai', 'Email', 'NIP', 'Jabatan', 'Status Kepegawaian', 'Bidang', 'No Telepon']);
            foreach ($data as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->nama_lengkap,
                    $row->display_email,
                    $row->nip ?? '-',
                    $row->jabatan,
                    $row->status_kepegawaian_label,
                    $row->bidang_label,
                    $row->phone ?? '-',
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }
}
