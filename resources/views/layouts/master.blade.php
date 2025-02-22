<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }}</title>
    <!-- link css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- boostrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- font Saira Semi Condensed -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Saira+Semi+Condensed:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <!-- swal alert -->

    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body {
    margin: 0;
    font-family: 'Quicksand', sans-serif;
}

.sidebar {
    width: 80px;
    height: 100vh;
    background-color: #f8f9fa;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 100px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar-item {
    width: 100%;
    padding: 10px;
    text-align: center;
    font-size: 14px;
    color: #333;
    cursor: pointer;
    transition: background-color 0.3s;
}

.sidebar-item:hover {
    background-color: #ddd;
}

.sidebar-item i {
    font-size: 20px;
    margin-bottom: 5px;
}

.sidebar-item a {
    display: block;
}

.sidebar-item.active {
    background-color: #ff7f00;
    color: white;
}

.sidebar-item i, .sidebar-item a {
    transition: color 0.3s;
}

.sidebar-item.active i, .sidebar-item.active a {
    color: white;
}

header {
    padding: 20px;
    background-color: #fff;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 100;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* header .logo a {
    font-size: 24px;
    font-weight: bold;
    color: #333;
} */

header .search input {
    width: 200px;
    padding: 5px;
}

header .search button {
    padding: 5px 10px;
    background-color: #ff6a00;
    color: white;
    border: none;
    cursor: pointer;
}

header .search button:hover {
    background-color: #e55b00;
}

header .user-actions i {
    font-size: 1.5rem;
    color: #333;
    margin-left: 10px;
    cursor: pointer;
}

header .user-actions a {
    text-decoration: none;
    color: #333;
}

header .user-actions a:hover,
header .user-actions i:hover {
    color: #ff6a00;
}

.container {
    padding-top: 60px; 
}

.root{
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}
</style>

<body>
    <div class="root">

        <header class="header">
            <div class="logo">
                <a href="#">F8</a>
                <span>Học Lập Trình Để Đi Làm</span>
            </div>
            <div class="search">
                <input type="text" placeholder="Tìm kiếm khóa học, bài viết, video, ..." />
                <button><i class="fa fa-search"></i></button>
            </div>
            <div class="user-actions">
                <a href="/login">Khóa học của tôi</a>
                <i class="fa fa-bell"></i>
                <i class="fa fa-user-circle"></i>
            </div>
        </header>
    
        <div class="sidebar">
            <div class="sidebar-item active">
                <i class="fas fa-home"></i>
                <a href="/" class="text-decoration-none">Trang Chủ</a>
            </div>
            <div class="sidebar-item">
                <i class="fas fa-link"></i>
                <a href="#" class="text-decoration-none">Lộ Trình</a>
            </div>
            <div class="sidebar-item">
                <i class="fas fa-file-alt"></i>
                <a href="#" class="text-decoration-none">Bài Viết</a>
            </div>
            <div class="sidebar-item">
                <i class="fas fa-volume-up"></i>
                <a href="#" class="text-decoration-none">Thông Báo</a>
            </div>
        </div>
        
        <div class="container mt-3">
            @yield('content')
        </div>
    </div>
</body>

</html>
