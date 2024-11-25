@extends('layouts.client')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Danh sách bài thi</h1>
    <div class="list-group">
        @foreach($exams as $exam)
        <a href="{{ route('exams.start', $exam->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center shadow-sm mb-3 exam-item">
            <div class="d-flex align-items-start">
                <div class="icon-container me-3">
                    <i class="bi bi-journal-text text-primary" style="font-size: 2rem;"></i>
                </div>
                <div>
                    <h5 class="mb-1 text-primary">{{ $exam->title }}</h5>
                    <p class="mb-1">
                        <span class="d-block"><i class="bi bi-book-fill me-2 text-secondary"></i><strong>Khóa học:</strong> {{ $exam->course->courseName }}</span>
                        <span class="d-block"><i class="bi bi-calendar-event me-2 text-secondary"></i><strong>Bắt đầu:</strong> {{ date('d/m/Y H:i', strtotime($exam->start_time)) }}</span>
                        <span class="d-block"><i class="bi bi-calendar-check me-2 text-secondary"></i><strong>Kết thúc:</strong> {{ date('d/m/Y H:i', strtotime($exam->end_time)) }}</span>
                    </p>
                </div>
            </div>
            <div class="text-end">
                <p><i class="bi bi-clock me-2 text-secondary"></i><strong>Thời gian:</strong> {{ $exam->duration }} phút</p>
                <button class="btn btn-outline-primary">Bắt đầu thi <i class="bi bi-arrow-right ms-1"></i></button>
            </div>
        </a>
        @endforeach
    </div>
</div>