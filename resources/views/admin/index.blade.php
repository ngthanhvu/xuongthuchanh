@extends('layouts.admin')

@section('content')
    <h3 class="tw-text-2xl tw-font-bold tw-mb-6">Trang chủ admin</h3>

    <!-- Stats Cards -->
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-4 tw-mb-6">
        <!-- Card 1: Total Users -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Tổng người dùng</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-blue-600">1,234</p>
                <p class="tw-text-sm tw-text-gray-500">+5% so với tháng trước</p>
            </div>
        </div>
        <!-- Card 2: Total Revenue -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Doanh thu</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-green-600">12,345,000 VNĐ</p>
                <p class="tw-text-sm tw-text-gray-500">+10% so với tháng trước</p>
            </div>
        </div>
        <!-- Card 3: Active Projects -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Dự án đang hoạt động</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-purple-600">45</p>
                <p class="tw-text-sm tw-text-gray-500">+2 dự án trong tuần này</p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4 tw-mb-6">
        <!-- Line Chart -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold tw-mb-4">Doanh thu hàng tháng</h5>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>
        <!-- Bar Chart -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold tw-mb-4">Người dùng mới</h5>
                <canvas id="usersChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities Table -->
    <div class="tw-mb-6">
        <h3 class="tw-text-xl tw-font-semibold tw-mb-3">Hoạt động gần đây</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thời gian</th>
                        <th>Người dùng</th>
                        <th>Hành động</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2025-03-24 10:30</td>
                        <td>Nguyễn Văn A</td>
                        <td>Đăng nhập</td>
                        <td><span class="badge bg-success">Thành công</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>2025-03-24 09:15</td>
                        <td>Trần Thị B</td>
                        <td>Cập nhật hồ sơ</td>
                        <td><span class="badge bg-warning">Đang xử lý</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>2025-03-23 16:45</td>
                        <td>Lê Văn C</td>
                        <td>Thêm dự án</td>
                        <td><span class="badge bg-success">Thành công</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Progress Bars -->
    <div class="tw-mb-6">
        <h3 class="tw-text-xl tw-font-semibold tw-mb-3">Tiến độ công việc</h3>
        <div class="tw-mb-4">
            <p class="tw-font-medium">Thiết kế website</p>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100">75%</div>
            </div>
        </div>
        <div class="tw-mb-4">
            <p class="tw-font-medium">Phát triển ứng dụng di động</p>
            <div class="progress">
                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                    aria-valuemax="100">50%</div>
            </div>
        </div>
        <div>
            <p class="tw-font-medium">Tích hợp API</p>
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25"
                    aria-valuemin="0" aria-valuemax="100">25%</div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Charts -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Revenue Chart (Line Chart)
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: [5000000, 7000000, 6000000, 9000000, 8000000, 12000000],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4
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

            // Users Chart (Bar Chart)
            const usersCtx = document.getElementById('usersChart').getContext('2d');
            new Chart(usersCtx, {
                type: 'bar',
                data: {
                    labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                    datasets: [{
                        label: 'Người dùng mới',
                        data: [120, 150, 180, 200, 170, 220],
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
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
    @endpush
@endsection
