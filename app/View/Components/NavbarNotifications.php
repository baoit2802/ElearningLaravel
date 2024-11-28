<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NavbarNotifications extends Component
{
    public $notifications;

    /**
     * Khởi tạo Component
     */
    public function __construct()
    {
        // Lấy thông báo của người dùng hiện tại
        $this->notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Trả về view của Component
     */
    public function render()
    {
        return view('components.navbar-notifications');
    }
}
