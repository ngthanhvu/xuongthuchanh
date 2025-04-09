@extends('layouts.master')

@section('content')
    <style>
        .ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
        .filter-section .card {
            background-color: #f8f9fa;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            height: 100%;
        }
        .filter-section .form-label {
            font-weight: 600;
            color: #333;
        }
        .filter-section .form-select, .filter-section .form-range {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .filter-section .form-range::-webkit-slider-thumb {
            background: #ff5e00;
            border-radius: 50%;
        }
        .filter-section .form-range::-moz-range-thumb {
            background: #ff5e00;
            border-radius: 50%;
        }
        .filter-section .btn-primary {
            background-color: #ff5e00;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }
        .filter-section .btn-primary:hover {
            background-color: #a84003;
        }
        .price-value {
            font-size: 1.1rem;
            color: #ff5e00;
            font-weight: 500;
        }
        .pagination .page-link {
            border-radius: 5px;
            color: #ff5e00;
        }
        .pagination .page-item.active .page-link {
            background-color: #ff5e00;
            border-color: #ff5e00;
            color: white;
        }
        .course-section h2 {
            margin-bottom: 20px;
        }
        .list {
            color: #ff5e00;
            margin-left: 50px;
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

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row">
            <!-- Phần lọc (bên trái - 3 cột) -->
            <div class="col-md-3">
                <div class="filter-section">
                    <div class="card p-4">
                            <form method="GET" action="/khoa-hoc" class="d-flex flex-column gap-3">
                            <!-- Lọc theo danh mục -->
                            <div>
                                <label for="categories" class="form-label">Danh mục</label>
                                <select name="categories" id="categories" class="form-select">
                                    <option value="">Tất cả</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('categories') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sắp xếp theo giá -->
                            <div>
                                <label for="sort" class="form-label">Sắp xếp</label>
                                <select name="sort" id="sort" class="form-select">
                                    <option value="">Mặc định</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                                </select>
                            </div>

                            <!-- Lọc theo thời gian -->
                            <div>
                                <label for="order" class="form-label">Thời gian</label>
                                <select name="order" id="order" class="form-select">
                                    <option value="latest" {{ request('order') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="oldest" {{ request('order') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                </select>
                            </div>

                            <!-- Lọc theo khoảng giá -->
                            <div>
                                <label for="price_range" class="form-label">Khoảng giá (0 - {{ number_format($maxPrice, 0, ',', '.') }}đ)</label>
                                <input type="range" name="price_range" id="price_range" class="form-range" 
                                       min="0" max="{{ $maxPrice }}" value="{{ request('price_range', $maxPrice) }}"
                                       oninput="document.getElementById('price_value').innerText = this.value.toLocaleString('vi-VN') + 'đ'">
                                <span class="price-value" id="price_value">
                                    {{ request('price_range', $maxPrice) ? number_format(request('price_range', $maxPrice), 0, ',', '.') . 'đ' : 'Tất cả' }}
                                </span>
                            </div>

                            <!-- Nút lọc -->
                            <button type="submit" class="btn btn-primary">Lọc</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Phần danh sách khóa học (bên phải - 9 cột) -->
            <div class="col-md-9">
                <div class="list">
                    <a href="/khoa-hoc">Khóa học</a>
                    <a href="#">Yêu thích</a>
                </div>
                <div class="course-section">
                    <h2>Danh Sách Khóa Học</h2>
                    <div class="row">
                        @foreach ($courses as $course)
                            <div class="col-md-4 mb-4">
                                @php
                                    $isEnrolled = isset($enrollmentStatus[$course->id]) && $enrollmentStatus[$course->id];
                                    $link = $links[$course->id] ?? route('detail', $course->id);
                                    $buttonText = $isEnrolled ? 'Học ngay' : 'Đăng ký';
                                    $discountedPrice = $course->price * (1 - ($course->discount ?? 0) / 100);
                                @endphp

                                <div class="card course-card">
                                    <a href="{{ $link }}" class="text-decoration-none">
                                        <div class="card-header html-css">
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-fluid"
                                                alt="{{ $course->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                                            <span class="badge">Mới</span>
                                        </div>
                                    </a>
                                    <div class="card-body">
                                        <div class="title">
                                            <h3 class="fs-5 ellipsis">{{ $course->title }}</h3>
                                        </div>
                                        <div class="meta d-flex justify-content-between">
                                            @if($course->price > 0)
                                                <span class="text-decoration-line-through">
                                                    {{ number_format($course->price, 0, ',', '.') }}đ
                                                </span>
                                                <span class="new-pricex fw-bold">
                                                    @if($discountedPrice > 0)
                                                        {{ number_format($discountedPrice, 0, ',', '.') }}đ
                                                    @else
                                                        Miễn phí
                                                    @endif
                                                </span>
                                            @else
                                                <span class="new-pricex fw-bold">Miễn phí</span>
                                            @endif
                                        </div>
                                        <div class="meta d-flex justify-content-between">
                                            <span><i class="fas fa-user"></i> {{ $course->user->username }}</span>
                                            <span><i class="fas fa-book"></i> {{ $course->category ? $course->category->name : 'Chưa có danh mục' }}</span>
                                            <span><i class="fas fa-clock"></i> {{ $course->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($courses->isEmpty())
                            <div class="col-md-12">
                                <p class="text-center">Không có khóa học nào</p>
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

    <br>
    <br>
@endsection