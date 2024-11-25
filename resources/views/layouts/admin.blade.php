<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="{{ asset('public/css/admin.css') }}" rel="stylesheet">
</head>
<style>
    td {
        max-width: 400px;
    }
</style>


<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="{{route('home')}}">Elearning</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{route('admin.home')}}" class="sidebar-link">
                        <i class="fa-solid fa-home"></i>
                        <span>Trang chủ người dùng</span>
                    </a>
                </li>



                <li class="sidebar-item">
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-user"></i>
                        <span>User</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{route('admin.registrations.index')}}" class="sidebar-link">
                        <i class="fa-solid fa-book-medical"></i>
                        <span>Register Course</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="fa-solid fa-book-open"></i>
                        <span>Course</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{route('admin.videos.index')}}" class="sidebar-link"><i
                                    class="fa-solid fa-circle-info"></i>Video</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.courses.index')}}" class="sidebar-link"><i
                                    class="fa-solid fa-user"></i>Course</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#contest" aria-expanded="false" aria-controls="contest">
                        <i class="fa-solid fa-trophy"></i>
                        <span>Contest</span>
                    </a>
                    <ul id="contest" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{route('admin.exams.index')}}" class="sidebar-link">
                                <i class="fa-solid fa-circle-info"></i>All Contests
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                <i class="fa-solid fa-user-plus"></i>Result
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fa-solid fa-envelope"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fa-solid fa-gear"></i>
                        <span>Setting</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout"><i class="fa-solid fa-right-to-bracket"></i> Log
                        out</i> </button>
                </form>
            </div>
        </aside>
        <div class="main">
            <main class="content px-3 py-4">
                <div class="toast-container position-fixed p-3" style="z-index: 1055; top: 20px; right: 20px; ">
                    @if (session('success'))
                        <div class="toast align-items-center text-bg-success border-0 show" role="alert"
                            aria-live="assertive" aria-atomic="true">
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
                        <div class="toast align-items-center text-bg-danger border-0 show" role="alert"
                            aria-live="assertive" aria-atomic="true">
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
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('public/js/admin.js') }}"></script>
</body>

</html>