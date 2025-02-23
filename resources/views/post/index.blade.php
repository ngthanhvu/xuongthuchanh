@extends('layouts.master')
@section('content')
    <!-- Main Content with Sidebar -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-9">
                <div class="card mb-3 post-card">
                    <div class="card-body d-flex">
                        <div class="post-content">
                            <h5 class="card-title">Hoàng Bảo Trưng - Học viên tiêu biểu F8 tháng 8 với dự án "AI Powered Learning"</h5>
                            <p class="card-text">Trong tháng 8 vừa qua, học viên Hoàng Bảo Trưng đã xuất sắc hoàn thành dự án AI Powered Learning...</p>
                            <small class="text-muted">ReactJS - 5 tháng trước - 6 phút đọc</small>
                        </div>
                        <img src="https://files.fullstack.edu.vn/f8-prod/blog_posts/11504/66fd03cd7b3e4.jpg" class="card-img-top post-image w-50" alt="">
                    </div>
                </div>
                <div class="card mb-3 post-card">
                    <div class="card-body d-flex">
                        <div class="post-content">
                            <h5 class="card-title">Minh đã làm thế nào để hoàn thành một website từ con số 0 trong 15 ngày</h5>
                            <p class="card-text">Xin chào mọi người, mình là Lý Cao Nguyên, mình đã làm một website front-end từ con số 0...</p>
                            <small class="text-muted">Front-end - 8 tháng trước - 4 phút đọc</small>
                        </div>
                        <img src="https://files.fullstack.edu.vn/f8-prod/blog_posts/10850/667550d384026.png" class="card-img-top post-image w-50" alt="">
                    </div>
                </div>
                <div class="card mb-3 post-card">
                    <div class="card-body d-flex">
                        <div class="post-content">
                            <h5 class="card-title">Thu cam kết sẽ giúp anh Sơn</h5>
                            <p class="card-text">Xin chào mọi người, mình là Lý Cao Nguyên, mình rất vui khi được tham gia khóa học này...</p>
                            <small class="text-muted">9 tháng trước - 2 phút đọc</small>
                        </div>
                        <img src="https://files.fullstack.edu.vn/f8-prod/blog_posts/10658/665db085cc3fb.png" class="card-img-top post-image w-50" alt="">
                    </div>
                </div>
            </div>

            <!-- Right Sidebar (Quảng cáo/Khóa học) -->
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h6>Xem các bài viết theo chủ đề</h6>
                        <div class="btn-group-vertical w-100">
                            <button class="btn btn-outline-secondary mb-1">Front-end / Mobile apps</button>
                            <button class="btn btn-outline-secondary mb-1">Back-end / Devops</button>
                            <button class="btn btn-outline-secondary mb-1">UI / UX / Design</button>
                            <button class="btn btn-outline-secondary">Others</button>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <img src="https://files.fullstack.edu.vn/f8-prod/banners/26/63dc61f2a061e.png" class="card-img-top" alt="Quảng cáo">
                    <div class="card-body">
                        <h5 class="card-title">Khóa học HTML CSS Pro</h5>
                        <p class="card-text">Chuyên sâu, kiến thức bài bản, thực hành 200+ bài tập...</p>
                        <a href="#" class="btn btn-primary">Tìm hiểu thêm</a>
                    </div>
                </div>
                <div class="card mb-3">
                    <img src="https://files.fullstack.edu.vn/f8-prod/banners/32/6421144f7b504.png" class="card-img-top" alt="Quảng cáo">
                    <div class="card-body">
                        <h5 class="card-title">F8 Official</h5>
                        <p class="card-text">Video chất lượng, hàng trăm bài giảng miễn phí...</p>
                        <a href="#" class="btn btn-danger">Subscribe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
