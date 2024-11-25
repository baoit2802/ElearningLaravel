@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách bài thi</h1>
    <a href="{{ route('admin.exams.create') }}" class="btn btn-success mb-3">Tạo bài thi</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tiêu đề</th>
                <th>Khóa học</th>
                <th>Mô tả</th>
                <th>Bắt đầu</th>
                <th>Kết thúc</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exams as $exam)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $exam->title }}</td>
                <td>{{ $exam->course->courseName }}</td>
                <td>{{$exam->description}}</td>
                <td>{{ $exam->start_time }}</td>
                <td>{{ $exam->end_time }}</td>
                <td>
                    <a href="{{ route('admin.exams.questions.index', $exam->id) }}" class="btn btn-primary btn-sm">Quản lý câu hỏi</a>
                    <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" style="display:inline;">
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
