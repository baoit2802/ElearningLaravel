<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="{{route('home')}}">Logo</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="container-fluid">
                        <form class="d-flex justify-content-center" action="{{ route('courses.search') }}" method="GET"
                            role="search">
                            <input class="form-control me-2 searchArea w-50" type="search" name="query"
                                placeholder="Tìm kiếm khóa học" aria-label="Search" required>
                            <button class="btn btn-outline-success" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>

                    </div>
                    <div class="container-fluid">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item"><a class="nav-link mx-lg-2" href="{{route('courses.index')}}">Trang
                                    chủ</a></li>
                            <li class="nav-item"><a class="nav-link mx-lg-2" href="{{route('courses.my_courses')}}">Khóa
                                    học</a></li>
                            <li class="nav-item"><a class="nav-link mx-lg-2" href="{{route('cart.index')}}">Giỏ hàng</a>
                            </li>
                            <li class="nav-item"><a class="nav-link mx-lg-2" href="#">Cuộc
                                    thi</a></li>
                            <li class="nav-item"><a class="nav-link mx-lg-2" href="#">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-success me-2">Về trang quản lý</a>
                @endif
            @endauth
            <!-- Hiển thị Login hoặc Avatar -->
            @guest
                <a href="{{ route('login') }}" class="login-button">Login</a>
            @endguest
            @auth
                <div class="avatar-dropdown">
                    <a href="#" id="avatarDropdownToggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ auth()->user()->avatar_url ? asset('public/storage/' . auth()->user()->avatar_url) : asset('storage/avatars/default-avatar.png') }}"
                            alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end avatar-dropdown-menu" aria-labelledby="avatarDropdownToggle">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>

            @endauth
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="toast-container position-fixed p-3" style="z-index: 1055; top: 20px; right: 20px">
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>


    @yield('content')

    <footer class="text-light pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-4 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold">About</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" />
                    <p>Nền tảng học tập trực tuyến cung cấp các khóa học đa dạng với sự hỗ trợ tận tâm từ các giảng viên
                        chuyên nghiệp.</p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold">Khóa học</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" />
                    <p><a href="#!" class="text-light">Lập trình cơ bản</a></p>
                    <p><a href="#!" class="text-light">Lập trình java</a></p>
                    <p><a href="#!" class="text-light">Cơ sở dữ liệu</a></p>
                    <p><a href="#!" class="text-light">Lập trình web</a></p>
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold">Liên kết</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" />
                    <p><a href="#!" class="text-light">Tài khoản của tôi</a></p>
                    <p><a href="#!" class="text-light">Hỗ trợ</a></p>
                    <p><a href="#!" class="text-light">Chính sách bảo mật</a></p>
                    <p><a href="#!" class="text-light">Điều khoản dịch vụ</a></p>
                </div>

                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold">Liên hệ</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" />
                    <p><i class="fas fa-home mr-3"></i> Hòa Quý ,Ngũ Hành Sơn, Đà Nẵng, Việt Nam</p>
                    <p><i class="fas fa-envelope mr-3"></i> baohuynh0411@gmail.com</p>
                    <p><i class="fas fa-phone mr-3"></i> + 84 123 456 789</p>
                </div>
            </div>
        </div>

        <div class="text-center p-3" style="background-color:white;">
            <p>© 2024 Online Learning. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('public/js/app.js') }}"></script>
</body>

</html>