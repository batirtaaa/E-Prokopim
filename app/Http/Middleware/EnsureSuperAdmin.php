<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    /**
     * Hanya Super Admin yang diizinkan mengakses route yang dilindungi.
     * User biasa akan diredirect ke dashboard dengan pesan error.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'super_admin') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak. Fitur ini hanya untuk Super Admin.'], 403);
            }

            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak. Halaman ini hanya dapat diakses oleh Super Admin.');
        }

        return $next($request);
    }
}
