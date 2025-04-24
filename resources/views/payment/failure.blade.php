@extends('layouts.master')

@section('content')
    <style>
        .failure-icon {
            font-size: 4rem;
            color: #dc3545;
        }
    </style>

    <div class="container mt-5">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-x-circle failure-icon"></i>
                <h1 class="card-title mt-3">Thanh toán thất bại</h1>
                <p class="card-text">{{ $message }}</p>
                @if ($course_id)
                    <p>Mã khóa học: {{ $course_id }}</p>
                @endif
                <a href="{{ url('/') }}" class="btn btn-secondary mt-3">Quay lại trang chủ</a>
            </div>
        </div>
    </div>
@endsection