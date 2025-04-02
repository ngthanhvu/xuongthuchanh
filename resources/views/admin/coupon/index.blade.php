@extends('layouts.admin')

@section('content')
    @if (session('success'))
        <script>
            iziToast.success({
                title: 'Thành công',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            iziToast.error({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        </script>
    @endif

    <!-- Header -->
    <div class="tw-flex tw-justify-between tw-items-center tw-mb-6">
        <div>
            <h3 class="tw-text-2xl tw-font-bold">Quản lý mã giảm giá</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các mã giảm giá đang có!</p>
        </div>
        <a href="{{ route('admin.coupon.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Tạo mã giảm giá mới
        </a>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Mã giảm giá</th>
                    <th class="tw-py-3">Loại giảm giá</th>
                    <th class="tw-py-3">Giá trị</th>
                    <th class="tw-py-3">Ngày bắt đầu</th>
                    <th class="tw-py-3">Ngày kết thúc</th>
                    <th class="tw-py-3">Trạng thái</th>
                    <th class="tw-py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($coupons as $coupon)
                    <tr>
                        <td class="text-center">{{ $index++ }}</td>
                        <td class="text-center">{{ $coupon->code }}</td>
                        <td class="text-center">{{ $coupon->discount_type == 'percentage' ? 'Phần trăm' : 'Cố định' }}</td>
                        <td class="text-center">{{ $coupon->discount_value }}</td>
                        <td class="text-center">{{ $coupon->start_date }}</td>
                        <td class="text-center">{{ $coupon->end_date }}</td>
                        <td class="text-center">
                            <span class="badge {{ $coupon->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $coupon->is_active ? 'Hoạt động' : 'Ngừng hoạt động' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.coupon.edit', $coupon->id) }}"
                                class="btn btn-sm btn-outline-primary tw-me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.coupon.delete', $coupon->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa mã giảm giá?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($coupons->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">Không có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-px-1">
        <span class="tw-text-sm tw-text-gray-600">Hiển thị {{ $coupons->count() }} / Tổng số mã giảm giá</span>
        {{ $coupons->links() }}
    </div>
@endsection