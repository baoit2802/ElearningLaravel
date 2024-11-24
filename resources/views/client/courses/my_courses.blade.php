@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <div class="text-center">
        <h1 class="mb-5">Khóa học của tôi</h1>
    </div>
    @if($courses->isEmpty())
        <div class="alert alert-warning text-center">
            Bạn chưa đăng ký khóa học nào.
        </div>
    @else
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 py-3 px-1">
                    <div class="course-card h-100 shadow-sm rounded overflow-hidden">
                        <!-- Hình ảnh khóa học -->
                        <div class="image-container" style="overflow: hidden; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <img src="{{ asset('public/storage/' . $course->image) }}" 
                                alt="{{ $course->courseName }}" 
                                class="card-img-top" 
                                style="height: 180px; width: 100%; object-fit: cover;">
                        </div>
                        
                        <!-- Nội dung khóa học -->
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="{{ $course->courseName }}">
                                {{ $course->courseName }}
                            </h5>
                            <p class="card-text text-muted">
                                {{ \Illuminate\Support\Str::limit($course->description, 100, '...') }}
                            </p>
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{ route('videos.show', $course->id) }}" class="btn btn-primary btn-sm">Xem bài giảng</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
