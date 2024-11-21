@extends('layouts.admin')

@section('content')
<h1>Chỉnh sửa người dùng</h1>
<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Tên:</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password"class="form-control" >
    </div>
    <div class="form-group">
        <label for="password_confirmation">Xác nhận mật khẩu:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>
@endsection