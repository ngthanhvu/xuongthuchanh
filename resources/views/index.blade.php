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
            <h2>Khóa học Mới <span class="badge bg-primary">Mới</span></h2>
            <div class="row">
                <!-- Loop through courses -->
                @foreach ($course as $courses)
                    <div class="col-md-3 mb-4">
                        <a href="/chi-tiet" class="text-decoration-none">
                            <div class="card course-card">
                                <div class="card-header html-css">
                                    <img src="{{ asset('storage/' . $courses->thumbnail) }}" class="img-fluid w-100 h-100" alt="{{ $courses->title }}">

                                    <span class="badge">Mới</span>
                                </div>
                                <div class="card-body">
                                    <div class="title">
                                        <h3 class="fs-5">{{ $courses->title }}</h3>
                                    </div>
                                  
                                    <div class="meta d-flex justify-content-between">
                                        <span class="text-decoration-line-through ">{{ number_format($courses->price, 0, ',', '.') }}đ</span>
                                        <span class="new-pricex fw-bold">{{ number_format($courses->price * (1 - $courses->discount / 100), 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="meta d-flex justify-content-between">
                                        <span><i class="fas fa-user"></i> {{ $courses->user->username }}</span>
                                        <span><i class="fas fa-book"></i> Null </span>
                                        <span><i class="fas fa-clock"></i>
                                            {{ $courses->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                @if (count($course) == 0)
                    <div class="col-md-12">
                        <p class="text-center">Không có khoá học nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
