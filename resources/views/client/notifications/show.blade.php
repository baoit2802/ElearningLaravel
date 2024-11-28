@extends('layouts.clients')

@section('content')
<div class="container mt-4">
    <h2>Thông báo</h2>
    <div class="dropdown-menu dropdown-menu-end" style="width: 100%; max-height: 400px; overflow-y: auto;">
        @forelse ($notifications as $notification)
            <div class="card-notification w-100">
                <div class="container-notification">
                    <div class="left">
                        <div class="status-ind {{ $notification->is_read ? '' : 'bg-danger' }}"></div>
                    </div>
                    <div class="right">
                        <div class="text-wrap">
                            <p class="text-content">
                                {{ $notification->title }}
                            </p>
                            <p class="time">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="button-wrap">
                            <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                                @csrf
                                <button type="submit" class="secondary-cta">Đánh dấu đã đọc</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center p-2">Không có thông báo nào.</p>
        @endforelse
    </div>
</div>
@endsection
