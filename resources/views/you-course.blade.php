@extends('layouts.master')

@section('content')
<style>
    .sidebar {
        background-color: #fff;
        padding: 20px 0;
    }

    .sidebar .nav-link {
        color: #333;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #f0f2f5;
        color: #ff6200;
        border-left: 3px solid #ff6200;
    }

    .profile-content {
        padding: 30px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .profile-header img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-right: 20px;
        border: 2px solid #e5e7eb;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
        color: #1f2937;
    }

    .profile-form .form-label {
        font-weight: 500;
        color: #374151;
    }

    .profile-form .form-control {
        background-color: #f8f9fa;
        border-radius: 5px;
        border: 1px solid #d1d5db;
        transition: border-color 0.3s ease;
    }

    .profile-form .form-control:focus {
        border-color: #ff6200;
        box-shadow: 0 0 5px rgba(255, 98, 0, 0.2);
    }

    .btn-save {
        background-color: #ff6200;
        border-color: #ff6200;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-save:hover {
        background-color: #e55a00;
        border-color: #e55a00;
    }

    /* Course List Styling */
    .course-list .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course-list .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .course-list .card-body {
        display: flex;
        align-items: center;
        padding: 15px;
    }

    .course-list .course-image img {
        width: 120px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 20px;
    }

    .course-list .course-info {
        flex: 1;
    }

    .course-list .course-info h6 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .course-list .progress {
        height: 10px;
        border-radius: 5px;
        background-color: #e5e7eb;
        margin-bottom: 10px;
    }

    .course-list .progress-bar {
        background: linear-gradient(90deg, #ff6200, #e55a00);
        transition: width 0.4s ease;
    }

    .course-list .course-info p {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 0;
    }

    .course-list .course-action a {
        background-color: #ff6200;
        color: #fff;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .course-list .course-action a:hover {
        background-color: #e55a00;
    }

    /* Alert Styling */
    .alert {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #f87171;
    }

    .alert-info {
        background-color: #eff6ff;
        color: #1e40af;
        border: 1px solid #dbeafe;
    }

    .alert-link {
        color: #1e40af;
        font-weight: 500;
        text-decoration: underline;
    }
</style>

<div class="container mt-3">
    <div class="row">
        <!-- Cột bên trái: Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">Thông tin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'profile.youcourse' ? 'active' : '' }}" href="{{ route('profile.youcourse') }}">Các khóa học</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('userPayment') }}">Hóa đơn</a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'profile.changePassword' ? 'active' : '' }}" href="{{ route('profile.changePassword') }}">Đổi mật khẩu</a>
                </li>
            </ul>
        </div>

        <!-- Cột bên phải: Nội dung -->
        <div class="col-md-9 col-lg-10 profile-content">
            <div class="profile-header">
                @if(Auth::user()->avatar)
                    <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar">
                @else
                    <img src="https://fullstack.edu.vn/assets/f8-icon-lV2rGpF0.png" alt="Avatar">
                @endif
                <h2>{{ Auth::user()->username }}</h2>
            </div>

            <!-- Tab: Các khóa học -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Các khóa học của tôi</h5>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($courses->isNotEmpty())
                        <div class="course-list">
                            @foreach($courses as $course)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="course-image">
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                                        </div>
                                        <div class="course-info">
                                            <h6>{{ $course->title }}</h6>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $course->pivot->progress }}%;"
                                                    aria-valuenow="{{ $course->pivot->progress }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <p>{{ $course->pivot->progress }}% hoàn thành</p>
                                        </div>
                                        <div class="course-action">
                                            {{-- <a href="#">Tiếp tục học</a> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            Bạn chưa đăng ký khóa học nào. <a href="/" class="alert-link">Xem danh sách khóa học</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection