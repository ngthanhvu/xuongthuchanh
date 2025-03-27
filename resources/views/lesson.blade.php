<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mô hình Client - Server</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .video-section {
            background-color: #000;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
        }

        .video-section img {
            max-width: 100%;
            height: auto;
        }

        .lesson-list {
            background-color: #fff;
            border-left: 1px solid #dee2e6;
            height: 500px;
            overflow-y: auto;
        }

        .accordion-button {
            font-weight: bold;
            color: #dc3545;
        }

        .accordion-button:not(.collapsed) {
            color: #dc3545;
            background-color: #f8f9fa;
        }

        .accordion-body {
            padding: 0;
        }

        .lesson-item {
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
        }

        .lesson-item:hover {
            background-color: #f1f1f1;
        }

        .lesson-item.active {
            background-color: #ffe5e5;
        }

        .header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center">
        <a href="/" class="text-decoration-none text-white"><i class="fa-solid fa-arrow-left"></i> Trang chủ</a>
        <div>"Tên bài học"</div>
        <div>0/12 bài học</div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Video Section -->
            <div class="col-md-8 p-0">
                <div class="video-section">
                    <!-- Thay thế bằng video hoặc hình ảnh thực tế -->
                    <img src="placeholder-image.jpg" alt="Video Placeholder">
                </div>
                <div class="footer d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Mô hình Client - Server là gì?</h5>
                        <p>Cập nhật tháng 11 năm 2022</p>
                    </div>
                    <div>
                        <button class="btn btn-light me-2">BÀI TRƯỚC</button>
                        <button class="btn btn-primary">BÀI TIẾP THEO</button>
                    </div>
                </div>
            </div>

            <!-- Lesson List -->
            <div class="col-md-4 p-0">
                <div class="lesson-list">
                    <h6 class="p-3 border-bottom">NỘI DUNG KHÓA HỌC</h6>
                    <div class="accordion" id="lessonAccordion">
                        <!-- Module 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#module1" aria-expanded="true" aria-controls="module1">
                                    1. Khái niệm kỹ thuật cần biết
                                </button>
                            </h2>
                            <div id="module1" class="accordion-collapse collapse show"
                                data-bs-parent="#lessonAccordion">
                                <div class="accordion-body">
                                    <div class="lesson-item active">Mô hình Client - Server là gì? <span
                                            class="float-end">11:35</span></div>
                                    <div class="lesson-item">Domain là gì? Tên miền là gì? <span
                                            class="float-end">10:34</span></div>
                                    <div class="lesson-item">Mua ở F8 / Đăng ký học Offline <span
                                            class="float-end">01:00</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- Module 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#module2" aria-expanded="false" aria-controls="module2">
                                    2. Một số trình, công cụ IT
                                </button>
                            </h2>
                            <div id="module2" class="accordion-collapse collapse" data-bs-parent="#lessonAccordion">
                                <div class="accordion-body">
                                    <div class="lesson-item">Phương pháp, định hướng <span
                                            class="float-end">01:46:14</span></div>
                                    <div class="lesson-item">Hoàn thành khóa học <span class="float-end">01:30:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
