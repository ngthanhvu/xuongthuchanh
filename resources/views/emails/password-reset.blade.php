<!DOCTYPE html>
<html>
<head>
    <title>Mã OTP Đặt Lại Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }
        .container {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin: 20px 0;
            letter-spacing: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Đặt Lại Mật Khẩu</h2>
        <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
        
        <p>Mã OTP của bạn là:</p>
        <div class="otp-code">{{ $otp }}</div>
        
        <p>Mã này sẽ hết hạn trong 15 phút. Vui lòng không chia sẻ mã này với bất kỳ ai.</p>
        
        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
        
        <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
    </div>
</body>
</html>