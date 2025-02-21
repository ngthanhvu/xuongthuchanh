@extends('layouts.master')
@section('content')

<div class="container-fluid main-container">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="_item_1100q_16">
                    <div class="row justify-content-between">
                        <div class="col-12 col-md-6 _left_1100q_58">
                            <h2 class="_heading_1100q_76">
                                Mở bán khóa JavaScript Pro
                            </h2>
                            <p class="_desc_1100q_104">Từ 08/08/2024 khóa học sẽ có giá 1.399k. Khi khóa học hoàn thiện sẽ trở về giá gốc.</p>
                            <div><a href="https://javascript.fullstack.edu.vn/" target="_blank" rel="noreferrer" class="_ctaBtn_1100q_119">HỌC THỬ MIỄN PHÍ</a></div>
                        </div>
                        <div class="_right_1100q_136">
                            <a href="https://javascript.fullstack.edu.vn/" target="_blank" rel="noreferrer">
                                <img class="_img_1100q_141" src="https://files.fullstack.edu.vn/f8-prod/banners/37/66b5a6b16d31a.png" alt="Mở bán khóa JavaScript Pro" title="Mở bán khóa JavaScript Pro">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="_item_1100q_16">
                    <div class="row justify-content-between">
                        <div class="col-12 col-md-6 _left_1100q_58">
                            <h2 class="_heading_1100q_76">
                                Mở bán khóa HTML CSS Pro
                            </h2>
                            <p class="_desc_1100q_104">Từ 08/08/2024 khóa học sẽ có giá 1.299k. Khi khóa học hoàn thiện sẽ trở về giá gốc.</p>
                            <div><a href="https://htmlcss.fullstack.edu.vn/" target="_blank" rel="noreferrer" class="_ctaBtn_1100q_119">HỌC THỬ MIỄN PHÍ</a></div>
                        </div>
                        <div class="_right_1100q_136">
                            <a href="https://htmlcss.fullstack.edu.vn/" target="_blank" rel="noreferrer">
                                <img class="_img_1100q_141" src="https://files.fullstack.edu.vn/f8-prod/banners/20/6308a6bf603a4.png" alt="Mở bán khóa HTML CSS Pro" title="Mở bán khóa HTML CSS Pro">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="_item_1100q_16">
                    <div class="row justify-content-between">
                        <div class="col-12 col-md-6 _left_1100q_58">
                            <h2 class="_heading_1100q_76">
                                Mở bán khóa Ngôn ngữ Sass
                            </h2>
                            <p class="_desc_1100q_104">Từ 08/08/2024 khóa học sẽ có giá 299k. Khi khóa học hoàn thiện sẽ trở về giá gốc.</p>
                            <div><a href="https://sass.fullstack.edu.vn/" target="_blank" rel="noreferrer" class="_ctaBtn_1100q_119">HỌC THỬ MIỄN PHÍ</a></div>
                        </div>
                        <div class="_right_1100q_136">
                            <a href="https://sass.fullstack.edu.vn/" target="_blank" rel="noreferrer">
                                <img class="_img_1100q_141" src="https://files.fullstack.edu.vn/f8-prod/banners/Banner_01_2.png" alt="Mở bán khóa Ngôn ngữ Sass" title="Mở bán khóa Ngôn ngữ Sass">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>


{{-- Các Khóa Học --}}
<div class="container my-5">
    <h2 class="text-left mb-4" style="font-weight: bold">Khóa học Pro</h2>
    <div class="row">
        <!-- Course 1 -->
        <div class="col-md-3">
            <div class="card course-card">
                <div class="badge-new">Mới</div>
                <img src="https://files.fullstack.edu.vn/f8-prod/courses/15/62f13d2424a47.png" class="card-img-top" alt="HTML CSS Pro">
                <div class="card-body">
                    <h5 class="card-title">HTML CSS Pro</h5>
                    <div class="price-row">
                        <h6 class="price-old">2.500.000₫</h6>
                        <h5 class="price-new">1.299.000₫</h5>
                    </div>
                    <div class="info-row">
                        <p><i class="fas fa-user"></i> Sơn Đặng</p>
                        <p><i class="fas fa-clock"></i> 116h 50m</p>
                    </div>
                    <a href="#" class="btn btn-warning w-100">Học thử miễn phí</a>
                </div>
            </div>
        </div>

        <!-- Course 2 -->
        <div class="col-md-3">
            <div class="card course-card">
                <div class="badge-new">Mới</div>
                <img src="https://files.fullstack.edu.vn/f8-prod/courses/19/66aa28194b52b.png" class="card-img-top" alt="JavaScript Pro">
                <div class="card-body">
                    <h5 class="card-title">JavaScript Pro</h5>
                    <div class="price-row">
                        <h6 class="price-old">3.299.000₫</h6>
                        <h5 class="price-new">1.399.000₫</h5>
                    </div>
                    <div class="info-row">
                        <p><i class="fas fa-user"></i> Sơn Đặng</p>
                        <p><i class="fas fa-clock"></i> 35h 3m</p>
                    </div>
                    <a href="#" class="btn btn-warning w-100">Học thử miễn phí</a>
                </div>
            </div>
        </div>

        <!-- Course 3 -->
        <div class="col-md-3">
            <div class="card course-card">
                <div class="badge-new">Mới</div>
                <img src="https://files.fullstack.edu.vn/f8-prod/courses/27/64e184ee5d7a2.png" class="card-img-top" alt="Ngôn ngữ Sass">
                <div class="card-body">
                    <h5 class="card-title">Ngôn ngữ Sass</h5>
                    <div class="price-row">
                        <h6 class="price-old">400.000₫</h6>
                        <h5 class="price-new">299.000₫</h5>
                    </div>
                    <div class="info-row">
                        <p><i class="fas fa-user"></i> Sơn Đặng</p>
                        <p><i class="fas fa-clock"></i> 6h 18m</p>
                    </div>
                    <a href="#" class="btn btn-warning w-100">Học thử miễn phí</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
