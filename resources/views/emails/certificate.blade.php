<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Times New Roman', serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .certificate {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 40px;
            border: 5px double #ff0000;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .certificate::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(to right, #ff0000, #ffd700, #ff0000); 
        }
        .certificate::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(to right, #ff0000, #ffd700, #ff0000); 
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 50px;
            border-radius: 50%;
        }
        .certificate-id {
            font-size: 12px;
            color: #666;
            text-align: right;
            margin-left: 420px;
            line-height: 1.5;
        }
        .certificate-id p {
            margin: 0;
        }
        .title {
            font-size: 30px;
            color: #ff0000;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
        }
        .content {
            font-size: 16px;
            color: #333;
            margin: 15px 0;
            text-align: center;
            line-height: 1.5;
        }
        .recipient {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            text-transform: uppercase;
        }
        .signature-section {
            text-align: right;
            margin-top: 40px;
        }
        .signature {
            font-size: 14px;
            color: #555;
            margin-top: 20px;
        }
        .signature strong {
            display: block;
            margin-bottom: 5px;
            color: #ff0000;
        }
        .divider {
            width: 100px;
            height: 2px;
            background-color: #ff0000;
            margin: 10px auto;
        }
        h1 {
            color: #343a40;
            margin-top: 20px;
        }
        p {
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Chúc mừng {{ $user->name }}!</h1>
    <p>Bạn đã hoàn thành khóa học <strong>{{ $course->title }}</strong> vào ngày {{ $completed_at->format('d/m/Y') }}.</p>
    <div class="certificate">
        <div class="header">
            <img src="https://fullstack.edu.vn/assets/f8-icon-lV2rGpF0.png" alt="Logo" class="logo">
            <div class="certificate-id">
                <p>Số tham chiếu: {{ strtoupper(substr(md5($course->id), 0, 4)) }}</p>
                <p>Ngày cấp: {{ $completed_at->format('d/m/Y') }}</p>
                <p></p>
            </div>
        </div>
        <h3 class="title">Chứng Nhận Hoàn Thành Khóa Học</h3>
        <p class="content">Được trao cho: <strong>{{ $user->username }}</strong></p>
        <p class="content">Đã hoàn thành khóa học: <strong>{{ $course->title }}</strong></p>
        <p class="content">Ngày hoàn thành: <strong>{{ $completed_at->format('d/m/Y') }}</strong></p>
        <div class="signature-section">
            <div class="signature">
                <strong>Ban Quản Lý Khóa Học</strong>
                Đại diện
                <div class="divider"></div>
            </div>
        </div>
    </div>
    <p>Trân trọng,<br>Đội ngũ quản lý khóa học</p>
</body>
</html>