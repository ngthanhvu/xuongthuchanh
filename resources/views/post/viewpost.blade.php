@extends('layouts.master')

@section('title', $post->title)

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Cột trái: Nội dung bài viết -->
        <div class="col-lg-8">
            <!-- Header bài viết -->
            <h1 class="display-4 fw-bold mb-3">{{ $post->title }}</h1>
            <div class="post-meta text-muted mb-4">
                <span>
                    <i class="bi bi-book"></i> 
                    Khóa học: <strong>{{ $post->course->title ?? 'Không có khóa học' }}</strong>
                </span>
                <span class="ms-3">
                    <i class="bi bi-calendar3"></i> 
                    {{ $post->created_at->format('d/m/Y') }}
                </span>
                <span class="ms-3">
                    <i class="bi bi-clock"></i> 
                    {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} phút đọc
                </span>
            </div>

            <!-- Hình ảnh nổi bật (nếu có) -->
            @if ($post->course && $post->course->thumbnail)
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/' . $post->course->thumbnail) }}" 
                         class="img-fluid rounded shadow-sm" 
                         alt="{{ $post->title }}" 
                         style="max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <!-- Nội dung bài viết -->
            <div class="content bg-white p-4 rounded shadow-sm">
                {!! $post->content !!}
            </div>

            <!-- Nút quay lại -->
            <div class="mt-4">
                <a href="{{ route('posts.list') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </div>

        <!-- Cột phải: Khóa học & Bài viết liên quan -->
        <div class="col-lg-4 sticky-sidebar">
            <!-- Thông tin khóa học -->
            @if ($post->course)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Thông tin khóa học</h5>
                    </div>
                    <div class="card-body text-center">
                        @if ($post->course->thumbnail)
                            <img src="{{ asset('storage/' . $post->course->thumbnail) }}" 
                                 class="img-fluid rounded mb-3"
                                 alt="{{ $post->course->title }}">
                        @endif
                        <h5>{{ $post->course->title }}</h5>
                        <p class="text-muted">Khoá học chuyên sâu về {{ $post->course->title }}</p>
                        <a href="/" class="btn btn-sm btn-primary">
                            Xem khóa học
                        </a>
                    </div>
                </div>
            @endif

            <!-- Bài viết liên quan -->
            @if ($relatedPosts->count() > 0)
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center">
                        <h5 class="mb-0">Bài viết liên quan</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($relatedPosts as $related)
                            <div class="mb-3 d-flex">
                                @if ($related->course && $related->course->thumbnail)
                                    <img src="{{ asset('storage/' . $related->course->thumbnail) }}" 
                                         class="me-3 rounded" 
                                         alt="{{ $related->title }}" 
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                @endif
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('post.view', $related->id) }}" class="text-decoration-none">
                                            {{ $related->title }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ $related->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    .content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
 
    .content p {
        margin-bottom: 1.5rem;
    }
    .content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    .content h1, .content h2, .content h3, .content h4, .content h5, .content h6 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .content ul, .content ol {
        padding-left: 2rem;
        margin-bottom: 1.5rem;
    }
    .content blockquote {
        border-left: 4px solid #007bff;
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        margin: 1.5rem 0;
        font-style: italic;
    }
    .post-meta span {
        font-size: 0.95rem;
    }
        /* CSS cho sidebar sticky */
        .sticky-sidebar {
        position: sticky;
        top: 20px; /* Điều chỉnh khoảng cách từ đỉnh */
        max-height: calc(100vh - 40px); /* Giới hạn chiều cao */
        overflow-y: auto; /* Cho phép cuộn nếu nội dung dài */
        padding-bottom: 20px; /* Tạo khoảng cách ở dưới */
    }

    /* Điều chỉnh các thẻ con trong sidebar */
    .sticky-sidebar .card {
        margin-bottom: 20px; /* Khoảng cách giữa các thẻ */
    }

    /* Responsive */
    @media (max-width: 991px) {
        .sticky-sidebar {
            position: static; /* Tắt sticky ở màn hình nhỏ */
            max-height: none;
        }
    }
</style>
@endsection
