@extends('layouts.master')

@section('content')
    <style>
        .ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
    </style>
    @if (session('success'))
        <script>
            iziToast.success({
                title: 'Thành công',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            iziToast.error({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        </script>
    @endif
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
                @foreach ($courses as $course)
                    <div class="col-md-3 mb-4">
                        @php
                            $isEnrolled = isset($enrollmentStatus[$course->id]) && $enrollmentStatus[$course->id];
                            $link = $links[$course->id] ?? route('detail', $course->id);
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
                                    <h3 class="fs-5 ellipsis">{{ $course->title }}</h3>
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
    <div class="container mt-5">
        <div class="course-section">
            <h2>Khóa học Mới <span class="badge bg-primary">Mới</span></h2>
            <div class="col-12 text-center">
                <p class="lead text-muted">Khám phá các bài viết mới nhất của chúng tôi</p>
            </div>
        </div>
    
        <div class="row g-4">
            @forelse ($posts as $post)
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('post.view', $post->id) }}" class="text-decoration-none">
                        <div class="card course-card h-100 shadow-sm border-0">
                            @if ($post->course && $post->course->thumbnail)
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ asset('storage/' . $post->course->thumbnail) }}" class="card-img-top"
                                        alt="{{ $post->course->title }}" 
                                        style="height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2 py-1">Mới</span>
                                </div>
                            @else
                                <div class="position-relative">
                                    <img src="{{ asset('images/default-thumbnail.jpg') }}" class="card-img-top" 
                                        alt="Default thumbnail" 
                                        style="height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="title">
                                    <h3 class="fs-5 ellipsis">{{ Str::limit($post->title, 50) }}</h3>
                                </div>
                                <div class="meta d-flex justify-content-between">
                                    <span><i class="fas fa-book"></i> {{ $post->course->title ?? 'Không có khóa học' }}</span>
                                    <span><i class="fas fa-clock"></i> {{ $post->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <span class="btn btn-outline-primary btn-sm">Đọc thêm</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Hiện tại chưa có bài viết nào.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <br>
    <br>
@endsection
