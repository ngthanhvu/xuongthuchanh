@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chỉnh Sửa Mã Giảm Giá</h2>

    <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="code" class="form-label">Mã giảm giá</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $coupon->code }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description">{{ $coupon->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="discount_type" class="form-label">Loại giảm giá</label>
            <select class="form-control" id="discount_type" name="discount_type" required>
                <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Giá cố định</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="discount_value" class="form-label">Giá trị giảm</label>
            <input type="number" class="form-control" id="discount_value" name="discount_value" value="{{ $coupon->discount_value }}" required>
        </div>

        <div class="mb-3">
            <label for="min_order_value" class="form-label">Giá trị đơn hàng tối thiểu</label>
            <input type="number" class="form-control" id="min_order_value" name="min_order_value" value="{{ $coupon->min_order_value }}">
        </div>

        <div class="mb-3">
            <label for="max_discount_amount" class="form-label">Giảm giá tối đa</label>
            <input type="number" class="form-control" id="max_discount_amount" name="max_discount_amount" value="{{ $coupon->max_discount_amount }}">
        </div>

        <div class="mb-3">
            <label for="usage_limit" class="form-label">Số lần sử dụng</label>
            <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="{{ $coupon->usage_limit }}">
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '' }}">
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '' }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ $coupon->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Hoạt động</label>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
       <a href="{{ route('admin.coupon.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection