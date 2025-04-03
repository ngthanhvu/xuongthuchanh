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
    <link rel="stylesheet" href="{{ asset('css/master.css') }}" class="">
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
                            <a class="nav-link active" href="/">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/lo-trinh">Lộ trình</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/post">Bài viết</a>
                        </li>
                        @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'owner'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin') }}">Admin</a>
                            </li>
                        @endif

                        @if (Auth::check() && (Auth::user()->role === 'teacher'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/teacher') }}">Teacher</a>
                            </li>
                        @endif
                    </ul>

                    <div class="d-flex me-3 position-relative">
                        <div class="search-container">
                            <input type="text" class="form-control search-input" placeholder="Tìm kiếm..."
                                id="searchInput" autocomplete="off">
                            <div class="search-results-dropdown" id="searchResults" style="display: none;">
                                <div class="search-results">
                                    <h6 class="section-title">KHÓA HỌC</h6>
                                    <ul class="list-unstyled" id="courses-list"></ul>
                                    <a href="#" class="view-more" id="courses-view-more"
                                        style="display: none;">Xem thêm</a>

                                    <h6 class="section-title mt-4">BÀI VIẾT</h6>
                                    <ul class="list-unstyled" id="posts-list"></ul>
                                    <a href="#" class="view-more" id="posts-view-more" style="display: none;">Xem
                                        thêm</a>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-custom ms-2" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

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
                                                <a href="{{ route('profile.youcourse') }}">Xem tất cả</a>
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
                                                            <p>Tiến độ
                                                            <div class="progress" style="width: 100%;">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: {{ $courseProgress[$course->id] }}%;"
                                                                    aria-valuenow="{{ $courseProgress[$course->id] }}"
                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                    {{ $courseProgress[$course->id] }}%
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <a href="{{ $links[$course->id] }}">Bắt đầu học</a>
                                                            </p>
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
                                <ul class="dropdown-menu dropdown-menu-end ">
                                    <li class="user-info">
                                        <img src="@if (Auth::user()->avatar) {{ asset(Auth::user()->avatar) }} @else https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g @endif"
                                            alt="User Avatar">
                                        <div>

                                            <div class="user-name ellipsis">{{ Auth::user()->username }}</div>
                                            <div class="user-handle ellipsis">{{ Auth::user()->username }}</div>
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
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const coursesList = document.getElementById('courses-list');
        const postsList = document.getElementById('posts-list');
        const coursesViewMore = document.getElementById('courses-view-more');
        const postsViewMore = document.getElementById('posts-view-more');

        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();

            if (query.length === 0) {
                coursesList.innerHTML = '';
                postsList.innerHTML = '';
                coursesViewMore.style.display = 'none';
                postsViewMore.style.display = 'none';
                searchResults.style.display = 'none';
                return;
            }

            fetch(`/search?query=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    searchResults.style.display = 'block';

                    coursesList.innerHTML = '';
                    if (data.courses && data.courses.length > 0) {
                        data.courses.forEach(course => {
                            const li = document.createElement('li');
                            li.className = 'search-item';
                            li.innerHTML = `
                                <img src="${course.thumbnail ? `/storage/${course.thumbnail}` : 'https://via.placeholder.com/40'}" alt="Course Icon" class="me-2">
                                <div>
                                    <a href="${course.url}" class="search-title">${course.title}</a>
                                </div>
                            `;
                            coursesList.appendChild(li);
                        });
                        coursesViewMore.style.display = 'block';
                        coursesViewMore.href = `/courses?search=${query}`;
                    } else {
                        coursesList.innerHTML = '<li class="text-muted">Không tìm thấy khóa học nào.</li>';
                        coursesViewMore.style.display = 'none';
                    }

                    postsList.innerHTML = '';
                    if (data.posts && data.posts.length > 0) {
                        data.posts.forEach(post => {
                            const li = document.createElement('li');
                            li.className = 'search-item';
                            li.innerHTML = `
                                <img src="${post.thumbnail ? `/storage/${post.thumbnail}` : 'https://via.placeholder.com/40'}" alt="Post Icon" class="me-2">
                                <div>
                                    <a href="/posts/${post.id}" class="search-title">${post.title}</a>
                                </div>
                            `;
                            postsList.appendChild(li);
                        });
                        postsViewMore.style.display = 'block';
                        postsViewMore.href = `/posts?search=${query}`;
                    } else {
                        postsList.innerHTML = '<li class="text-muted">Không tìm thấy bài viết nào.</li>';
                        postsViewMore.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    coursesList.innerHTML = '<li class="text-danger">Đã có lỗi xảy ra.</li>';
                    postsList.innerHTML = '<li class="text-danger">Đã có lỗi xảy ra.</li>';
                    searchResults.style.display = 'block';
                });
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });

        searchInput.addEventListener('focus', function() {
            if (searchInput.value.trim().length > 0) {
                searchResults.style.display = 'block';
            }
        });
    </script>
</body>

</html>
