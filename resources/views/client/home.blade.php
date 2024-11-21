@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h1 class="mb-5">Khóa học phổ biến</h1>
    </div>
    <div class="row">
        @foreach ($courses as $course)
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="card course-card">
                    <img src="{{asset('/public/storage/' . $course->image) }} alt=" {{ $course->courseName }}" width="100"" 
                            alt=" {{ $course->courseName }}" class="card-img-top fixed-image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->courseName }}</h5>
                        <p class="card-text">{{ $course->description }}</p>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('videos.show', $course->id) }}"" class="btn btn-success">Đăng ký</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection