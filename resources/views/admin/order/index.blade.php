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
            <h3 class="tw-text-2xl tw-font-bold">Quản lý hóa đơn</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các hóa đơn thanh toán!</p>
        </div>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Người Thanh Toán</th>
                    <th class="tw-py-3">Khóa Học</th>
                    <th class="tw-py-3">Giá Tiền</th>
                    <th class="tw-py-3">Phương Thức</th>
                    <th class="tw-py-3">Trạng Thái</th>
                    <th class="tw-py-3">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @php $index = $payments->firstItem(); @endphp
                @foreach ($payments as $payment)
                    <tr>
                        <td class="text-center">{{ $index++ }}</td>
                        <td class ="text-center">{{ $payment->user->username ?? 'N/A' }}</td>
                        <td class="text-center">{{ $payment->course->title ?? 'N/A' }}</td>
                        <td class="text-center">{{ number_format($payment->amount, 0) }} VNĐ</td>
                        <td class="text-center">{{ $payment->payment_method }}</td>
                        <td class="text-center">
                            <span class="badge {{ $payment->status == 'success' ? 'bg-success' : ($payment->status == 'pending' ? 'bg-danger' : 'bg-warning') }}">
                                {{ $payment->status == 'success' ? 'Thành công' : ($payment->status == 'pending' ? 'Thất bại' : $payment->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                           
                            <form action="{{ route('admin.order.delete', $payment->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa hóa đơn này?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($payments->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">Không có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-px-1">
        <span class="tw-text-sm tw-text-gray-600">
            Hiển thị {{ $payments->firstItem() }} - {{ $payments->lastItem() }} / {{ $payments->total() }} mục
        </span>
        <nav>
            {{ $payments->links() }}
        </nav>
    </div>
@endsection