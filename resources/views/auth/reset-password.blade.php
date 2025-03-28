@extends('layouts.master')

@section('content')
<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">Đặt Lại Mật Khẩu</h2>
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
            @csrf
            <div class="mb-3">
                <label for="password" class="form-label">Mật Khẩu Mới</label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           id="password" 
                           placeholder="Nhập mật khẩu mới"
                           required
                           minlength="6">
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <small class="form-text text-muted">
                    Mật khẩu phải có ít nhất 6 ký tự
                </small>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           placeholder="Nhập lại mật khẩu mới"
                           required
                           minlength="6">
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                </div>
            </div>

            <div class="password-strength mb-3">
                <small>Độ mạnh mật khẩu: 
                    <span id="password-strength-text" class="text-muted">Chưa nhập</span>
                </small>
                <div class="progress" style="height: 5px;">
                    <div id="password-strength-bar" class="progress-bar" role="progressbar" 
                         style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Đặt Lại Mật Khẩu</button>
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
    .progress {
        margin-top: 5px;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const strengthText = document.getElementById('password-strength-text');
        const strengthBar = document.getElementById('password-strength-bar');
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');

        // Password Strength Checker
        function checkPasswordStrength(password) {
            let strength = 0;
            
            if (password.length >= 6) strength += 25;
            if (password.match(/[a-z]+/)) strength += 25;
            if (password.match(/[A-Z]+/)) strength += 25;
            if (password.match(/[0-9]+/)) strength += 25;

            strengthBar.style.width = `${strength}%`;
            
            if (strength < 50) {
                strengthText.textContent = 'Yếu';
                strengthBar.classList.remove('bg-warning', 'bg-success');
                strengthBar.classList.add('bg-danger');
            } else if (strength < 75) {
                strengthText.textContent = 'Trung bình';
                strengthBar.classList.remove('bg-danger', 'bg-success');
                strengthBar.classList.add('bg-warning');
            } else {
                strengthText.textContent = 'Mạnh';
                strengthBar.classList.remove('bg-danger', 'bg-warning');
                strengthBar.classList.add('bg-success');
            }
        }

        passwordInput.addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });

        // Toggle Password Visibility
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetInput = this.previousElementSibling;
                const type = targetInput.type === 'password' ? 'text' : 'password';
                targetInput.type = type;
                
                const icon = this.querySelector('i');
                icon.classList.toggle('bi-eye-fill');
                icon.classList.toggle('bi-eye-slash-fill');
            });
        });

        // Form Validation
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password !== confirmPassword) {
                e.preventDefault();
                confirmPasswordInput.setCustomValidity('Mật khẩu không khớp');
                confirmPasswordInput.reportValidity();
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });
    });
</script>
@endsection