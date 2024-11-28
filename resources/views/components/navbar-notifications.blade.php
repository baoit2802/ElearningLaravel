<div class="dropdown">
    <a class="btn btn-light dropdown-toggle" href="#" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-bell"></i>
        @if($notifications->where('is_read', false)->count() > 0)
            <span class="badge bg-danger">{{ $notifications->where('is_read', false)->count() }}</span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
        @forelse ($notifications as $notification)
            <li class="dropdown-item card-notification w-100">
                <div class="container-notification">
                    <div class="left">
                        <div class="status-ind {{ $notification->is_read ? 'bg-success' : 'bg-danger' }}"></div>
                    </div>
                    <div class="right">
                        <div class="text-wrap">
                            <p class="text-content">
                                <strong>{{ $notification->title }}</strong><br>
                                {{ $notification->message }}
                            </p>
                            <p class="time">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="button-wrap">
                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="secondary-cta">Đánh dấu đã đọc</button>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="dropdown-item text-center">Không có thông báo nào</li>
        @endforelse
    </ul>
</div>
