@extends('layouts.exam')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{route('exams.list')}}" class="btn btn-dark">Trở về</a>
                    <span class="ml-4 text-gray-900 font-medium text-lg">{{ $exam->title }}</span>
                    <span class="ml-4 text-gray-900 font-medium text-lg">{{$exam->course->courseName}}</span>
                </div>
                <div class="flex items-center bg-gray-100 text-gray-800 px-4 py-2 rounded-md">
                    <i class="far fa-clock mr-2"></i>
                    Thời gian còn lại: <span id="timer" class="font-medium ml-2"></span>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <form id="exam-form" action="{{ route('exams.submit', $exam->id) }}" method="POST">
                @csrf
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Câu hỏi <span
                                id="currentQuestion">{{ $questions->firstItem() }}</span> of {{ $questions->total() }}
                        </h2>
                        <div class="text-sm text-gray-500">Tiến độ: <span class="font-medium"
                                id="answeredCount">0</span>/{{ $questions->total() }}</div>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-custom h-2.5 rounded-full" id="progressBar"
                            style="width: {{ ($questions->firstItem() / $questions->total()) * 100 }}%"></div>
                    </div>
                </div>

                <div class="space-y-8">
                    @foreach ($questions as $question)
                        <div>
                            <p class="text-lg text-gray-900 mb-6">{{ $question->question_text }}</p>
                            <div class="space-y-4">
                                @foreach ($question->answers as $answer)
                                    <label class="flex items-center p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}"
                                            class="h-4 w-4 text-custom border-gray-300 focus:ring-custom"
                                            onchange="saveAnswer({{ $question->id }}, {{ $answer->id }})">
                                        <span class="ml-3 text-gray-900">{{ $answer->answer_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-between pt-6">
                        <!-- Nút Previous -->
                        @if ($questions->currentPage() > 1)
                            <a href="{{ $questions->previousPageUrl() }}"
                                class="btn bg-gray-100 text-gray-700 px-6 py-2 font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                onclick="storeAnswers()">
                                <i class="fas fa-arrow-left mr-2"></i> Trước
                            </a>
                        @endif

                        <!-- Nút Next hoặc Submit -->
                        @if ($questions->hasMorePages())
                            <a href="{{ $questions->nextPageUrl() }}"
                                class="btn bg-custom text-white px-6 py-2 font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom"
                                onclick="storeAnswers()">
                                Tiếp <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @else
                            <button type="submit" id="submitExam"
                                class="btn bg-green-600 text-white px-6 py-2 font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                                Nộp bài
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </main>

</div>


<script>
    const examId = {{ $exam->id }};
    const totalQuestions = {{ $questions->total() }};
    let timeLeft = localStorage.getItem(`exam_${examId}_timeLeft`) || {{ $exam->duration * 60 }};
    const timerDisplay = document.getElementById('timer');

    // Countdown Timer
    function startTimer() {
        setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            if (--timeLeft < 0) {
                clearInterval();
                alert('Time is up! Submitting exam...');
                document.getElementById('exam-form').submit();
            }
            localStorage.setItem(`exam_${examId}_timeLeft`, timeLeft);
        }, 1000);
    }
    startTimer();

    // Save Answer
    function saveAnswer(questionId, answerId) {
        const savedAnswers = JSON.parse(localStorage.getItem(`exam_${examId}`)) || {};
        savedAnswers[questionId] = answerId;
        localStorage.setItem(`exam_${examId}`, JSON.stringify(savedAnswers));
        updateProgress();
    }

    // Update Progress Bar
    function updateProgress() {
        const savedAnswers = JSON.parse(localStorage.getItem(`exam_${examId}`)) || {};
        const answeredCount = Object.keys(savedAnswers).length;
        const progressBar = document.getElementById('progressBar');
        const answeredCountDisplay = document.getElementById('answeredCount');

        // Update progress bar width
        progressBar.style.width = `${(answeredCount / totalQuestions) * 100}%`;

        // Update answered count display
        answeredCountDisplay.textContent = answeredCount;
    }


    // Store Answers When Navigating
    function storeAnswers() {
        document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
            const questionId = input.name.match(/\d+/)[0];
            const answerId = input.value;
            saveAnswer(questionId, answerId);
        });
    }

    //Tải dữ liệu từ local storage khi chuyển trang
    document.addEventListener('DOMContentLoaded', () => {
        const savedAnswers = JSON.parse(localStorage.getItem(`exam_${examId}`)) || {};

        // Đánh dấu các câu trả lời đã chọn
        Object.entries(savedAnswers).forEach(([questionId, answerId]) => {
            const input = document.querySelector(`input[name="answers[${questionId}]"][value="${answerId}"]`);
            if (input) input.checked = true;
        });

        // Cập nhật tiến trình
        updateProgress();
    });


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