@extends('layouts.master')

@section('content')
    {{-- <div class="container">
    <h2>Hồ sơ cá nhân</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="username">Tên người dùng:</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
            @error('username')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="fullname">Họ và tên:</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname', $user->fullname) }}">
            @error('fullname')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu mới (nếu muốn đổi):</label>
            <input type="password" class="form-control" id="password" name="password">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="form-group">
            <label for="avatar">Ảnh đại diện:</label>
            <input type="file" class="form-control-file" id="avatar" name="avatar">
            
            @if ($user->avatar)
                <div class="mt-2">
                    <img src="{{ asset($user->avatar) }}" alt="Avatar" class="img-thumbnail rounded-circle" width="150" height="150">
                    <button type="button" class="btn btn-danger btn-sm ml-2" onclick="deleteAvatar()">Xóa ảnh</button>
                </div>
            @endif

            @error('avatar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<script>
    function deleteAvatar() {
        if (confirm('Bạn có chắc muốn xóa ảnh đại diện?')) {
            fetch('{{ route("profile.deleteAvatar") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    }
</script> --}}

    <style>
        .sidebar {
            background-color: #fff;
            padding: 20px 0;
        }

        .sidebar .nav-link {
            color: #333;
            padding: 10px 20px;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f0f2f5;
            color: #ff6200;
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
        }

        .profile-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .profile-form .form-label {
            font-weight: 500;
        }

        .profile-form .form-control {
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .btn-save {
            background-color: #ff6200;
            border-color: #ff6200;
            color: #fff;
        }

        .btn-save:hover {
            background-color: #e55a00;
            border-color: #e55a00;
        }
    </style>
    <div class="container mt-3">
        <div class="row">
            <!-- Cột bên trái: Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Thông tin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Các khóa học</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Đổi mật khẩu</a>
                    </li>
                </ul>
            </div>

            <!-- Cột bên phải: Thông tin cá nhân -->
            <div class="col-md-9 col-lg-10 profile-content">
                <div class="profile-header">
                    <img src="https://fullstack.edu.vn/assets/f8-icon-lV2rGpF0.png" alt="Avatar">
                    <h2>{{ Auth::user()->username }}</h2>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin cá nhân</h5>
                        <form class="profile-form" action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ Auth::user()->username }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ Auth::user()->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    value="{{ old('fullname', $user->fullname) }}">
                            </div>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Ảnh đại diện:</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">

                                @if ($user->avatar)
                                    <div class="mt-2">
                                        <img src="{{ asset($user->avatar) }}" alt="Avatar"
                                            class="img-thumbnail rounded-circle" width="150" height="150">
                                        <button type="button" class="btn btn-danger btn-sm ml-2"
                                            onclick="deleteAvatar()">Xóa ảnh</button>
                                    </div>
                                @endif

                                @error('avatar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-save">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
