@extends('layouts.master')

@section('content')
<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">Xác Nhận OTP</h2>
        
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

        <p class="text-center mb-4">
            Mã OTP đã được gửi đến email 
            <strong>{{ substr(session('email'), 0, 3) }}***{{ substr(session('email'), -4) }}</strong>
        </p>

        <form method="POST" action="{{ route('password.validate-otp') }}">
            @csrf
            <div class="mb-3">
                <label for="otp" class="form-label">Mã OTP</label>
                <input type="text" 
                       class="form-control @error('otp') is-invalid @enderror" 
                       name="otp" 
                       id="otp" 
                       placeholder="Nhập mã OTP 6 chữ số"
                       maxlength="6"
                       pattern="\d{6}"
                       inputmode="numeric">
                @error('otp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Xác Nhận</button>
        </form>

        <div class="text-center mt-3">
            <p>Không nhận được mã? 
                <a href="{{ route('password.forgot') }}" class="text-primary">
                    Gửi lại mã
                </a>
            </p>
        </div>

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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const otpInput = document.getElementById('otp');
        
        // Only allow numeric input
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection