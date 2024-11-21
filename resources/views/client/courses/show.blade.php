@extends('layouts.client')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <h3 class="CourseName text-center">{{ $course->courseName }}</h3>
            <p>{{ $course->description }}</p>
            <img class="card-img-top" style="height: 300px; width: 50%;"
                src="{{ asset('public/storage/' . $course->image) }}" alt="{{ $course->courseName }}" />
        </div>

        <div class="col-lg-4 col-md-4">
            <div class="card text-start">
                <div class="card-body">
                    <h4 class="card-title">{{ $course->courseName }}</h4>
                    <p class="card-text">Khóa học bao gồm:</p>
                    <p>{!! nl2br(e($course->details)) !!}</p>
                    <div class="d-flex">
                        <form action="{{ route('courses.register', $course->id) }}" method="POST" class="m-4">
                            @csrf
                            <button type="submit" class="btn btn-success">Mua ngay</button>
                        </form>
                        <form action="{{ route('cart.add', $course->id) }}" method="POST" class="m-4">
                            @csrf
                            <button type="submit" class="btn btn-dark">Thêm vào giỏ hàng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

@endsection