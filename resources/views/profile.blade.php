@extends('layouts.master')

@section('content')
<div class="profile-page">
    <div class="profile-card">
        <div class="profile-header">
            <div class="cover-photo"></div>
            <div class="profile-info">
                <div class="avatar">
                    <img src="https://cdn-icons-png.flaticon.com/512/9815/9815472.png" alt="avatar">
                </div>
                <h1 class="username">{{ Auth::user()->username }}</h1>
            </div>
        </div>

        <div class="tabs">
            <button class="tab active" onclick="showTab('personal')">Thông tin cá nhân</button>
            <button class="tab" onclick="showTab('password')">Đổi mật khẩu</button>
        </div>

        <!-- Personal Info Tab -->
        <div id="personal" class="tab-content active">
            <form method="POST" action="#" class="profile-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="avatar">Ảnh đại diện</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)" style="padding: 10px;">
                </div>

                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" id="name" name="name" value="Tên mẫu" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="email@example.com" disabled>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" value="0123456789" required>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn primary">Cập nhật thông tin</button>
                    <a href="/" class="btn secondary">Quay lại trang chủ</a>
                </div>
            </form>
        </div>

        <!-- Password Change Tab -->
        <div id="password" class="tab-content">
            <form method="POST" action="#" class="profile-form">
                <div class="form-group">
                    <label for="current-password">Mật khẩu hiện tại</label>
                    <div class="password-input">
                        <input type="password" id="current-password" name="current_password" required>
                        <i class="toggle-password fas fa-eye"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new-password">Mật khẩu mới</label>
                    <div class="password-input">
                        <input type="password" id="new-password" name="new_password" required>
                        <i class="toggle-password fas fa-eye"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new-password-confirmation">Xác nhận mật khẩu mới</label>
                    <div class="password-input">
                        <input type="password" id="new-password-confirmation" name="new_password_confirmation" required>
                        <i class="toggle-password fas fa-eye"></i>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn primary">Cập nhật mật khẩu</button>
                    <a href="/" class="btn secondary">Quay lại trang chủ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}

function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.querySelector('.avatar img');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const input = this.previousElementSibling;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
});
</script>

<style>
body {
    margin: 0;
    padding: 0;
}

.profile-page {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 0;
    margin: 0;
}

.profile-card {
    background: white;
    border-radius: 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: none;
    overflow: hidden;
    padding: 20px;
    margin: 0;
}

.profile-header {
    position: relative;
    width: 100%;
}

.cover-photo {
    height: 200px;
    background: linear-gradient(45deg, #2196F3, #3F51B5);
    border-radius: 0;
    width: 100%;
}

.profile-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: -75px;
    padding-bottom: 20px;
    width: 100%;
}

.avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 5px solid white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    margin-bottom: 15px;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.username {
    font-size: 24px;
    color: #333;
    margin: 0;
    text-align: center;
}

.tabs {
    display: flex;
    justify-content: space-around;
    border-bottom: 1px solid #eee;
    padding: 10px 0;
    width: 100%;
}

.tab {
    padding: 15px 30px;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 16px;
    color: #666;
    position: relative;
    transition: all 0.3s ease;
    flex: 1;
    text-align: center;
}

.tab:hover {
    color: #2196F3;
}

.tab.active {
    color: #2196F3;
}

.tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 2px;
    background: #2196F3;
}

.tab-content {
    display: none;
    padding: 30px;
    width: 100%;
}

.tab-content.active {
    display: block;
}

.profile-form {
    max-width: 500px;
    margin: 0 auto;
    width: 100%;
}

.form-group {
    margin-bottom: 25px;
    width: 100%;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #2196F3;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
    outline: none;
}

.form-group input:disabled {
    background: #f5f5f5;
    cursor: not-allowed;
}

.password-input {
    position: relative;
    width: 100%;
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
}

.button-group {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    width: 100%;
    justify-content: center;
}

.btn {
    flex: 1;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
    max-width: 200px;
}

.btn.primary {
    background: #2196F3;
    color: white;
    border: none;
}

.btn.primary:hover {
    background: #1976D2;
}

.btn.secondary {
    background: #f5f5f5;
    color: #333;
    border: 1px solid #ddd;
}

.btn.secondary:hover {
    background: #ebebeb;
}

@media (max-width: 768px) {
    .profile-page {
        padding: 0;
    }
    
    .button-group {
        flex-direction: column;
        gap: 10px;
    }
    
    .tabs {
        padding: 0;
        flex-direction: column;
    }
    
    .tab {
        padding: 10px 20px;
    }

    .btn {
        width: 100%;
        max-width: none;
    }
}

.text-danger {
    color: #dc3545;
    font-size: 14px;
}
</style>
@endsection