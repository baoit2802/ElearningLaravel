@extends('layouts.admin')

@section('content')
<h1>Thêm khóa học</h1>
<form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" .>
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label for="courseName">Tên khóa học</label>
        <input type="text" name="courseName" id="courseName" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="details">Thông tin chi tiết</label>
        <textarea class="form-control" id="details" name="details" rows="4"
            placeholder="Nhập thông tin chi tiết khóa học"></textarea>
    </div>
    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Hình ảnh khóa học</label>
            <input type="file" name="image" id="image" class="form-control">

        </div>
        <div class="form-group">
            <label for="price">Giá</label>
            <input type="text" name="price" id="price" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
    @endsection