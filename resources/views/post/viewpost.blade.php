@extends('layouts.master')

@section('title', $post->title)

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">{{ $post->title }}</h1>
                <div class="post-meta text-muted mb-4">
                    <span>
                        <i class="bi bi-book"></i>
                        Giới thiệu về Khóa học: <strong>{{ $post->course->title ?? 'Không có khóa học' }}</strong>
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

                @if ($post->course && $post->course->thumbnail)
                    <div class="mb-4 text-center">
                        <img src="{{ asset('storage/' . $post->course->thumbnail) }}" class="img-fluid rounded shadow-sm"
                            alt="{{ $post->title }}" style="max-height: 400px; object-fit: cover;">
                    </div>
                @endif

                <div class="content bg-white p-4 rounded shadow-sm">
                    {!! $post->content !!}
                </div>

            </div>

            <div class="col-lg-4 sticky-sidebar">
                @if ($post->course)
                    <div class="card mb-4">
                        <div class="card-header bg-danger text-white text-center">
                            <h5 class="mb-0">Thông tin khóa học</h5>
                        </div>
                        <div class="card-body text-center">
                            @if ($post->course->thumbnail)
                                <img src="{{ asset('storage/' . $post->course->thumbnail) }}" class="img-fluid rounded mb-3"
                                    alt="{{ $post->course->title }}">
                            @endif
                            <h5>{{ $post->course->title }}</h5>
                            <p class="text-muted">Khoá học chuyên sâu về {{ $post->course->title }}</p>
                            <a href="#" class="btn btn-sm btn-outline-warning hover-warning">
                                Xem khóa học
                            </a>
                        </div>
                    </div>
                @endif

                @if ($relatedPosts->count() > 0)
                    <div class="related-posts-container bg-white shadow-sm rounded-3 overflow-hidden">
                        <div class="related-posts-header bg-danger text-white py-3 px-4">
                            <h5 class="mb-0 d-flex align-items-center">
                                <i class="bi bi-link-45deg me-2"></i>
                                Bài viết liên quan
                            </h5>
                        </div>
                        <div class="related-posts-body p-4">
                            @foreach ($relatedPosts as $related)
                                <div class="related-post-item d-flex align-items-center mb-3 pb-3 border-bottom">
                                    @if ($related->course && $related->course->thumbnail)
                                        <div class="related-post-thumbnail me-3">
                                            <img src="{{ asset('storage/' . $related->course->thumbnail) }}"
                                                class="rounded-2 object-fit-cover" alt="{{ $related->title }}"
                                                style="width: 100px; height: 75px;">
                                        </div>
                                    @endif
                                    <div class="related-post-content flex-grow-1">
                                        <a href="{{ route('post.view', $related->id) }}"
                                            class="text-decoration-none text-dark fw-semibold d-block mb-1 hover-primary">
                                            {{ $related->title }}
                                        </a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>
                                                {{ $related->created_at->format('d/m/Y') }}
                                            </small>
                                            <a href="{{ route('post.view', $related->id) }}"
                                                class="btn btn-sm btn-outline-warning hover-warning">
                                                Đọc ngay
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .hover-warning:hover {
            background-color: #ffc107 !important;
            color: white !important;
            border-color: #ffc107 !important;
        }

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

        .content h1,
        .content h2,
        .content h3,
        .content h4,
        .content h5,
        .content h6 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .content ul,
        .content ol {
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

        .sticky-sidebar {
            position: sticky;
            top: 20px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            padding-bottom: 20px;
        }

        .sticky-sidebar .card {
            margin-bottom: 20px;
        }

        @media (max-width: 991px) {
            .sticky-sidebar {
                position: static;
                max-height: none;
            }
        }
    </style>
@endsection
