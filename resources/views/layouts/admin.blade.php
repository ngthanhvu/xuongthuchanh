<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} | Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tailwind CSS with prefix -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: {
                preflight: false,
            }
        }
    </script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- iziToast -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .sidebar {
        height: 100vh;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #1a202c;
        color: white;
        padding-top: 20px;
    }

    .sidebar a {
        color: #a0aec0;
        text-decoration: none;
        padding: 10px 20px;
        display: block;
    }

    .sidebar a:hover {
        background-color: #2d3748;
        color: white;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
    }

    .navbar {
        margin-left: 250px;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out;
    }

    .loading-overlay.show {
        opacity: 1;
        visibility: visible;
    }
</style>

<body>
    <div id="loading-spinner" class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="tw-p-4">
                <h1 class="tw-text-xl tw-font-bold tw-text-white">
                    <i class="fas fa-wave-square tw-text-blue-500"></i> Admin Dashboard
                </h1>
            </div>
            <nav class="tw-mt-4">
                <a href="/admin"><i class="fas fa-home tw-mr-2"></i> Bảng điều
                    khiển</a>
                <a href="/admin/category"><i class="fas fa-folder tw-mr-2"></i> Danh mục</a>
                <a href="/admin/course"><i class="fas fa-calendar-alt tw-mr-2"></i> Khoá học</a>
                <a href="/admin/sections"><i class="fa-solid fa-file tw-mr-2"></i> Chương học</a>
                <a href="/admin/lessons"><i class="fa-solid fa-book tw-mr-2"></i> Bài học</a>
                <a href="/admin/quizzes"><i class="fa-solid fa-question tw-mr-2"></i> Câu hỏi</a>

                <a href="/admin/quizzes"><i class="fa-brands fa-quinscape"></i> Bài thi</a>
                <a href="/admin/questions"><i class="fa-solid fa-question tw-mr-2"></i> Câu hỏi</a>
                <a href="/admin/answers"><i class="fa-solid fa-graduation-cap tw-mr-2"></i> Đáp án</a>
                <a href="#"><i class="fas fa-file-alt tw-mr-2"></i> Documents</a>
                <a href="/admin/users"><i class="fas fa-users tw-mr-2"></i> Người dùng</a>
                <a href="#"><i class="fas fa-chart-bar tw-mr-2"></i> Reports</a>
            </nav>
        </div>

        <div class="tw-p-4">
            <a href="/" class="tw-text-white text-decoration-none">
                <i class="fas fa-arrow-left tw-mr-2"></i> Back Home
            </a>
        </div>
    </div>
    <nav class="navbar tw-p-3">
        <div class="container-fluid">
            <form class="d-flex tw-w-50">
                <input class="form-control tw-me-2" type="search" placeholder="Search" aria-label="Search">
            </form>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <a class="d-flex align-items-center tw-text-dark text-decoration-none tw-text-gray-500"
                        href="#">
                        <img src="https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g"
                            class="tw-rounded-circle tw-me-2 tw-w-8" alt="User">
                        <span>Xin chào, {{ Auth::user()->username }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <div class="tw-bg-white tw-p-6 tw-rounded-lg tw-shadow-md" style="height: calc(100vh - 100px);">
            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loadingSpinner = document.getElementById("loading-spinner");

            function showLoading() {
                loadingSpinner.classList.add("show");
            }

            function hideLoading() {
                loadingSpinner.classList.remove("show");
            }
            document.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", function(e) {
                    const href = this.getAttribute("href");
                    if (href && !href.startsWith("#") && !href.startsWith("javascript")) {
                        showLoading();
                    }
                });
            });
            window.addEventListener("pageshow", hideLoading);
        });
    </script>
</body>

</html>
