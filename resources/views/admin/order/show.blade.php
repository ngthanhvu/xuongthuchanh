@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="tw-flex tw-justify-between tw-items-center tw-mb-6">
        <div>
            <h3 class="tw-text-2xl tw-font-bold">Chi Tiết Hóa Đơn #{{ $payment->id }}</h3>
            <p class="tw-text-gray-500 tw-mt-1">Thông tin chi tiết về hóa đơn</p>
        </div>
        <a href="{{ route('admin.order.index') }}" class="btn btn-outline-primary">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Payment Details -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-p-6 tw-mb-6 border border-gray-500 w-50 mx-auto">
        <h4 class="tw-text-lg tw-font-semibold tw-mb-4">Thông Tin Hóa Đơn</h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID Hóa Đơn:</strong> {{ $payment->id }}</p>
                <p><strong>Người Thanh Toán:</strong> {{ $payment->user->username ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $payment->user->email ?? 'N/A' }}</p>
                <p><strong>Khóa Học:</strong> {{ $payment->course->title ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Tổng Tiền:</strong> {{ number_format($payment->amount, 0) }} VNĐ</p>
                <p><strong>Phương Thức:</strong> {{ $payment->payment_method }}</p>
                <p><strong>Trạng Thái:</strong>
                    <span class="badge {{ $payment->status == 'success' ? 'bg-success' : ($payment->status == 'pending' ? 'bg-danger' : 'bg-warning') }}">
                        {{ $payment->status == 'success' ? 'Thành công' : ($payment->status == 'pending' ? 'Thất bại' : $payment->status) }}
                    </span>
                </p>
                <p><strong>Ngày Thanh Toán:</strong> 
                    {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>

@endsection