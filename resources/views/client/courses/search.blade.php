@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Kết quả tìm kiếm</h1>
    <p class="text-center">Tìm kiếm từ khóa: <strong>{{ $query }}</strong></p>

    @if($courses->isEmpty())
        <div class="alert alert-warning text-center">Không tìm thấy khóa học nào phù hợp.</div>
    @else
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="course-card">
                        <img src="{{ asset('public/storage/' . $course->image) }}" alt="{{ $course->courseName }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->courseName }}</h5>
                            <p class="card-text">{{ Str::limit($course->description, 100, '...') }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($course->price > 0)
                                        <span class="price">{{ number_format($course->price, 0, ',', '.') }} đ</span>
                                    @else
                                        <span class="price text-success">Miễn phí</span>
                                    @endif
                                </div>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary btn-sm">Xem thông tin</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
