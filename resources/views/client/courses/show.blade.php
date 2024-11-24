@extends('layouts.client')

@section('content')
<div class="course-layout-container mt-5">
    <div class="course-layout-row justify-content-center">
        <!-- Phần thông tin chính -->
        <div class="course-layout-col-main col-8">
            <div class="course-layout-col-side w-100">
                <div class="course-layout-card border-0 shadow-sm">
                    <div class="d-flex justify-content-center align-items-center" style="height: 300px;">

                        <img src="{{ asset('public/storage/' . $course->image) }}" class="course-layout-image"
                            alt="{{ $course->courseName }}">
                    </div>
                </div>
            </div>
            <div class="course-layout-info p-4 rounded">
                <h2 class="course-layout-title fw-bold" style="color: #003366;">{{ $course->courseName }}</h2>
                <p class="course-layout-description mt-3">{{ $course->description }}</p>
                <p class="course-layout-heading fw-bold" style="color: #003366;">Thông tin khóa học:</p>
                <ul class="course-layout-details list-unstyled">
                    @foreach (explode(PHP_EOL, $course->details) as $detail)
                        <li><i class="bi bi-check-circle text-success"></i> {{ trim($detail) }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="course-layout-card-body">
                <div>
                    <h4 class="course-layout-price text-danger fw-bold">
                        @if($course->price > 0)
                            <span class="price">
                                {{ number_format($course->price, 3, ',', '.') }} đ
                            </span>
                        @else
                            <span class="price text-success">Miễn phí</span>
                        @endif
                    </h4>
                </div>
                <div class="course-layout-actions mt-4 d-flex justify-content-between">
                    @if ($course->price == 0)
                        <!-- Nếu khóa học miễn phí -->
                        <form action="{{ route('courses.register', $course->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success">Nhận miễn phí</button>
                        </form>
                    @else
                        <!-- Nếu khóa học có giá -->
                        <form action="{{ route('payment.create', $course->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="price" value="{{ $course->price }}">
                            <button class="btn btn-danger">Mua ngay</button>
                        </form>

                        <form action="{{ route('cart.add', $course->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-dark">Thêm vào giỏ hàng</button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection