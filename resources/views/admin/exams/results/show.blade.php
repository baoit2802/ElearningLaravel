@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <a href="{{route('admin.exams.results.index')}}" class="btn btn-dark">Trở về</a>
    <h1 class="text-center">Chi tiết kết quả thi</h1>

    <div class="card mt-4">
        <div class="card-header">
            <h4>Bài thi: {{ $result->exam->title }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Người dùng:</strong> {{ $result->user->name }}</p>
            <p><strong>Điểm:</strong> {{ $result->score }} / {{ $result->total_questions }}</p>
            <p><strong>Ngày làm bài:</strong> {{ $result->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="mt-4">
        <h5>Các câu trả lời:</h5>
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Câu hỏi</th>
                    <th>Đáp án đã chọn</th>
                    <th>Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result->userAnswers as $key => $answer)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $answer->question->question_text }}</td>
                        <td>{{ $answer->answer->answer_text }}</td>
                        <td>
                            @if($answer->answer->is_correct)
                                <span class="badge bg-success">Đúng</span>
                            @else
                                <span class="badge bg-danger">Sai</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
