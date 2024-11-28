<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Lấy danh sách người dùng
        $users = User::where('is_admin', 0)->get();

        // Truyền danh sách người dùng tới view
        return view('admin.notifications.index', compact('users'));
    }

    public function sendNotification(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $decodedMessage = html_entity_decode($request->message);
        $cleanMessage = strip_tags($decodedMessage);

        // Gửi thông báo (logic gửi thông báo)
        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $cleanMessage,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Thông báo đã được gửi!');
    }

    public function getNavbarNotifications()
    {
        // Lấy danh sách thông báo của người dùng đã đăng nhập
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('layouts.client', compact('notifications'));
    }

    public function markAsRead($id)
    {
        // Đánh dấu thông báo là đã đọc
        $notification = Notification::findOrFail($id);

        if ($notification->user_id === Auth::id()) {
            $notification->update(['is_read' => true]);
            return redirect()->back()->with('success', 'Thông báo đã được đánh dấu là đã đọc.');
        }

        return redirect()->back()->with('error', 'Bạn không có quyền truy cập thông báo này.');
    }
}
