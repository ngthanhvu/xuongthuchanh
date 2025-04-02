@extends('layouts.admin')

@section('content')
    <h3 class="tw-text-2xl tw-font-bold tw-mb-6">Trang chủ admin</h3>
    <!-- Stats Cards -->
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-4 tw-mb-6">
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Tổng người dùng</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-blue-600">{{ $totalUsers }}</p>
                <p class="tw-text-sm tw-text-gray-500">
                    @if ($userGrowth > 0)
                        <i class="fas fa-arrow-up tw-text-green-500"></i>
                    @elseif($userGrowth < 0)
                        <i class="fas fa-arrow-down tw-text-red-500"></i>
                    @elseif($userGrowth == 0)
                        <i class="fas fa-arrow-down tw-text-red-500"></i>
                    @endif
                    {{ abs($userGrowth) }}% so với tháng trước
                </p>
            </div>
        </div>

        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Doanh thu</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-green-600">
                    {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</p>
                <p class="tw-text-sm tw-text-gray-500">
                    @if ($revenueGrowth > 0)
                        <i class="fas fa-arrow-up tw-text-green-500"></i>
                    @elseif($revenueGrowth < 0)
                        <i class="fas fa-arrow-down tw-text-red-500"></i>
                    @elseif($revenueGrowth == 0)
                        <i class="fas fa-arrow-down tw-text-red-500"></i>
                    @endif
                    {{ abs($revenueGrowth) }}% so với tháng trước
                </p>
            </div>
        </div>

        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Khóa học đang hoạt động</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-purple-600">{{ $totalCourses }}</p>
                <p class="tw-text-sm tw-text-gray-500">
                    @if ($newCoursesThisWeek > 0)
                        <i class="fas fa-arrow-up tw-text-green-500"></i>
                    @elseif($newCoursesThisWeek < 0)
                        <i class="fas fa-arrow-down tw-text-red-500"></i>
                    @elseif($newCoursesThisWeek == 0)
                        <i class="fas fa-arrow-down tw-text-red-500"></i>
                    @endif
                    {{ $newCoursesThisWeek }} khóa học mới trong tuần này
                </p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <h3 class="tw-text-2xl tw-font-bold tw-mb-6">Thống kê của F8</h3>
    <div class="tw-flex tw-gap-8">
        <div class="tw-flex-1">
            <h3 class="tw-text-lg tw-font-semibold tw-mb-3">Doanh thu theo tháng</h3>
            <canvas id="revenueChart"></canvas>
        </div>

        <div class="tw-flex-1">
            <h3 class="tw-text-lg tw-font-semibold tw-mb-3">Người dùng theo tháng</h3>
            <canvas id="userChart"></canvas>
        </div>
    </div>
    <br><br>
    <div class="tw-mb-6">
        <h3 class="tw-text-xl tw-font-semibold tw-mb-3">Khóa học gần đây</h3>
        <a href="admin/course" class="tw-flex tw-items-center tw-font-semibold tw-transition-all tw-no-underline "
            style="margin-left: 1050px; color:orange hover:color:blue">
            <i class="fas fa-cogs tw-mr-2"></i> Xem tất cả
        </a>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thời gian</th>
                        <th>Tên khóa học</th>
                        <th>Người tạo</th>
                        <th>Giảng viên</th>
                        <th>Danh mục</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentCourses as $course)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $course->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->user->username }}</td>
                            <td>{{ $course->user->username }}</td>
                            <td>{{ $course->category->name }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.course.edit', $course->id) }}"
                                    class="btn btn-sm btn-outline-danger tw-me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
    <div class="tw-mb-6">
        <h3 class="tw-text-xl tw-font-semibold tw-mb-3">Thanh toán gần đây</h3>
        <a href="admin/order" class="tw-flex tw-items-center tw-font-semibold tw-transition-all tw-no-underline "
            style="margin-left: 1050px">
            <i class="fas fa-cogs tw-mr-2"></i> Xem tất cả
        </a>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ngày thanh toán</th>
                        <th>Khóa học</th>
                        <th>Sinh viên</th>
                        <th>Số tiền</th>
                        <th>Hình thức</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentPayments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->payment_date->format('Y-m-d H:i') }}</td>
                            <td>{{ $payment->course->title }}</td>
                            <td>{{ $payment->user->username }}</td>
                            <td>{{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td>
                                @if ($payment->status === 'success')
                                    <span class="badge bg-success px-3 py-2 rounded-pill">✅ Thành công</span>
                                @elseif ($payment->status === 'canceled')
                                    <span class="badge bg-danger px-3 py-2 rounded-pill"> Thất bại</span>
                                @else
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"> Đang xử lý</span>
                                @endif
                            </td>
                            
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

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
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript for Charts -->
    <script>
        var revenueData = @json($monthlyPayments);
        var userData = @json($monthlyUsers);
        var ctx1 = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: Object.keys(revenueData).map(month => {
                    return ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7",
                        "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                    ][month - 1];
                }),
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: Object.values(revenueData),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('userChart').getContext('2d');
        var userChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: Object.keys(userData).map(month => {
                    return ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7",
                        "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                    ][month - 1];
                }),
                datasets: [{
                    label: 'Số người dùng',
                    data: Object.values(userData),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
