<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đăng ký khóa học</title>
</head>
<body>
    <h1>Xác nhận đăng ký khóa học</h1>
    <p>Xin chào,</p>
    <p>Bạn đã đăng ký thành công khóa học: <strong>{{ $courseTitle }}</strong> (ID: {{ $courseId }}).</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    <p>Truy cập <a href="{{ url('/courses/' . $courseId) }}">khóa học tại đây</a> để bắt đầu học.</p>
    <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
</body>
</html>