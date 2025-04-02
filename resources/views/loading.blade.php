<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title ?? 'Khóa học' }} | Thanh Toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
        }

        .hero-section {
            padding: 80px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(90deg, #ff6f61, #d83f87);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.2rem;
            color: #b0b0b0;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: bold;
            margin-right: 15px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #e65b50;
        }

        .btn-outline-light {
            border-color: #fff;
            color: #fff;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-outline-light:hover {
            background-color: #fff;
            color: #1a1a2e;
        }

        .laptop-image {
            max-width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            margin: 40px 0;
        }

        .target-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }

        .target-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 40px;
        }

        .target-section .card {
            background: rgba(255, 255, 255, 0.05);
            border: none;
            border-radius: 15px;
            padding: 20px;
            color: #b0b0b0;
            position: relative;
            margin-bottom: 20px;
        }

        .target-section .card::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            width: 40px;
            height: 40px;
            background: linear-gradient(90deg, #ff6f61, #d83f87);
            border-radius: 50%;
            opacity: 0.3;
        }

        .target-section .card h5 {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 10px;
            margin-left: 60px;
        }

        .target-section .card p {
            margin-left: 60px;
            font-size: 0.95rem;
        }

        .illustration-image {
            max-width: 100%;
            margin-bottom: 40px;
        }

        /* Modal styles */
        .modal-content {
            border-radius: 15px;
            background-color: #fff;
            color: #333;
        }

        .modal-header {
            border-bottom: none;
            padding: 20px 30px;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .modal-body {
            padding: 20px 30px;
        }

        .modal-body h5 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .modal-body ul {
            list-style-type: disc;
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .modal-body ul li {
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .price-section {
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }

        .price-section p {
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .price-section .total {
            font-weight: bold;
            font-size: 1.2rem;
            color: #ff6f61;
        }

        .discount-code {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .discount-code input {
            flex: 1;
            margin-right: 10px;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        .discount-code button {
            background-color: #ff6f61;
            border: none;
            padding: 8px 15px;
            color: #fff;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .btn-continue {
            background-color: #007bff;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 5px;
        }

        .modal-footer {
            border-top: none;
            padding: 10px 30px 20px;
            text-align: center;
        }

        .modal-footer p {
            font-size: 0.9rem;
            color: #666;
        }

        .modal-footer p i {
            color: #007bff;
            margin-right: 5px;
        }

        price-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .price-section h5 {
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
            color: #333;
        }

        .price-section .course-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .price-section img {
            border-radius: 8px;
            object-fit: cover;
        }

        .price-section p {
            margin: 0;
            font-size: 16px;
            color: #555;
        }

        .price-section p span {
            font-weight: bold;
            color: #d9534f;
        }

        .discount-code {
            display: flex;
            gap: 10px;
            margin: 15px 0;
        }

        .discount-code input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .discount-code button {
            background: #ff6f61;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .discount-code button:hover {
            background: #ff6f62;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            border-top: 2px solid #ddd;
            padding-top: 10px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Khóa Học {{ $course->title ?? 'Khóa học' }}</h1>
            <p>Khởi động từ cơ bản, đi sâu kiến thức và vận dụng. Sẵn sàng - Bắt đầu!</p>
            <div>
                <a href="#" class="btn btn-primary">Các khóa học miễn phí</a>
                <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                    data-bs-target="#buyNowModal">
                    Mua ngay
                </button>
            </div>

            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-fluid mt-4" alt="{{ $course->title }}"
                style="width: 460px; height: 200px;">
        </div>
    </section>

    <!-- Target Audience Section -->
    <section class="target-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Khóa học này dành cho ai?</h2>
                    <img src="https://fullstack.edu.vn/assets/features-ecUhnuKH.png" alt="Illustration"
                        class="illustration-image">
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h5>1. Bạn mới học lập trình</h5>
                        <p>Khóa học này sẽ giúp bạn hiểu rõ các khái niệm cơ bản, từ cú pháp đến cách vận dụng thực tế
                            để xây dựng dự án đầu tiên.</p>
                    </div>
                    <div class="card">
                        <h5>2. Người tự học lập trình</h5>
                        <p>Hiểu rõ các khái niệm, cách vận dụng từ cơ bản đến nâng cao và có một lộ trình học tập rõ
                            ràng.</p>
                    </div>
                    <div class="card">
                        <h5>3. Người muốn nâng cao kỹ năng</h5>
                        <p>Cách học lập trình đúng đắn, nâng cao kỹ năng lập trình và áp dụng vào các dự án thực tế.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Buy Now Modal -->
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
        <form method="POST" action="{{ route('payment.create') }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="price" value="{{ $course->price }}">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buyNowModalLabel">Thanh toán cho khóa học:
                            {{ $course->title ?? 'Khóa học' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="mt-4">Bạn nhận được gì từ khóa học này?</h5>
                        <ul>
                            <p class="mt-3">{{ is_countable($sections) ? count($sections) : 0 }} Chương học</p>
                            <p class="mt-3">{{ is_countable($lessons) ? count($lessons) : 0 }} Bài học</p>
                            <p class="mt-3">{{ is_countable($quizzes) ? count($quizzes) : 0 }} Bài kiểm tra</p>

                        </ul>

                        <div class="price-section">
                            <h5>Chi tiết thanh toán</h5>
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-fluid"
                                alt="{{ $course->title }}" style="width: 100px; height: 50px;">
                            <p>Khóa học {{ $course->title ?? 'Khóa học' }}
                                <span>{{ number_format($course->price, 0, ',', '.') }}đ</span>
                            </p>

                            <div class="discount-code">
                                <input type="text" placeholder="Nhập mã giảm giá nếu có">
                                <button type="button">Áp dụng</button>
                            </div>

                            <p class="total">TỔNG
                                <span>{{ number_format($course->price, 0, ',', '.') }}đ</span>
                            </p>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
        </form>
    </div>
    </div>
    </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>