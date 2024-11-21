@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <h1>Thanh toán khóa học</h1>
    <p><strong>Khóa học:</strong> {{ $registration->course->courseName }}</p>
    <p><strong>Giá:</strong> {{ number_format($registration->amount, 2) }} VND</p>
    <form action="{{ route('courses.processPayment', $registration->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Thanh toán</button>
    </form>
</div>
@endsection
