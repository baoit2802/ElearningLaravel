@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Quản lý câu hỏi cho bài thi: {{ $exam->title }}</h1>

    <!-- Form thêm câu hỏi mới -->
    <form action="{{ route('admin.exams.questions.store', $exam->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="question_text">Câu hỏi</label>
            <input type="text" id="question_text" name="question_text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Đáp án</label>
            @for($i = 1; $i <= 4; $i++)
            <input type="text" name="answers[]" class="form-control mb-2" placeholder="Đáp án {{ $i }}" required>
            @endfor
        </div>
        <div class="mb-3">
            <label for="correct_answer">Đáp án đúng</label>
            <select id="correct_answer" name="correct_answer" class="form-control" required>
                @for($i = 1; $i <= 4; $i++)
                <option value="{{ $i }}">Đáp án {{ $i }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-success">Thêm câu hỏi</button>
    </form>

    <!-- Danh sách câu hỏi -->
    <h2 class="mt-5">Danh sách câu hỏi</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Câu hỏi</th>
                <th>Đáp án</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exam->questions as $question)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <!-- Form cập nhật câu hỏi -->
                    <form action="{{ route('admin.exams.questions.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="text" name="question_text" class="form-control" value="{{ $question->question_text }}" required>
                        
                        <div class="mt-3">
                            <h6>Đáp án:</h6>
                            @foreach($question->answers as $answer)
                            <div class="d-flex align-items-center mb-2">
                                <input type="text" name="answers[{{ $answer->id }}][answer_text]" class="form-control me-2" value="{{ $answer->answer_text }}" required>
                                <input type="checkbox" name="answers[{{ $answer->id }}][is_correct]" value="1" @if($answer->is_correct) checked @endif>
                                <label class="ms-2">Đúng</label>
                            </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm mt-3">Lưu thay đổi</button>
                    </form>
                </td>
                <td>
                    <!-- Form xóa câu hỏi -->
                    <form action="{{ route('admin.exams.questions.destroy', $question->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
