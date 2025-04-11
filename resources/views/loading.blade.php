<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title ?? 'Khóa học' }} | Thanh Toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="https://fullstack.edu.vn/favicon/favicon_32x32.png">

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
        html {
            scroll-behavior: smooth;
        }
        /* Màu cam chủ đạo */
        :root {
            --orange-primary: #ff7518;
            --orange-hover: #ff8c33;
            --orange-light: #fff1e6;
            --orange-border: #ffa366;
            --orange-dark: #e65c00;
        }

        /* Tiêu đề modal */
        .modal-header {
            background-color: var(--orange-primary) !important;
            color: white !important;
        }

        /* Nút đóng */
        .btn-close-white {
            filter: brightness(100);
        }

        /* Các icon */
        .fas {
            color: var(--orange-primary) !important;
        }

        /* Nền thông tin khóa học */
        .course-info {
            background-color: var(--orange-light) !important;
            border-color: var(--orange-border) !important;
        }

        /* Nút chính */
        .btn-primary {
            background-color: var(--orange-primary) !important;
            border-color: var(--orange-dark) !important;
        }

        .btn-primary:hover {
            background-color: var(--orange-hover) !important;
            border-color: var(--orange-primary) !important;
        }

        /* Outline button */
        .btn-outline-primary {
            color: var(--orange-primary) !important;
            border-color: var(--orange-primary) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--orange-primary) !important;
            color: white !important;
        }

        /* Bậc giá */
        .text-primary {
            color: var(--orange-primary) !important;
        }

        /* Phương thức thanh toán */
        .btn-check:checked+.btn-outline-primary {
            background-color: var(--orange-primary) !important;
            color: white !important;
        }

        /* Viền phân cách */
        .border-bottom {
            border-color: var(--orange-border) !important;
        }

        /* Phần chi tiết thanh toán */
        .bg-light {
            background-color: var(--orange-light) !important;
        }

        /* Mã giảm giá */
        #couponMessage .text-success {
            color: var(--orange-dark) !important;
        }

        /* Hiệu ứng shadow */
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(255, 117, 24, 0.15) !important;
        }

        /* Nút thanh toán */
        .btn-primary:focus,
        .btn-primary:active {
            box-shadow: 0 0 0 0.25rem rgba(255, 117, 24, 0.5) !important;
        }

        /* Viền input khi focus */
        .form-control:focus {
            border-color: var(--orange-primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 117, 24, 0.25) !important;
        }

        /* Nút phương thức thanh toán với logo */
        #vnpay+label {
            background-image: url('https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-VNPAY-QR.png');
            background-size: 60%;
            background-position: center;
            background-repeat: no-repeat;
            background-color: white;
        }

        #momo+label {
            background-image: url('https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png');
            background-size: 30%;
            background-position: center;
            background-repeat: no-repeat;
            background-color: white;
        }

        /* Căn chỉnh và hiệu ứng khi chọn */
        .btn-check+label {
            padding: 0;
            overflow: hidden;
            position: relative;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-check:checked+label {
            border-width: 2px;
            box-shadow: 0 0 10px rgba(255, 117, 24, 0.5);
        }

        .btn-check:checked+label::after {
            content: '✓';
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: var(--orange-primary);
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
        }

        /* Ẩn text trong label */
        #vnpay+label span,
        #momo+label span {
            display: none;
>>>>>>> d701a7c7f73aa3242aa1175b1c3650ec759778cf
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
                <a href="{{ url('/') }}" class="btn btn-primary">Các khóa học miễn phí</a>
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
        <form id="paymentForm" method="POST" action="{{ route('payment.create') }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" id="priceInput" name="price" value="{{ $course->price }}">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="buyNowModalLabel">
                            <i class="fas fa-shopping-cart me-2"></i>Thanh toán khóa học:
                            {{ $course->title ?? 'Khóa học' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <!-- Thông tin khóa học -->
                            <div class="col-md-5 mb-4">
                                <div class="course-info p-3 border rounded bg-light h-100">
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                            class="img-fluid rounded border" alt="{{ $course->title }}"
                                            style="max-height: 180px; width: 100%; object-fit: contain;">

                                    </div>

                                    <h6 class="border-bottom pb-2 d-flex align-items-center">
                                        <i class="fas fa-gift text-primary me-2"></i>Bạn nhận được:
                                    </h6>
                                    <ul class="list-unstyled mt-3">
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-book-open text-primary me-2"></i>
                                            <span>{{ is_countable($sections) ? count($sections) : 0 }} Chương
                                                học</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-file-alt text-primary me-2"></i>
                                            <span>{{ is_countable($lessons) ? count($lessons) : 0 }} Bài học</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-clipboard-check text-primary me-2"></i>
                                            <span>{{ is_countable($quizzes) ? count($quizzes) : 0 }} Bài kiểm
                                                tra</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-certificate text-primary me-2"></i>
                                            <span>Chứng nhận hoàn thành</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-infinity text-primary me-2"></i>
                                            <span>Truy cập trọn đời</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Thông tin thanh toán -->
                            <div class="col-md-7">
                                <div class="payment-details border rounded p-4 bg-white shadow-sm">
                                    <h6 class="border-bottom pb-2 mb-3">
                                        <i class="fas fa-receipt text-primary me-2"></i>Chi tiết thanh toán
                                    </h6>

                                    <div
                                        class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                                        <div>
                                            <span class="fw-bold">{{ $course->title ?? 'Khóa học' }}</span>
                                            <p class="text-muted small mb-0">Giá gốc</p>
                                        </div>
                                        <span class="fw-bold">{{ number_format($course->price, 0, ',', '.') }}đ</span>
                                    </div>

                                    <!-- Mã giảm giá -->
                                    <div class="coupon-section mb-4">
                                        <div class="input-group">
                                            <input type="text" id="couponCode" name="coupon_code"
                                                class="form-control" placeholder="Nhập mã giảm giá nếu có">
                                            <button type="button" id="applyCouponBtn"
                                                class="btn btn-outline-primary">Áp dụng</button>
                                        </div>
                                        <div id="couponMessage" class="small mt-2"></div>
                                    </div>

                                    <!-- Phần hiển thị giảm giá (ẩn ban đầu) -->
                                    <div class="discount-amount d-none" id="discountSection">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted">Giảm giá:</span>
                                            <span class="text-success fw-bold" id="discountAmount">-0đ</span>
                                        </div>
                                    </div>

                                    <!-- Tổng cộng -->
                                    <div
                                        class="d-flex justify-content-between align-items-center pt-3 border-top mb-4">
                                        <span class="fw-bold fs-5">TỔNG CỘNG:</span>
                                        <span class="fw-bold fs-5 text-primary"
                                            id="totalPrice">{{ number_format($course->price, 0, ',', '.') }}đ</span>
                                    </div>

                                    <!-- Phương thức thanh toán -->
                                    <div class="payment-method mb-4">
                                        <label class="form-label d-flex align-items-center">
                                            <i class="fas fa-credit-card text-primary me-2"></i>Chọn phương thức thanh
                                            toán:
                                        </label>

                                        <div class="row g-2 mt-2">
                                            <div class="col-6">
                                                <input type="radio" class="btn-check" name="payment_method"
                                                    id="vnpay" value="vnpay" checked>
                                                <label class="btn btn-outline-primary w-100" for="vnpay"
                                                    style="height: 60px;">
                                                    <span
                                                        class="position-absolute top-50 start-50 translate-middle">VNPAY</span>
                                                </label>
                                                <div class="text-center mt-1">
                                                    <small class="text-muted">Thanh toán an toàn</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <input type="radio" class="btn-check" name="payment_method"
                                                    id="momo" value="momo">
                                                <label class="btn btn-outline-primary w-100" for="momo"
                                                    style="height: 60px;">
                                                    <span
                                                        class="position-absolute top-50 start-50 translate-middle">MOMO</span>
                                                </label>
                                                <div class="text-center mt-1">
                                                    <small class="text-muted">Thanh toán nhanh chóng</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nút đăng ký -->
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                        <i class="fas fa-lock me-2"></i>Thanh toán ngay
                                    </button>

                                    <div class="text-center mt-3 small text-muted">
                                        <i class="fas fa-shield-alt me-1"></i>Thanh toán an toàn & bảo mật
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Khi người dùng chọn phương thức thanh toán, thay đổi action của form
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');
            const form = document.getElementById('paymentForm');

            paymentMethodInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === 'momo') {
                        form.action =
                            "{{ route('payment.createMomoPayment') }}"; // Chuyển đến route Momo
                    } else {
                        form.action = "{{ route('payment.create') }}"; // Chuyển đến route VNPAY
                    }
                });
            });

            // Xử lý mã giảm giá
            document.getElementById('applyCouponBtn').addEventListener('click', function() {
                const couponCode = document.getElementById('couponCode').value.trim();
                const couponMessage = document.getElementById('couponMessage');

                if (!couponCode) {
                    couponMessage.innerHTML =
                        '<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Vui lòng nhập mã giảm giá</span>';
                    return;
                }

                // Hiển thị đang kiểm tra
                couponMessage.innerHTML =
                    '<span class="text-info"><i class="fas fa-spinner fa-spin"></i> Đang kiểm tra mã...</span>';

                // Gửi AJAX để kiểm tra mã giảm giá (code mẫu - cần thay thế bằng code thật)
                // Giả lập kết quả thành công sau 1 giây
                setTimeout(function() {
                    const originalPrice = {{ $course->price }};
                    const discount = Math.round(originalPrice * 0.1); // Giả sử giảm 10%
                    const newTotal = originalPrice - discount;

                    document.getElementById('discountSection').classList.remove('d-none');
                    document.getElementById('discountAmount').textContent = '-' + new Intl
                        .NumberFormat('vi-VN').format(discount) + 'đ';
                    document.getElementById('totalPrice').textContent = new Intl.NumberFormat(
                        'vi-VN').format(newTotal) + 'đ';
                    document.getElementById('priceInput').value = newTotal;

                    couponMessage.innerHTML =
                        '<span class="text-success"><i class="fas fa-check-circle"></i> Mã giảm giá đã được áp dụng!</span>';
                }, 1000);
            });
        });
    </script>

    </div>

    <script>
        document.getElementById('applyCouponBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const couponCode = document.getElementById('couponCode').value;
            const originalPrice = {{ $course->price }};

            fetch('/coupon/apply', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        coupon_code: couponCode,
                        order_amount: originalPrice
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const messageElement = document.getElementById('couponMessage');
                    const priceInput = document.getElementById('priceInput');
                    const totalPrice = document.getElementById('totalPrice');

                    if (data.success) {
                        messageElement.style.color = 'green';
                        messageElement.textContent =
                            `Giảm: ${data.discount_amount.toLocaleString('vi-VN')}đ, Tổng cuối: ${data.final_amount.toLocaleString('vi-VN')}đ`;
                        // Cập nhật giá trị price trong form
                        priceInput.value = data.final_amount;
                        // Cập nhật hiển thị tổng tiền
                        totalPrice.textContent = `${data.final_amount.toLocaleString('vi-VN')}đ`;
                    } else {
                        messageElement.style.color = 'red';
                        messageElement.textContent = data.message;
                        // Reset về giá gốc nếu áp dụng thất bại
                        priceInput.value = originalPrice;
                        totalPrice.textContent = `${originalPrice.toLocaleString('vi-VN')}đ`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('couponMessage').textContent =
                        'Đã xảy ra lỗi khi áp dụng mã giảm giá.';
                });
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
