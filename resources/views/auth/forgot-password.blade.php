@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Quên Mật Khẩu</h2>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <p>Bạn quên mật khẩu? Hãy nhập email để gửi lại mật khẩu</p>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Gửi lại mật khẩu</button>
    </form>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

</div>
@endsection