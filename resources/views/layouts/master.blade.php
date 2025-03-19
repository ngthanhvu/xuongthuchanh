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
    <!-- boostrap icon -->
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
            /* Màu cam khi hover */
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
    </style>
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand logo d-flex align-items-center" href="/">
                    <img src="https://fullstack.edu.vn/assets/f8-icon-lV2rGpF0.png" alt="Logo">
                    <span>Học Lập Trình Để Làm</span>
                </a>

                <!-- Toggle button for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar content -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Menu -->
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
                        
                        @if(Auth::check() && Auth::user()->role === 'admin')
                        <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin') }}">Admin</a>
                            </li>
                        @endif

                    </ul>

                    <!-- Nút đăng nhập -->
               
                    <div class="d-flex align-items-center">
                        @if(Auth::check())
                            <span class="me-3">Xin chào, {{ Auth::user()->fullname }}</span>
                            <a href="{{ route('logout') }}" class="btn btn-danger"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
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

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
