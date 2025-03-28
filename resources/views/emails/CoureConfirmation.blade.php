<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đăng ký khóa học</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            background: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 20px;
        }
        .thumbnail {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 10px;
        }
        .price {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            margin-top: 10px;
        }
        .button {
            display: inline-block;
            background: #28a745;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Xác nhận đăng ký khóa học</h2>
        </div>
        <div class="content">
            <p>Xin chào,</p>
            <p>Bạn đã đăng ký thành công khóa học: <strong>{{ $courseTitle }}</strong> (ID: {{ $courseId }}).</p>
                        
            <p class="price">Giá: {{ $price }}</p>
            
            <a href="{{ url('/lessons/' . $course->id) }}" class="button">Học Ngay</a>
        </div>
        <div class="footer">
            <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
        </div>
    </div>
</body>
</html>
