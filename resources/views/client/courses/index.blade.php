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
                    <img src="{{ asset('public/storage/' . $course->image) }}" alt="{{ $course->courseName }}"
                        alt="Card Image" class="card-img-top fixed-image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->courseName }}</h5>
                        <p class="card-text">{{ Str::limit($course->description, 100, '...') }}</p>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-success">Xem thông tin</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection