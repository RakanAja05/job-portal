<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display all notifications for admin
     */
    public function index()
    {
        $notifications = Notification::with(['user', 'application.user', 'application.job'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $unreadCount = $notifications->where('is_read', false)->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return redirect()->back();
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca!');
    }
}
