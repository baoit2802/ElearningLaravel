@extends('layouts.client')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Phần bên trái -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4 class="text-primary">
                        <i class="bi bi-pencil"></i> {{ $exam->title }}
                    </h4>
                    <hr>
                    <div class="timer mt-3">
                        <h5 class="text-danger"><i class="bi bi-clock"></i> Thời gian còn lại</h5>
                        <h4 id="timer" class="fw-bold"></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phần bên phải -->
        <div class="col-lg-8">
            <form id="exam-form" action="{{ route('exams.submit', $exam->id) }}" method="POST" class="exam-form">
                @csrf
                @foreach ($questions as $question)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="text-dark">
                                <i class="bi bi-question-circle me-2 text-primary"></i>
                                {{ $questions->firstItem() + $loop->index }}. {{ $question->question_text }}
                            </h5>
                            <div class="answers mt-3">
                                @foreach ($question->answers as $answer)
                                    <div class="answer-option form-check">
                                        <input class="form-check-input d-none" type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $answer->id }}" id="answer_{{ $answer->id }}"
                                            onchange="saveAnswer({{ $question->id }}, {{ $answer->id }})">
                                        <label class="answer-label d-flex align-items-center justify-content-between"
                                            for="answer_{{ $answer->id }}">
                                            <span>{{ $answer->answer_text }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Điều hướng phân trang -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    @if ($questions->currentPage() > 1)
                        <a href="{{ $questions->previousPageUrl() }}" onclick="storeCurrentPageAnswers()"
                            class="btn btn-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-2"></i> Quay lại
                        </a>
                    @endif

                    @if ($questions->hasMorePages())
                        <a href="{{ $questions->nextPageUrl() }}" onclick="storeCurrentPageAnswers()"
                            class="btn btn-primary px-4 py-2">
                            Tiếp theo <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    @else
                        <button type="submit" class="btn btn-success px-4 py-2">
                            <i class="bi bi-check-circle-fill me-2"></i> Nộp bài
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .timer {
        background-color: #f8d7da;
        padding: 15px;
        border-radius: 10px;
    }

    .exam-form {
        max-width: 800px;
    }

    .answer-label {
        padding: 12px 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .answer-label:hover {
        background-color: #e6f7ff;
        border-color: #1890ff;
    }

    .form-check-input:checked+.answer-label {
        background-color: #d4edda;
        border-color: #28a745;
    }
</style>

<script>
    const examId = {{ $exam->id }};
    const timerDisplay = document.getElementById('timer');

    // Lấy thời gian từ Local Storage hoặc khởi tạo mặc định
    let timeLeft = localStorage.getItem(`exam_${examId}_timeLeft`) || {{ $exam->duration * 60 }};

    // Lưu thời gian còn lại
    function saveTimeLeft() {
        localStorage.setItem(`exam_${examId}_timeLeft`, timeLeft);
    }

    // Đồng hồ đếm ngược
    document.addEventListener('DOMContentLoaded', function () {
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            if (--timeLeft < 0) {
                clearInterval(timerInterval);
                alert('Hết thời gian làm bài!');
                document.getElementById('exam-form').submit();
            }
            saveTimeLeft();
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    });

    // Lưu câu trả lời vào Local Storage
    function saveAnswer(questionId, answerId) {
        const savedAnswers = JSON.parse(localStorage.getItem(`exam_${examId}`)) || {};
        savedAnswers[questionId] = answerId;
        localStorage.setItem(`exam_${examId}`, JSON.stringify(savedAnswers));
    }

    // Khôi phục câu trả lời từ Local Storage
    document.addEventListener('DOMContentLoaded', function () {
        const savedAnswers = JSON.parse(localStorage.getItem(`exam_${examId}`)) || {};
        Object.entries(savedAnswers).forEach(([questionId, answerId]) => {
            const input = document.querySelector(`input[name="answers[${questionId}]"][value="${answerId}"]`);
            if (input) input.checked = true;
        });
    });

    // Lưu câu trả lời khi chuyển trang
    function storeCurrentPageAnswers() {
        document.querySelectorAll('.form-check-input:checked').forEach(input => {
            saveAnswer(input.name.match(/\d+/)[0], input.value);
        });
    }

    // Gửi các câu trả lời từ Local Storage khi nộp bài
    document.getElementById('exam-form').addEventListener('submit', function () {
        const savedAnswers = JSON.parse(localStorage.getItem(`exam_${examId}`)) || {};
        for (const [questionId, answerId] of Object.entries(savedAnswers)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `answers[${questionId}]`;
            input.value = answerId;
            this.appendChild(input);
        }
        localStorage.removeItem(`exam_${examId}`);
        localStorage.removeItem(`exam_${examId}_timeLeft`);
    });
</script>


@endsection