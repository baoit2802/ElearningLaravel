@extends('layouts.client')
@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
            style="background: #103cbe;">
            <div class="featured-image mb-3">
                <img src="#" class="img-fluid" style="width: 250px;">
            </div>
            <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be
                Verified</p>
            <small class="text-white text-wrap text-center"
                style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Please verify your
                identity.</small>
        </div>

        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                </div>
                <form action="{{ route('login') }}" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control form-control-lg bg-light fs-6"
                            placeholder="Email" required>
                    </div>
                    <div class="input-group mb-1">
                        <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password"
                            required>
                    </div>
                    <div class="input-group mb-5 d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="formCheck">
                            <label for="formCheck" class="form-check-label text-secondary"><small>Remember
                                    Me</small></label>
                        </div>
                        <div class="forgot">
                            <small><a href="#">Forgot Password?</a></small>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Đăng nhập</button>
                    </div>
                    @csrf
                </form>
                @if (session('msg'))
                    <div class="alert alert-danger">
                        {{ session('msg') }}
                    </div>
                @endif
                <div class="input-group mb-3">
                    <button class="btn btn-lg btn-light w-100 fs-6"><img src="#" style="width:20px"
                            class="me-2"><small>Sign In with Google</small></button>
                </div>
                <div class="row">
                    <small>Don't have account? <a href="#">Sign Up</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection