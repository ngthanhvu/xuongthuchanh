@extends('layouts.master')
@section('title', 'Đăng Ký')
@section('content')
<div class="register-container">
    <div class="register-card">
        <h2 class="register-title">Đăng Ký</h2>
        <form action="{{ route('dang-ky') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                       placeholder="Xác nhận mật khẩu" required>
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-register">Đăng Ký</button>
        </form>

        <div class="social-login">
            <p class="social-text">Hoặc đăng ký với</p>
            <div class="social-buttons">
                <a href="#" class="btn-social google-btn">
                    <i class="fab fa-google"></i> Google
                </a>
                <a href="#" class="btn-social facebook-btn">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
            </div>
        </div>

        <div class="login-link">
            Đã có tài khoản? <a href="/login">Đăng Nhập</a>
        </div>
    </div>
</div>

<style>
.register-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.register-card {
    background: white;
    padding: 2.5rem;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

.register-title {
    text-align: center;
    color: #333;
    margin-bottom: 2rem;
    font-weight: 600;
}

.form-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.3);
}

.error-message {
    color: #dc3545;
    font-size: 14px;
    margin-top: 5px;
}

.btn-register {
    width: 100%;
    padding: 12px;
    background: #007bff;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-register:hover {
    background: #0056b3;
}

.social-login {
    margin-top: 1.5rem;
    text-align: center;
}

.social-text {
    color: #666;
    margin-bottom: 1rem;
    font-size: 14px;
}

.social-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-social {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    border-radius: 8px;
    text-decoration: none;
    color: white;
    font-weight: 500;
    transition: opacity 0.3s ease;
}

.btn-social:hover {
    opacity: 0.9;
    text-decoration: none;
    color: white;
}

.google-btn {
    background: #dd4b39;
}

.facebook-btn {
    background: #3b5998;
}

.btn-social i {
    margin-right: 8px;
}

.login-link {
    text-align: center;
    margin-top: 1.5rem;
    color: #666;
    font-size: 14px;
}

.login-link a {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
}

.login-link a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .register-card {
        margin: 1rem;
        padding: 1.5rem;
    }
}
</style>
@endsection