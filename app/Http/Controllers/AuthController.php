<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\User;
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

            // Log login history
            LoginHistory::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'perangkat' => $this->detectDevice($request->userAgent()),
                'status' => 'berhasil',
                'login_at' => now(),
            ]);

            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Log failed attempt
        if ($user) {
            LoginHistory::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'perangkat' => $this->detectDevice($request->userAgent()),
                'status' => 'gagal',
                'login_at' => now(),
            ]);
        }

        return back()->withErrors([
            'username' => 'Username/NIP atau Password tidak valid.',
        ])->withInput($request->only('username', 'remember'));
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

    private function detectDevice(?string $userAgent): string
    {
        if (!$userAgent) return 'Unknown Device';
        $device = '';
        if (str_contains($userAgent, 'Mobile') || str_contains($userAgent, 'iPhone')) {
            $device = 'Mobile';
        } elseif (str_contains($userAgent, 'Windows')) {
            $device = 'Windows';
        } elseif (str_contains($userAgent, 'Mac')) {
            $device = 'macOS';
        } else {
            $device = 'Desktop';
        }

        $browser = 'Browser';
        if (str_contains($userAgent, 'Chrome')) $browser = 'Chrome';
        elseif (str_contains($userAgent, 'Firefox')) $browser = 'Firefox';
        elseif (str_contains($userAgent, 'Safari')) $browser = 'Safari';
        elseif (str_contains($userAgent, 'Edge')) $browser = 'Edge';

        return "{$browser} on {$device}";
    }
}
