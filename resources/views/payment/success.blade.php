@extends('layouts.master')

@section('content')
    <style>
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 30px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeIn 1s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            font-size: 5rem;
            color: #28a745;
            animation: bounce 1s infinite alternate, fadeGlow 2s infinite ease-in-out;
        }

        @keyframes fadeGlow {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .btn-custom {
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div class="container">
        <div class="success-container">
            <i class="bi bi-check-circle-fill success-icon"></i>
            <h1 class="mt-3 text-success">Thanh toán thành công!</h1>
            <p class="mt-3">Bạn đã đăng ký khóa học <strong>{{ $course->title ?? 'Khóa học #' . $course->id }}</strong> thành công 🎉.</p>
            <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>

            <div class="mt-4">
                {{-- <a href="{{ url('/lessons/' . $course->id) }}" class="btn btn-success btn-sm">Học Ngay</a> --}}
                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">Quay lại trang chủ</a>
            </div>
        </div>
    </div>
@endsection
