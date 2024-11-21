@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Quản lý đăng ký khóa học</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người dùng</th>
                <th>Khóa học</th>
                <th>Số tiền</th>
                <th>Trạng thái</th>
                <th>Ngày đăng ký</th>
                <th>Thao tác </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registrations as $registration)
                <tr>
                    <td>{{ $registration->id }}</td>
                    <td>{{ $registration->user->name }}</td>
                    <td>{{ $registration->course->courseName }}</td>
                    <td>{{ number_format($registration->amount, 2) }} VND</td>
                    <td>{{ ucfirst($registration->status) }}</td>
                    <td>{{ $registration->created_at }}</td>
                    <td>
                        <form action="{{ route('admin.registrations.destroy', $registration->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa đăng ký này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection