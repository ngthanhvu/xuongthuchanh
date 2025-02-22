@extends('layouts.master')
@section('content')

<div class="login-container">
    <h2>Đăng Nhập</h2>
    <form action="your-login-endpoint" method="POST">
        <div class="mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
        </div>
        <a href="#" class="forgot-password" style="text-decoration: none; color: #ff7f00;">Quên mật khẩu</a>
        <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
    </form>
    <div class="text-center mt-3">
        <p>Hoặc đăng nhập với</p>
        <div class="social-btn">
            <a href="#" class="google-btn" style="margin-bottom: 10px">
                <i class="fab fa-google"></i> Đăng nhập với Google
            </a>
            <a href="#" class="facebook-btn">
                <i class="fab fa-facebook-f"></i> Đăng nhập với Facebook
            </a>
        </div>
    </div>
     <div class="link-register" style="margin-top: 10px">
        <a >Chưa có tài khoản?</a>
        <a href="/register" class="dang-ki">Đăng kí tài khoản</a>
    </div>

@endsection
