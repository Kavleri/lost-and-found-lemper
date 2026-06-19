<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Tampilkan semua notifikasi
     */
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return view('notif.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sebagai dibaca');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca');
    }

    /**
     * Hapus notifikasi
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->delete();

        return back()->with('success', 'Notifikasi dihapus');
    }
}
