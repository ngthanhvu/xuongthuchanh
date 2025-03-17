@extends('layouts.master')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <!-- Left Section -->
            <div class="col-md-8">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Bạn sẽ học được gì?</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fa-solid fa-check"></i> Các kiến thức căn bản, nền móng cụa nganh IT
                            </li>
                            <li class="list-group-item">
                                <i class="fa-solid fa-check"></i> Các khái niêm, thuật ngọc cổ tói khi tri khái nghĩa
                                dưng
                            </li>
                            <li class="list-group-item" style="color: red;">
                                <i class="fa-solid fa-check"></i> Cấc khái niêm, thuật ngọc cổ tói khi tri khái nghĩa
                                dũng
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Nội dung khóa học</h5>
                        <p>4 chương • 12 bài học • Thời lượng 03 giờ 26 phút</p>
                        <div class="accordion" id="courseContentAccordion">
                            <!-- Chương 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        1. Khái niêm kỹ thuật căn biet
                                        <span class="float-end">3 bài học</span>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#courseContentAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 1.1 Mô hình Client - Server là gì?
                                                <span class="float-end">11:35</span>
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 1.2 Domain là gì? Tên là gì?
                                                <span class="float-end">10:34</span>
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 1.3 Mua ao FB | Đăng ký học Offline
                                                <span class="float-end">01:00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Chương 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        2. Môi trường, công nghệ IT
                                        <span class="float-end">3 bài học</span>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#courseContentAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 2.1 Bài học 1
                                                <span class="float-end">10:00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 2.2 Bài học 2
                                                <span class="float-end">12:00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 2.3 Bài học 3
                                                <span class="float-end">08:00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Chương 3 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        3. Phương pháp, định hướng
                                        <span class="float-end">4 bài học</span>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#courseContentAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 3.1 Bài học 1
                                                <span class="float-end">15:00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 3.2 Bài học 2
                                                <span class="float-end">10:00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 3.3 Bài học 3
                                                <span class="float-end">12:00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 3.4 Bài học 4
                                                <span class="float-end">08:00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Chương 4 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        4. Hoàn thành khóa học
                                        <span class="float-end">2 bài học</span>
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#courseContentAccordion">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 4.1 Bài học 1
                                                <span class="float-end">10:00</span>
                                            </li>
                                            <li class="list-group-item">
                                                <input type="radio" class="me-2"> 4.2 Bài học 2
                                                <span class="float-end">05:00</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-md-4">
                <div class="card video-card mb-4">
                    <h5 class="card-title">Kiến Thức Nhập Môn IT</h5>
                    <p class="card-text">Xem giới thiệu khóa học</p>
                    <video controls width="100%">
                        <source src="path-to-video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div class="card card-custom">
                    <div class="card-body text-center">
                        <h5 class="card-title">Miễn phí</h5>
                        <p class="text-muted">Đăng ký học</p>
                        <a href="/bai-hoc" class="btn btn-custom btn-lg w-100">ĐĂNG KÝ HỌC</a>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle me-2"></i> Trình độ cơ bản</li>
                            <li><i class="bi bi-check-circle me-2"></i> Tổng số 12 bài học</li>
                            <li><i class="bi bi-check-circle me-2"></i> Thời lượng 03 giờ 26 phút</li>
                            <li><i class="bi bi-check-circle me-2"></i> Học mọi lúc, mọi nơi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .video-card {
            background: linear-gradient(to right, #ff4b1f, #ff9068);
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .accordion-button {
            font-weight: bold;
        }

        .accordion-button:not(.collapsed) {
            color: #dc3545;
            background-color: #f8f9fa;
        }

        .accordion-body {
            padding: 0;
        }

        .list-group-item {
            border: none;
        }
    </style>
@endsection
