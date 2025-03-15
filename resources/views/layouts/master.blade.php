<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} | Học Lập Trình Để Làm</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            /* Màu cam khi active */
            font-weight: bold;
        }

        /* Tùy chỉnh màu nút thành cam */
        .btn-login {
            background-color: #ff6200;
            border-color: #ff6200;
        }

        .btn-login:hover {
            background-color: #e55a00;
            /* Màu cam đậm hơn khi hover */
            border-color: #e55a00;
        }

        /* Responsive adjustments */
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
                <a class="navbar-brand logo d-flex align-items-center" href="#">
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
                    </ul>

                    <!-- Nút đăng nhập -->
                    <div class="d-flex align-items-center">
                        <a href="/dang-ky" class="btn btn-outline-secondary me-2">Đăng ký</a>
                        <a href="#" class="btn btn-primary btn-login">Đăng nhập</a>
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
