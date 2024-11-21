@extends('layouts.admin')

@section('content')
<h1>Quản lý Video</h1>
<a href="{{ route('admin.videos.create') }}" class="btn btn-success">Thêm Video</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khóa học</th>
            <th>Tiêu đề</th>
            <th>URL</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($videos as $video)
        <tr>
            <td>{{ $video->id }}</td>
            <td>{{ $video->course->courseName }}</td>
            <td>{{ $video->title }}</td>
            <td><a href="{{ $video->video_url }}" target="_blank">Xem Video</a></td>
            <td>
                <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-warning">Sửa</a>
                <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" style="display:inline;">
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
