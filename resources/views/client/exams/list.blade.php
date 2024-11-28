@extends('layouts.client')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center text-primary fw-bold">Danh sách bài thi</h1>
    <div class="list-group">
        @foreach($exams as $exam)
        <a href="{{ route('exams.start', $exam->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center shadow-sm mb-3 exam-item border-0 rounded-lg">
            <div class="d-flex align-items-start">
                <div class="icon-container me-3">
                    <i class="bi bi-journal-text text-info" style="font-size: 2rem;"></i>
                </div>
                <div>
                    <h5 class="mb-2 text-dark fw-bold">{{ $exam->title }}</h5>
                    <p class="mb-1 text-muted">
                        <span class="d-block mb-1"><i class="bi bi-book-fill me-2 text-secondary"></i><strong>Khóa học:</strong> {{ $exam->course->courseName }}</span>
                        <span class="d-block mb-1"><i class="bi bi-calendar-event me-2 text-secondary"></i><strong>Bắt đầu:</strong> {{ date('d/m/Y H:i', strtotime($exam->start_time)) }}</span>
                        <span class="d-block mb-1"><i class="bi bi-calendar-check me-2 text-secondary"></i><strong>Kết thúc:</strong> {{ date('d/m/Y H:i', strtotime($exam->end_time)) }}</span>
                    </p>
                </div>
            </div>
            <div class="text-end">
                <p class="text-muted mb-2"><i class="bi bi-clock me-2 text-secondary"></i><strong>Thời gian:</strong> {{ $exam->duration }} phút</p>
                <button class="btn btn-info text-white fw-bold">Bắt đầu thi <i class="bi bi-arrow-right ms-1"></i></button>
            </div>
        </a>
        @endforeach
    </div>
</div>

<style>
    .list-group-item {
        background-color: #f9f9f9;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .list-group-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        background-color: #f4f8fc;
    }

    .exam-item h5 {
        font-size: 1.25rem;
        color: #0d6efd;
        transition: color 0.2s ease-in-out;
    }

    .exam-item h5:hover {
        color: #0056b3;
    }

    .exam-item .btn-outline-primary {
        transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
    }

    .exam-item .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .icon-container {
        min-width: 50px;
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #eaf4fc;
        border-radius: 50%;
    }
</style>
@endsection
