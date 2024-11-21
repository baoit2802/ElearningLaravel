@extends('layouts.admin')

@section('content')
<form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="courseName">Tên khóa học</label>
        <input type="text" name="courseName" id="courseName" value="{{ old('courseName', $course->courseName) }}"
            class="form-control" placeholder="Nhập tên khóa học" required>
    </div>

    <div class="form-group">
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" placeholder="Nhập mô tả"
            class="form-control">{{ old('description', $course->description) }}</textarea>
    </div>
    <div class="form-group">
        <label for="details">Thông tin chi tiết</label>
        <textarea class="form-control" id="details" name="details" rows="4">{{ $course->details }}</textarea>
    </div>


    <div class="form-group">
        <label for="image">Hình ảnh</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
        @if($course->image)
            <img src="{{ asset('public/storage/' . $course->image) }}" alt="Hình hiện tại" width="100">
        @endif
    </div>
    <div class="form-group">
        <label for="price">Giá</label>
        <input type="text" name="price" id="price" placeholder="Nhập giá" value="{{ old('price', $course->price) }}"
            class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>
@endsection