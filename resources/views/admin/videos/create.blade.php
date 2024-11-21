@extends('layouts.admin')

@section('content')
<h1>Thêm Video</h1>
<form action="{{ route('admin.videos.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="course_id">Khóa học</label>
        <select name="course_id" id="course_id" class="form-control">
            @foreach($courses as $course)
            <option value="{{ $course->id }}">{{ $course->courseName }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="title">Tiêu đề</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="video_url">URL Video</label>
        <input type="url" name="video_url" id="video_url" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Thêm</button>
</form>
@endsection
