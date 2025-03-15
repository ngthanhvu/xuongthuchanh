@extends('layouts.master')

@section('content')

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 400px;">
            <h3 class="text-center mb-4">Đăng Ký</h3>
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" id="name" placeholder="Nhập họ và tên">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Nhập email">
                </div>  
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" id="password_confirmation" placeholder="Nhập lại mật khẩu">
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
                <p class="text-center mt-3">Đã có tài khoản? <a href="/login">Đăng nhập</a></p>
            </form>
        </div>
    </div>
@endsection
