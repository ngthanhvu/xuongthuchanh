@extends('layouts.master')

@section('title', 'Danh sách bài viết')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold">Danh sách Bài Viết</h1>
            <p class="lead text-muted">Khám phá các bài viết mới nhất của chúng tôi</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($posts as $post)
            <div class="col-md-4 col-sm-6">
                <a href="{{ route('post.view', $post->id) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 hover-effect">
                        @if ($post->course && $post->course->thumbnail)
                            <div class="position-relative overflow-hidden">
                                <img src="{{ asset('storage/' . $post->course->thumbnail) }}" 
                                    class="card-img-top" 
                                    alt="{{ $post->course->title }}" 
                                    style="height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                                <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2 py-1">Mới</span>
                            </div>
                        @else
                            <div class="position-relative">
                                <img src="{{ asset('images/default-thumbnail.jpg') }}" 
                                    class="card-img-top" 
                                    alt="Default thumbnail" 
                                    style="height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-semibold text-dark">{{ Str::limit($post->title, 50) }}</h5>
                            <p class="card-text text-muted small">
                                Khóa học: 
                                <strong>{{ $post->course->title ?? 'Không có khóa học' }}</strong>
                            </p>
                            <div class="text-muted small">
                                <i class="bi bi-calendar3"></i> {{ $post->created_at->format('d/m/Y') }}
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

    @if ($posts->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    .hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .hover-effect:hover .card-img-top {
        transform: scale(1.05);
    }
    .card-title {
        min-height: 3rem;
    }
</style>
@endsection