<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Return count of unread notifications (for AJAX polling).
     */
    public function count()
    {
        $count = Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Return latest 15 notifications for the dropdown.
     */
    public function index()
    {
        $items = Notifikasi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get()
            ->map(fn($n) => [
                'id'         => $n->id,
                'judul'      => $n->judul,
                'pesan'      => $n->pesan,
                'tipe'       => $n->tipe,
                'link'       => $n->link,
                'is_read'    => $n->is_read,
                'created_at' => $n->created_at->diffForHumans(),
            ]);

        $unread = $items->where('is_read', false)->count();

        return response()->json(['items' => $items, 'unread' => $unread]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notifikasi->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all unread notifications as read.
     */
    public function markAllRead()
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Save notification preferences for the current user.
     */
    public function savePreferences(Request $request)
    {
        $validated = $request->validate([
            'notif_kegiatan' => 'boolean',
            'notif_penugasan' => 'boolean',
            'notif_arahan' => 'boolean',
            'notif_deadline' => 'boolean',
        ]);

        $preferences = [
            'kegiatan'  => (bool) ($validated['notif_kegiatan'] ?? true),
            'penugasan' => (bool) ($validated['notif_penugasan'] ?? true),
            'arahan'    => (bool) ($validated['notif_arahan'] ?? true),
            'deadline'  => (bool) ($validated['notif_deadline'] ?? true),
        ];

        Auth::user()->update(['notification_preferences' => $preferences]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pengaturan notifikasi berhasil disimpan.']);
        }

        return back()->with('success', 'Pengaturan notifikasi berhasil disimpan.');
    }

    /**
     * Helper: create notification for all active users.
     */
    public static function createForAllUsers(string $judul, string $pesan, string $tipe, ?string $link = null): void
    {
        $users = User::where('is_active', true)->pluck('id');

        $rows = $users->map(fn($uid) => [
            'user_id'    => $uid,
            'judul'      => $judul,
            'pesan'      => $pesan,
            'tipe'       => $tipe,
            'link'       => $link,
            'is_read'    => false,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        if (!empty($rows)) {
            Notifikasi::insert($rows);
        }
    }
}
