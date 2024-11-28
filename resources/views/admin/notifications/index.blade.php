@extends('layouts.admin')

@section('content')
<h4>Gửi thông báo tới người dùng</h4>
<form action="{{ route('admin.sendNotification') }}" method="POST" class="form-control">
    @csrf
    <label for="user_id">Chọn Người Dùng:</label>
    <select name="user_id" id="user_id" class="form-select" required>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
    <label for="title">Tiêu đề:</label>
    <input type="text" name="title" class="form-control" required>
    <label for="message">Nội dung:</label>
    <textarea name="message" class="form-control" required></textarea>
    <button type="submit" class="btn btn-primary mt-3">Gửi Thông Báo</button>
</form>
<script>
    CKEDITOR.replace('message', {
        allowedContent: true,
        entities: false
    });
</script>
@endsection