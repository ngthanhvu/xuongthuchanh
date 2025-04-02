@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Thêm Mã Giảm Giá</h2>

    <form action="{{ route('admin.coupon.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Mã giảm giá</label>
            <input type="text" class="form-control" id="code" name="code" placeholder="Nhập mã giảm giá">
            @error('code')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả"></textarea>
            @error('description')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="discount_type" class="form-label">Loại giảm giá</label>
            <select class="form-control" id="discount_type" name="discount_type">
                <option value="percentage">Phần trăm</option>
                <option value="fixed">Cố định</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="discount_value" class="form-label">Giá trị giảm</label>
            <input type="number" class="form-control" id="discount_value" name="discount_value" step="0.01" placeholder="Nhập giá trị giảm">
            @error('discount_value')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="min_order_value" class="form-label">Giá trị đơn hàng tối thiểu</label>
            <input type="number" class="form-control" id="min_order_value" name="min_order_value" step="0.01" placeholder="Nhập giá trị đơn hàng tối thiểu">
            @error('min_order_value')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="max_discount_amount" class="form-label">Số tiền giảm tối đa</label>
            <input type="number" class="form-control" id="max_discount_amount" name="max_discount_amount" step="0.01" placeholder="Nhập số tiền giảm tối đa">
            @error('max_discount_amount')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="usage_limit" class="form-label">Giới hạn sử dụng</label>
            <input type="number" class="form-control" id="usage_limit" name="usage_limit" min="1" placeholder="Nhập giới hạn sử dụng">
            @error('usage_limit')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" id="start_date" name="start_date">
            @error('start_date')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" id="end_date" name="end_date">
            @error('end_date')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
            <label class="form-check-label" for="is_active">Kích hoạt</label>
        </div>

        <button type="submit" class="btn btn-primary">Tạo Mã Giảm Giá</button>
    </form>
</div>
@endsection