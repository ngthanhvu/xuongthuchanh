<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xác Nhận Thanh Toán Thành Công</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #333;">Xác Nhận Thanh Toán Thành Công</h2>
        <p>Xin chào {{ $courses->user->username ?? 'Học viên' }},</p>
        <p>Cảm ơn bạn đã đăng ký khóa học tại hệ thống của chúng tôi. Dưới đây là thông tin chi tiết:</p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Khóa học</th>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $courses->title }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Giá</th>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ number_format($courses->price, 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; border-bottom: 1px solid #ddd;">Ngày đăng ký</th>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ now()->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>

        <p>Bạn có thể bắt đầu học ngay bây giờ bằng cách truy cập: 
            <a href="{{ env('FRONTEND_URL') }}/lessons" style="color: #007bff;">Xem bài học</a>.
        </p>

        <p>Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ qua email: <a href="mailto:support@example.com">support@example.com</a>.</p>

        <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
    </div>
</body>
</html>