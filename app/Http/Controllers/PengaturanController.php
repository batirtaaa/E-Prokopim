<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\User;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function index()
    {
        $instansi = Instansi::first();
        $users = User::withCount('loginHistories')->orderBy('name')->paginate(10);
        return view('pengaturan.index', compact('instansi', 'users'));
    }

    public function updateInstansi(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'pemerintah_daerah' => 'required|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'email_kontak' => 'nullable|email|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        $instansi = Instansi::first();
        if ($instansi) {
            $instansi->update($validated);
        } else {
            Instansi::create($validated);
        }

        return redirect()->route('pengaturan.index', ['tab' => 'profil-instansi'])
            ->with('success', 'Profil instansi berhasil diperbarui.');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:30|unique:users',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:255',
            'role' => 'required|in:super_admin,admin,operator,personel',
            'password' => 'required|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('pengaturan.index', ['tab' => 'manajemen-pengguna'])
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('pengaturan.index', ['tab' => 'manajemen-pengguna'])
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status pengguna berhasil diubah.');
    }
}
