@extends('layouts.client')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h1 class="text-primary">
                <i class="bi bi-award-fill"></i> {{ $message }}
            </h1>
            <h3 class="mt-3">Bài thi: {{ $exam->title }}</h3>
            <p class="mt-4">
                <strong>Điểm của bạn:</strong> {{ $score }} / {{ $totalQuestions }}
            </p>
            <div class="mt-4">
                <a href="{{ route('exams.list') }}" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-arrow-left"></i> Trở về danh sách bài thi
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 10px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
@endsection
