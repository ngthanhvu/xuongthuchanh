@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">

            <div class="mb-4 text-center">
                <h1 class="display-6 fw-bold  ">Danh sách khóa học yêu thích</h1>
                <p class="text-muted">Khám phá lại những khóa học bạn đã lưu để học bất cứ lúc nào bạn muốn.</p>
            </div>

            <div class="list mb-4 text-center">
                <a href="/khoa-hoc" class="btn btn-outline-secondary me-2">Tất cả khóa học</a>
                <a href="#" class="btn btn-primary fw-bold button4">Yêu thích</a>
            </div>

            <div class="course-section">
                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-md-4 mb-4">
                            @php
                                $link = route('detail', $course->id);
                                $discountedPrice = $course->price * (1 - ($course->discount ?? 0) / 100);
                            @endphp

                            <div class="card course-card">
                                <a href="{{ $link }}" class="text-decoration-none">
                                    <div class="card-header position-relative p-0">
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-fluid"
                                            alt="{{ $course->title }}"
                                            style="width: 100%; height: 200px; object-fit: cover;">
                                        <span class="badge">Mới</span>
                                    </div>
                                </a>
                                <div class="card-body">
                                    <div class="title mb-2">
                                        <h3 class="fs-5 ellipsis">{{ $course->title }}</h3>
                                    </div>
                                    <div class="meta d-flex justify-content-between mb-2">
                                        @if ($course->price > 0)
                                            <span class="text-decoration-line-through text-muted">
                                                {{ number_format($course->price, 0, ',', '.') }}đ
                                            </span>
                                            <span class="new-pricex fw-bold">
                                                {{ number_format($discountedPrice, 0, ',', '.') }}đ
                                            </span>
                                        @else
                                            <span class="new-pricex fw-bold">Miễn phí</span>
                                        @endif
                                    </div>
                                    <div class="meta d-flex justify-content-between small text-muted mb-3">
                                        <span><i class="fas fa-user"></i> {{ $course->user->username }}</span>
                                        <span><i class="fas fa-book"></i>
                                            {{ $course->category ? $course->category->name : 'Chưa có danh mục' }}</span>
                                        <span><i class="fas fa-clock"></i>
                                            {{ $course->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <form action="{{ route('courses.toggleSave', $course->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-2">
                                            @if($course->isSavedByUser(auth()->id()))
                                                <i class="fas fa-heart text-orange"></i> Đã lưu
                                            @else
                                                <i class="far fa-heart"></i> Lưu khóa học
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($courses->isEmpty())
                        <div class="col-md-12">
                            <p class="text-center text-muted">Bạn chưa lưu khóa học nào.</p>
                        </div>
                    @endif
                </div>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $courses->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">

<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script>
    @if (session('info'))
        iziToast.info({
            title: 'Thông tin',
            message: '{{ session('info') }}',
            position: 'topRight'
        });
    @endif

    @if (session('error'))
        iziToast.error({
            title: 'Lỗi',
            message: '{{ session('error') }}',
            position: 'topRight'
        });
    @endif
</script>
<style>
    .course-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 15px;
        overflow: hidden;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header img {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #ffc107;
        color: #000;
        font-size: 12px;
        padding: 5px 8px;
        border-radius: 5px;
    }


    .new-pricex {
        color: #d63384;
    }
    .button4 {
        background-color: #ff6200;
        border-color: #ff6200;  
    }
    .button4:hover {
        background-color: #dc0f0f;
        border-color: #dc0f0f;  
    }
</style>
@endsection
