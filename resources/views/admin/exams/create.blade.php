@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Thêm bài thi mới</h1>
    {{-- Hiển thị lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form action="{{ route('admin.exams.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề bài thi</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea id="description" name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="course_id" class="form-label">Khóa học</label>
            <select id="course_id" name="course_id" class="form-control" required>
                <option value="">-- Chọn khóa học --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->courseName }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Thời gian bắt đầu</label>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Thời gian kết thúc</label>
            <input type="datetime-local" id="end_time" name="end_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Thời gian làm bài (phút)</label>
            <input type="number" id="duration" name="duration" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-success">Thêm bài thi</button>
        <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection