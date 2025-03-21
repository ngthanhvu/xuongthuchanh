@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Hồ sơ cá nhân</h2>

    @if(session('success'))
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
            
            @if($user->avatar)
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
</script>
@endsection