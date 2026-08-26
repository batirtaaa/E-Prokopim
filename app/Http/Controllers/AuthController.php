<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
            ->orWhere('nip', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        $status = 'gagal';
        if ($user && Hash::check($request->password, $user->password) && $user->is_active) {
            Auth::login($user, $request->remember ?? false);
            $status = 'berhasil';

            // Log login history realtime (WIB)
            LoginHistory::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'perangkat' => self::detectDevice($request->userAgent()),
                'status' => 'berhasil',
                'login_at' => Carbon::now('Asia/Jakarta'),
            ]);

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Log failed attempt realtime (WIB)
        if ($user) {
            LoginHistory::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'perangkat' => self::detectDevice($request->userAgent()),
                'status' => 'gagal',
                'login_at' => Carbon::now('Asia/Jakarta'),
            ]);
        }

        return back()->withErrors([
            'username' => 'Username/NIP atau Password tidak valid.',
        ])->withInput($request->only('username', 'remember'));
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:50|unique:users,username|alpha_dash',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nip' => 'nullable|string|max:30|unique:users,nip',
            'phone' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',
            'username.alpha_dash' => 'Username hanya boleh berupa huruf, angka, tanda hubung (-) dan garis bawah (_).',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email sudah terdaftar.',
            'nip.unique' => 'NIP sudah terdaftar pada akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $user = User::create([
            'name' => trim($validated['name']),
            'username' => strtolower(trim($validated['username'])),
            'email' => strtolower(trim($validated['email'])),
            'nip' => !empty($validated['nip']) ? trim($validated['nip']) : null,
            'phone' => !empty($validated['phone']) ? trim($validated['phone']) : null,
            'jabatan' => !empty($validated['jabatan']) ? trim($validated['jabatan']) : 'Staff Prokopim',
            'role' => 'operator',
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // Auto login akun yang baru terdaftar
        Auth::login($user);

        // Catat riwayat login pertama realtime (WIB)
        LoginHistory::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'perangkat' => self::detectDevice($request->userAgent()),
            'status' => 'berhasil',
            'login_at' => Carbon::now('Asia/Jakarta'),
        ]);

        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Akun berhasil didaftarkan dan tersimpan di database! Selamat datang, ' . $user->name . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public static function detectDevice(?string $userAgent): string
    {
        if (!$userAgent) return 'Perangkat Tidak Dikenal';

        // 1. Detect OS / Platform
        $platform = 'Desktop';
        if (preg_match('/windows nt 10\.0/i', $userAgent)) {
            $platform = 'Windows 10/11';
        } elseif (preg_match('/windows nt 6\.3/i', $userAgent)) {
            $platform = 'Windows 8.1';
        } elseif (preg_match('/windows nt 6\.2/i', $userAgent)) {
            $platform = 'Windows 8';
        } elseif (preg_match('/windows nt 6\.1/i', $userAgent)) {
            $platform = 'Windows 7';
        } elseif (preg_match('/windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/iphone/i', $userAgent)) {
            $platform = 'iPhone (iOS)';
        } elseif (preg_match('/ipad/i', $userAgent)) {
            $platform = 'iPad (iPadOS)';
        } elseif (preg_match('/android/i', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $platform = 'Linux';
        }

        // 2. Detect Browser (Order is critical: Edge, Opera, Brave before Chrome)
        $browser = 'Web Browser';
        if (preg_match('/edg\/|edge\//i', $userAgent)) {
            $browser = 'Microsoft Edge';
        } elseif (preg_match('/opr\/|opera\//i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/brave/i', $userAgent)) {
            $browser = 'Brave';
        } elseif (preg_match('/chrome\/|crios\//i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/firefox\/|fxios\//i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/safari\//i', $userAgent) && !preg_match('/chrome\//i', $userAgent)) {
            $browser = 'Safari';
        }

        return "{$browser} ({$platform})";
    }
}
