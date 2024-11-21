@extends('layouts.admin')

@section('content')
<h1>Danh sách khóa học</h1>
<a href="{{ route('admin.courses.create') }}" class="btn btn-success">Thêm khóa học</a>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Thông tin chi tiết</th>
            <th>Hình ảnh</th>
            <th>Giá</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->courseName }}</td>
                <td>{{ $course->description }}</td>
                <td><p>{!! nl2br(e($course->details)) !!}</p></td>
                <td>
                    @if($course->image)
                        <img src="{{ asset('public/storage/' . $course->image) }}" alt="{{ $course->courseName }}" width="100">
                    @else
                        <span>Không có hình</span>
                    @endif
                </td>
                <td>{{$course->price}}</td>

                <td>
                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection