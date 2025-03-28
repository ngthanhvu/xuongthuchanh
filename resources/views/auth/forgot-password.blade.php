@extends('layouts.master')

@section('content')
<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">Quên Mật Khẩu</h2>
        
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

        <form method="POST" action="{{ route('password.send-link') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" id="email" 
                       placeholder="Nhập email của bạn"
                       value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Gửi Mã OTP</button>
        </form>

        <div class="text-center mt-3">
            <a href="/dang-nhap" class="text-decoration-none">
                <i class="bi bi-arrow-left me-2"></i>Quay lại đăng nhập
            </a>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
</style>
@endsection