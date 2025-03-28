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
    <!-- iziToast -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }



        .footer {
            background-color: #1a1a1a;
            padding: 40px 20px;
            border-top: 1px solid #333;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
            margin-bottom: 20px;
        }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #fff;
        }

        .footer-column p {
            font-size: 14px;
            line-height: 1.6;
            color: #ccc;
            margin-bottom: 8px;
        }

        .footer-column .logo {
            color: #ff6200;
            font-weight: bold;
            font-size: 24px;
        }

        .dmca img {
            margin-top: 10px;
            width: 100px;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 20px auto 0;
            border-top: 1px solid #333;
            padding-top: 20px;
        }

        .copyright {
            font-size: 14px;
            color: #ccc;
        }

        .social-icons {
            display: flex;
            gap: 10px;
        }

        .social-icons img {
            width: 24px;
            height: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .footer-column {
                margin-bottom: 30px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 10px;
            }
        }

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

        .new-pricex {
            color: #ff6200;
            font-size: 18px;
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
                            <a class="nav-link" href="/post">Bài viết</a>
                        </li>
                        @if ((Auth::check() && Auth::user()->role === 'admin') || Auth::user()->role === 'owner')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin') }}">Admin</a>
                            </li>
                        @endif
                    </ul>

                    <div class="d-flex align-items-center">
                        @if (Auth::check())
                            <div class="me-3 d-flex">
                                <div class="dropdown">
                                    @if (isset($enrollments) && $enrollments->where('user_id', Auth::id())->isNotEmpty())
                                        <button class="border-0 dropdown-toggle"
                                            style="padding: 5px 10px; background-color: #FFFFFF;"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Khoá học của tôi
                                        </button>
                                        <ul class="dropdown-menu courses-dropdown dropdown-menu-end">
                                            <li class="courses-header">
                                                <h6>Khoá học của tui</h6>
                                                <a href="#">Xem tất cả</a>
                                            </li>
                                            @foreach ($enrollments->where('user_id', Auth::id()) as $enrollment)
                                                @php
                                                    $course = $courses->firstWhere('id', $enrollment->course_id);
                                                @endphp
                                                @if ($course)
                                                    <li class="course-item">
                                                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                            alt="Course thumbnail">
                                                        <div class="course-info">
                                                            <h6>{{ $course->title }}</h6>
                                                            {{-- <p>Tiến độ <br><a href="{{ route('lessons', ['id' => $course->id]) }}">Bắt đầu học</a></p> --}}
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div>
                                    <button class="border-0" style="padding: 5px 10px; background-color: #FFFFFF;">
                                        <i class="fa-solid fa-bell"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="avatar-container">
                                <img src="@if (Auth::user()->avatar) {{ asset(Auth::user()->avatar) }} @else https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g @endif"
                                    class="avatar" alt="Avatar" data-bs-toggle="dropdown" aria-expanded="false">
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li class="user-info">
                                        <img src="@if (Auth::user()->avatar) {{ asset(Auth::user()->avatar) }} @else https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g @endif"
                                            alt="User Avatar">
                                        <div>
                                            <div class="user-name">{{ Auth::user()->username }}</div>
                                            <div class="user-handle">{{ Auth::user()->username }}</div>
                                        </div>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('/profile') }}">Trang cá nhân</a></li>
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
    <div class="container-fluid mt-3" style="min-height: calc(100vh - 100px);">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="footer-container">
            <!-- Cột 1 -->
            <div class="footer-column">
                <h3><span class="logo">F8</span> Học Lập Trình Để Đi Làm</h3>
                <p><strong>Điện thoại:</strong> 08 1919 8939</p>
                <p><strong>Email:</strong> contact@fullstack.edu.vn</p>
                <p><strong>Địa chỉ:</strong> Số 61, ngõ 41, Trần Duy Hưng, Cầu Giấy, Hà Nội</p>
                <div class="dmca">
                    <img src="data:image/png;base64,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"
                        alt="DMCA Protected">
                </div>
            </div>

            <!-- Cột 2 -->
            <div class="footer-column">
                <h3>Về F8</h3>
                <p>Giới thiệu</p>
                <p>Liên hệ</p>
                <p>Điều khoản</p>
                <p>Bảo mật</p>
            </div>

            <!-- Cột 3 -->
            <div class="footer-column">
                <h3>Sản Phẩm</h3>
                <p>Game Nester</p>
                <p>Game CSS Diner</p>
                <p>Game CSS Selectors</p>
                <p>Game Froggy</p>
                <p>Game Froggy Pro</p>
                <p>Game Scoops</p>
            </div>

            <!-- Cột 4 -->
            <div class="footer-column">
                <h3>Công Cụ</h3>
                <p>Tạo CV xin việc</p>
                <p>Rút gọn liên kết</p>
                <p>Clip-path maker</p>
                <p>Snippet generator</p>
                <p>CSS Grid generator</p>
                <p>Cảnh báo sờ tay lên mặt</p>
            </div>

            <!-- Cột 5 -->
            <div class="footer-column">
                <h3>Công Ty Cổ Phần Công Nghệ Giáo Dục F8</h3>
                <p><strong>Mã số thuế:</strong> 0109922901</p>
                <p><strong>Ngày thành lập:</strong> 04/03/2022</p>
                <p>Lĩnh vực: hoat động. Giáo dục, công nghệ - lập trình. Chứng tôi tập trung xây dựng và phát triển các
                    sản phẩm mang lại giá trị cho cộng đồng lập trình viên Việt Nam.</p>
            </div>
        </div>

        <!-- Dòng bản quyền và biểu tượng mạng xã hội -->
        <div class="footer-bottom">
            <p class="copyright">© 2018 - 2025 F8. Nền tảng học lập trình hàng đầu Việt Nam</p>
            <div class="social-icons">
                <a href="#"><img src="https://cdn.pixabay.com/photo/2023/04/25/00/48/youtube-7949229_1280.png"
                        alt="YouTube"></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/1/16/Facebook-icon-1.png"
                        alt="Facebook"></a>
                <a href="#"><img
                        src="https://thumbs.dreamstime.com/b/tik-tok-icon-tiktok-logo-design-graphic-template-vector-illustration-211007983.jpg"
                        alt="TikTok"></a>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
