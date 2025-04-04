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

    .menu-item {
        position: relative;
    }

    .menu-toggle {
        color: #a0aec0;
        text-decoration: none;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .menu-toggle:hover {
        background-color: #2d3748;
        color: white;
    }

    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
    }

    .submenu.active {
        max-height: 200px;
    }

    .submenu a {
        color: #a0aec0;
        text-decoration: none;
        padding: 8px 20px 8px 40px;
        display: block;
        font-size: 0.95rem;
    }

    .submenu a:hover {
        background-color: #4a5568;
        color: white;
    }

    .toggle-icon {
        transition: transform 0.3s ease;
    }

    .toggle-icon.active {
        transform: rotate(180deg);
    }
</style>

<div id="loading-spinner" class="loading-overlay">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column justify-content-between">
    <div>
        @php
            $prefix = Auth::user()->role === 'admin' || Auth::user()->role === 'owner' ? '/admin' : '/teacher';
        @endphp
        <div class="tw-p-4">
            <h1 class="tw-text-xl tw-font-bold tw-text-white">
                <i class="fas fa-wave-square tw-text-blue-500"></i> 
                {{ Auth::user()->role === 'admin' || Auth::user()->role === 'owner' ? 'Admin Dashboard' : 'Teacher Dashboard' }}
            </h1>
        </div>
        <nav class="tw-mt-4">
            <a href="{{ $prefix }}"><i class="fas fa-home tw-mr-2"></i> Bảng điều khiển</a>
            <a href="{{ $prefix }}/category"><i class="fas fa-folder tw-mr-2"></i> Danh mục</a>
            <div class="menu-item">
                <a href="#" class="menu-toggle">
                    <i class="fas fa-layer-group tw-mr-2"></i> Khoá học
                    <i class="fas fa-chevron-down toggle-icon tw-ml-[75px]"></i>
                </a>
                <div class="submenu">
                    <a href="{{ $prefix }}/course"><i class="fas fa-list tw-mr-2"></i> Quản lý khoá học</a>
                    <a href="{{ $prefix }}/sections"><i class="fas fa-plus tw-mr-2"></i> Quản lý chương học</a>
                    <a href="{{ $prefix }}/lessons"><i class="fas fa-folder tw-mr-2"></i> Quản lý bài học</a>
                </div>
            </div>
            <div class="menu-item">
                <a href="#" class="menu-toggle">
                    <i class="fas fa-layer-group tw-mr-2"></i> Bài kiểm tra
                    <i class="fas fa-chevron-down toggle-icon tw-ml-[75px]"></i>
                </a>
                <div class="submenu">
                    <a href="{{ $prefix }}/quizzes"><i class="fas fa-list tw-mr-2"></i> Quản lý bài thi</a>
                    <a href="{{ $prefix }}/questions"><i class="fas fa-plus tw-mr-2"></i> Quản lý câu hỏi</a>
                    <a href="{{ $prefix }}/answers"><i class="fas fa-folder tw-mr-2"></i> Quản lý đáp án</a>
                </div>
            </div>
            <a href="{{ $prefix }}/posts"><i class="fas fa-newspaper tw-mr-2"></i> Bài viết</a>
            <a href="{{ $prefix }}/coupons"><i class="fas fa-tags tw-mr-2"></i> Mã giảm giá</a>
            <a href="{{ $prefix }}/order"><i class="fa-solid fa-money-bill tw-mr-2"></i> Hóa Đơn</a>
            <a href="{{ $prefix }}/users"><i class="fas fa-users tw-mr-2"></i> Người dùng</a>
        </nav>
    </div>

    <div class="tw-p-4">
        <a href="/" class="tw-text-white text-decoration-none">
            <i class="fas fa-arrow-left tw-mr-2"></i> Trở về trang chủ
        </a>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar tw-p-3">
    <div class="container-fluid">
        <div class="d-flex tw-w-50"></div>
        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a class="d-flex align-items-center tw-text-dark text-decoration-none tw-text-gray-500" href="#">
                    <img src="https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g"
                        class="tw-rounded-circle tw-me-2 tw-w-8" alt="User">
                    <span>Xin chào, {{ Auth::user()->name }}</span>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.menu-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            const icon = this.querySelector('.toggle-icon');
            if (submenu && icon) {
                if (submenu.classList.contains('active')) {
                    submenu.classList.remove('active');
                    submenu.style.maxHeight = null;
                } else {
                    submenu.classList.add('active');
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                }
                icon.classList.toggle('active');
            }
        });
    });
});


</script>
