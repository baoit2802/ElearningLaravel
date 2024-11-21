@extends('layouts.client')

@section('content')
<div class="container">
    <h1>Khóa học của tôi</h1>
    @if($courses->isEmpty())
        <p>Bạn chưa đăng ký khóa học nào.</p>
    @else
            <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="card course-card">
                        <img src="{{ asset('public/storage/' . $course->image) }}" alt="{{ $course->courseName }}"
                            alt="Card Image" class="card-img-top fixed-image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->courseName }}</h5>
                            <p class="card-text">{{ $course->description }}</p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('videos.show', $course->id) }}" class="btn btn-success">Xem bài giảng khóa
                                    học</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    @endif
</div>
@endsection