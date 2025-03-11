@extends('layouts.master')

@section('content')
    <!-- Banner -->
    <div class="banner">
        <div class="content">
            <h1>Mở bán khóa JavaScript Pro <i class="fas fa-crown"></i></h1>
            <p>Từ 08/08/2024 khóa học sẽ có giá 1.999K. Khí khóa học hoàn thiện sẽ trở về giá gốc.</p>
            <button class="btn">Học thử miễn phí</button>
        </div>
        <div class="price">
            <div class="old-price">3.299K</div>
            <div class="new-price">1.199K</div>
        </div>
        <div class="badge">
            "Dành cho tài khoản đã pre-order khóa HTML, CSS Pro"
        </div>
    </div>

    <!-- Course Section -->
    <div class="container">
        <div class="course-section">
            <h2>Khóa học Pro <span class="badge bg-primary">Mới</span></h2>
            <div class="row">
                <!-- Card 1: HTML, CSS Pro -->
                <div class="col-md-3 mb-4">
                    <div class="card course-card">
                        <div class="card-header html-css">
                            <img src="https://files.fullstack.edu.vn/f8-prod/courses/15/62f13d2424a47.png"
                                class="img-fluid w-100 h-100" alt="HTML, CSS Pro">
                            <span class="badge">Mới</span>
                        </div>
                        <div class="card-body">
                            <div class="price">
                                <span class="old-price">2.500.000đ</span>
                                <span class="new-price">1.299.000đ</span>
                            </div>
                            <div class="meta d-flex justify-content-between">
                                <span><i class="fas fa-user"></i> Sơn Đặng</span>
                                <span><i class="fas fa-book"></i> 591</span>
                                <span><i class="fas fa-clock"></i> 116h50p</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 2: JavaScript Pro -->
                <div class="col-md-3 mb-4">
                    <div class="card course-card">
                        <div class="card-header javascript">
                            <img src="https://files.fullstack.edu.vn/f8-prod/courses/19/66aa28194b52b.png"
                                class="img-fluid w-100 h-100" alt="JavaScript Pro">
                            <span class="badge">Mới</span>
                        </div>
                        <div class="card-body">
                            <div class="price">
                                <span class="old-price">3.299.000đ</span>
                                <span class="new-price">1.399.000đ</span>
                            </div>
                            <div class="meta d-flex justify-content-between">
                                <span><i class="fas fa-user"></i> Sơn Đặng</span>
                                <span><i class="fas fa-book"></i> 193</span>
                                <span><i class="fas fa-clock"></i> 36h1p</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 3: Ngôn ngữ SASS -->
                <div class="col-md-3 mb-4">
                    <div class="card course-card">
                        <div class="card-header sass">
                            <img src="https://files.fullstack.edu.vn/f8-prod/courses/27/64e184ee5d7a2.png"
                                class="img-fluid w-100 h-100" alt="Ngôn ngữ SASS">
                            <span class="badge">Mới</span>
                        </div>
                        <div class="card-body">
                            <div class="price">
                                <span class="old-price">400.000đ</span>
                                <span class="new-price">299.000đ</span>
                            </div>
                            <div class="meta d-flex justify-content-between">
                                <span><i class="fas fa-user"></i> Sơn Đặng</span>
                                <span><i class="fas fa-book"></i> 27</span>
                                <span><i class="fas fa-clock"></i> 6h18p</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
