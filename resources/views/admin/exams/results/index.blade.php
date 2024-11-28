@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Quản lý kết quả thi</h1>
    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên người dùng</th>
                    <th>Bài thi</th>
                    <th>Điểm</th>
                    <th>Tổng câu hỏi</th>
                    <th>Ngày thi</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $key => $result)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $result->user->name }}</td>
                        <td>{{ $result->exam->title }}</td>
                        <td>{{ $result->score }}</td>
                        <td>{{ $result->total_questions }}</td>
                        <td>{{ $result->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.exams.results.show', $result->id) }}" class="btn btn-sm btn-primary">Chi tiết</a>
                            <form action="{{ route('admin.exams.results.delete', $result->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $results->links() }}
    </div>
</div>
@endsection
