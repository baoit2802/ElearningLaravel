@extends('layouts.app')

@section('content')
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <!-- Left Box -->
        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
            style="background: #103cbe;">
            <div class="featured-image mb-3">
                <img src="{{asset('public/storage/backgrounds/1.png')}}" class="img-fluid" style="width: 250px;">
            </div>
            <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Sign Up</p>
            <small class="text-white text-wrap text-center"
                style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Nhập thông tin đăng ký</small>
        </div>

        <!-- Right Box -->
        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                </div>
                <form action="{{route('register')}}" method="POST">
                    @csrf
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label fs-6">Tên</label>
                        <input type="text" class="form-control form-control-lg bg-light" id="name" name="name"
                            placeholder="Tên" required>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label fs-6">Email</label>
                        <input type="email" class="form-control form-control-lg bg-light" id="email" name="email"
                            placeholder="Email" required>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label fs-6">Mật khẩu</label>
                        <input type="password" class="form-control form-control-lg bg-light" id="password" name="password"
                            placeholder="Mật khẩu">
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fs-6">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control form-control-lg bg-light" id="password_confirmation"
                            name="password_confirmation" placeholder="Xác nhận mật khẩu">
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3">
                        <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Đăng ký</button>
                    </div>

                    <!-- Google Sign Up Button -->
                    <div class="mb-3">
                        <button class="btn btn-lg btn-light w-100 fs-6">
                            <img src="{{asset('public/storage/backgrounds/google.png')}}" style="width:20px" class="me-2">
                            <small>Sign Up with Google</small>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="row">
                    <small>You have account? <a href="{{route('login')}}">Login</a></small>
                </div>
            </div>
        </div>
    </div>
@endsection
