@extends('layouts.master')
@section('content')
<div class="register-container">
    <h2>Đăng Ký</h2>
    <form action="your-register-endpoint" method="POST">
        <div class="mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu"
                required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="confirm-password" name="confirm-password"
                placeholder="Xác nhận mật khẩu" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
    </form>
    <div class="text-center mt-3">
        <p>Hoặc đăng ký với</p>
        <div class="social-btn">
            <a href="#" class="google-btn">
                <i class="fab fa-google"></i> Đăng ký với Google
            </a>
            <a href="#" class="facebook-btn">
                <i class="fab fa-facebook-f"></i> Đăng ký với Facebook
            </a>
        </div>
    </div>
    <div class="login-ok">
        <a href="/login" class="">Đăng Nhập</a>
    </div>
</div>
@endsection
