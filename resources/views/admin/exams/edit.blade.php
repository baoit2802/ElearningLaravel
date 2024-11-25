@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh sửa bài thi: {{ $exam->title }}</h1>

    <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Tên bài thi</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $exam->title) }}"
                required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="course_id" class="form-label">Khóa học</label>
            <select id="course_id" name="course_id" class="form-control" required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @if($course->id == $exam->course_id) selected @endif>
                        {{ $course->courseName }}</option>
                @endforeach
            </select>
            @error('course_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea id="description" name="description" class="form-control"
                rows="4">{{ old('description', $exam->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Thời gian bắt đầu</label>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control"
                value="{{ old('start_time', \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d\TH:i')) }}"
                required>
            @error('start_time')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Thời gian kết thúc</label>
            <input type="datetime-local" id="end_time" name="end_time" class="form-control"
                value="{{ old('end_time', \Carbon\Carbon::parse($exam->end_time)->format('Y-m-d\TH:i')) }}" required>
            @error('end_time')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Thời gian làm bài (phút)</label>
            <input type="number" id="duration" name="duration" class="form-control"
                value="{{ old('duration', $exam->duration) }}" min="1" required>
            @error('duration')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật bài thi</button>
    </form>
</div>
@endsection