<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $loginHistories = LoginHistory::where('user_id', $user->id)
            ->orderBy('login_at', 'desc')
            ->take(10)
            ->get();
        return view('profil-admin.index', compact('user', 'loginHistories'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30|unique:users,nip,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);
        $user->update($validated);
        return redirect()->route('profil-admin.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateFoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|mimes:jpg,jpeg,png|max:2048']);
        $user = Auth::user();

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('photos', 'public');
        $user->update(['photo' => $path]);

        return redirect()->route('profil-admin.index')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        return redirect()->route('profil-admin.index')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
