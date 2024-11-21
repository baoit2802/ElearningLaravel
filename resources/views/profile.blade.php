@extends('layouts.client') 

@section('content')
<div class="container">
    <h1>Profile</h1>
    <div class="row">
        <div class="col-md-4 text-center">
        <img src="{{ auth()->user()->avatar_url ? asset('public/storage/' . auth()->user()->avatar_url) : asset('storage/avatars/default-avatar.png') }}"  
                 alt="Avatar" 
                 style="width: 150px; height: 150px; border-radius: 50%;">
            <form action="{{ route('profile.updateAvatar') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                <input type="file" name="avatar" accept="image/*" class="form-control mb-2">
                <button type="submit" class="btn btn-primary">Update Avatar</button>
            </form>
        </div>
        <div class="col-md-8">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Tên</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ auth()->user()->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ auth()->user()->email }}" required>
                </div>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
