@extends('layouts.master')

@section('content')
    <!-- Banner -->
    <div class="banner">
        <div class="content">
            <h1>Mở bán khóa JavaScript Pro <i class="fas fa-crown"></i></h1>
            <p>Từ 08/08/2024 khóa học sẽ có giá 1.999K. Khi khóa học hoàn thiện sẽ trở về giá gốc.</p>
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
                @foreach ($courses as $course)
                    <div class="col-md-3 mb-4">
                        @php
                            // Kiểm tra trạng thái đăng ký
                            $isEnrolled = isset($enrollmentStatus[$course->id]) && $enrollmentStatus[$course->id];
                            $link = $isEnrolled ? route('lessons', $course->id) : route('detail', $course->id);
                            $buttonText = $isEnrolled ? 'Học ngay' : 'Đăng ký';
                        @endphp

                        <div class="card course-card">
                            <a href="{{ $link }}" class="text-decoration-none">
                                <div class="card-header html-css">
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-fluid"
                                        alt="{{ $course->title }}" style="width: 460px; height: 200px;">
                                    <span class="badge">Mới</span>
                                </div>
                            </a>
                            <div class="card-body">
                                <div class="title">
                                    <h3 class="fs-5">{{ $course->title }}</h3>
                                </div>
                                <div class="meta d-flex justify-content-between">
                                    <span class="text-decoration-line-through">
                                        {{ number_format($course->price, 0, ',', '.') }}đ
                                    </span>
                                    <span class="new-pricex fw-bold">
                                        {{ number_format($course->price * (1 - ($course->discount ?? 0) / 100), 0, ',', '.') }}đ
                                    </span>
                                </div>
                                <div class="meta d-flex justify-content-between">
                                    <span><i class="fas fa-user"></i> {{ $course->user->username }}</span>
                                    <span><i class="fas fa-book"></i> Null </span>
                                    <span><i class="fas fa-clock"></i> {{ $course->created_at->format('d/m/Y') }}</span>
                                </div>
                                <!-- Nút Đăng ký/Học ngay -->
                                {{-- <a href="{{ $link }}" class="btn btn-primary mt-2 w-100">{{ $buttonText }}</a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
                @if (count($courses) == 0)
                    <div class="col-md-12">
                        <p class="text-center">Không có khoá học nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
