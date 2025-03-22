<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} | Học Lập Trình Để Làm</title>
    <link rel="icon" type="image/png" sizes="32x32" href="https://fullstack.edu.vn/favicon/favicon_32x32.png">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- FontAwesome 6 Free CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .header {
            background-color: #fff;
            padding: 5px 0;
            border-bottom: 1px solid #e5e5e5;
        }

        .logo img {
            width: 40px;
            height: 40px;
        }

        .logo span {
            font-size: 1.25rem;
            font-weight: bold;
            margin-left: 10px;
            color: #333;
        }

        .navbar-nav .nav-link {
            color: #333;
            font-weight: 500;
            padding: 10px 15px;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ff6200;
        }

        .navbar-nav .nav-link.active {
            color: #ff6200;
            font-weight: bold;
        }

        .btn-login {
            background-color: #ff6200;
            border-color: #ff6200;
        }

        .btn-login:hover {
            background-color: #e55a00;
            border-color: #e55a00;
        }

        @media (max-width: 991px) {
            .btn-login {
                margin-left: 0;
                width: 100%;
            }
        }

        /* CSS cho avatar và dropdown */
        .avatar-container {
            position: relative;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
        }

        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
            padding: 10px;
        }

        .dropdown-menu .dropdown-item {
            padding: 10px 15px;
            border-radius: 5px;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f0f2f5;
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .user-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-info .user-name {
            font-weight: bold;
            font-size: 16px;
        }

        .user-info .user-handle {
            color: #606770;
            font-size: 14px;
        }

        /* CSS cho dropdown của "Khoá học của tôi" */
        .courses-dropdown {
            width: 300px;
            padding: 15px;
        }

        .courses-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .courses-header h6 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .courses-header a {
            color: #ff6200;
            text-decoration: none;
            font-size: 14px;
        }

        .course-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .course-item:last-child {
            border-bottom: none;
        }

        .course-item img {
            width: 60px;
            height: 40px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .course-info h6 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        .course-info p {
            margin: 0;
            font-size: 12px;
            color: #606770;
        }
    </style>
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand logo d-flex align-items-center" href="/">
                    <img src="https://fullstack.edu.vn/assets/f8-icon-lV2rGpF0.png" alt="Logo">
                    <span>Học Lập Trình Để Làm</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Lộ trình</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Bài viết</a>
                        </li>
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin') }}">Admin</a>
                            </li>
                        @endif
                    </ul>

                    <div class="d-flex align-items-center">
                        @if (Auth::check())
                            <div class="me-3 d-flex">
                                <div class="dropdown">
                                    <button class="border-0 dropdown-toggle"
                                        style="padding: 5px 10px; background-color: #FFFFFF;" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Khoá học của tôi
                                    </button>
                                    <ul class="dropdown-menu courses-dropdown dropdown-menu-end">
                                        <li class="courses-header">
                                            <h6>Khoá học của tui</h6>
                                            <a href="#">Xem tất cả</a>
                                        </li>
                                        <li class="course-item">
                                            <img src="https://via.placeholder.com/60x40" alt="Course Image">
                                            <div class="course-info">
                                                <h6>Kiến Thức Nhập Môn IT</h6>
                                                <p>Bạn chưa học khoá này<br>Bắt đầu học</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <button class="border-0" style="padding: 5px 10px; background-color: #FFFFFF;">
                                        <i class="fa-solid fa-bell"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="avatar-container">
                                <img src="https://fullstack.edu.vn/assets/f8-icon-lV2rGpF0.png" class="avatar"
                                    alt="Avatar" data-bs-toggle="dropdown" aria-expanded="false">
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li class="user-info">
                                        <img src="https://fullstack.edu.vn/assets/f8-icon-lV2rGpF0.png"
                                            alt="User Avatar">
                                        <div>
                                            <div class="user-name">{{ Auth::user()->username }}</div>
                                            <div class="user-handle">{{ Auth::user()->username }}</div>
                                        </div>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Trang cá nhân</a></li>
                                    <li><a class="dropdown-item" href="#">Viết blog</a></li>
                                    <li><a class="dropdown-item" href="#">Bài viết của tui</a></li>
                                    <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Đăng xuất
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li> 
                                </ul>
                            </div>
                        @else
                            <a href="/register" class="btn btn-outline-secondary me-2">Đăng ký</a>
                            <a href="/dang-nhap" class="btn btn-primary btn-login">Đăng nhập</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container-fluid mt-3">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
