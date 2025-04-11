@extends('layouts.master')
@section('content')

<style>
    .sidebar {
        background-color: #fff;
        padding: 20px 0;
    }

    .sidebar .nav-link {
        color: #333;
        padding: 10px 20px;
        font-weight: 500;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #f0f2f5;
        color: #ff6200;
    }

    .profile-content {
        padding: 30px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .profile-header img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-right: 20px;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
    }

    .table th, .table td {
        padding: 12px;
        vertical-align: middle;
    }

    .table th {
        background-color: #f0f2f5;
        font-weight: 600;
    }

    .table tr:hover {
        background-color: #f8f9fa;
    }

    .btn-save {
        background-color: #ff6200;
        border-color: #ff6200;
        color: #fff;
    }

    .btn-save:hover {
        background-color: #e55a00;
        border-color: #e55a00;
    }
</style>

<div class="container mt-3">
    <div class="row">
        <!-- Cột bên trái: Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile') }}">Thông tin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.youcourse') }}">Các khóa học</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('userPayment') }}">Hóa đơn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.changePassword') }}">Đổi mật khẩu</a>
                </li>
            </ul>
        </div>

        <!-- Cột bên phải: Lịch sử hóa đơn -->
        <div class="col-md-9 col-lg-10 profile-content">
            <div class="profile-header">
                @if ($user->avatar)
                    <img src="{{ asset($user->avatar) }}" alt="Avatar">
                @else
                    <img src="https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g" alt="Avatar">
                @endif
                <h2>{{ Auth::user()->username }}</h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lịch sử hóa đơn</h5>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($payments->isEmpty())
                        <p class="text-muted">Bạn chưa có hóa đơn nào.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Mã hóa đơn</th>
                                        <th>Khóa học</th>
                                        <th>Số tiền</th>
                                        <th>Phương thức</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày thanh toán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>{{ $payment->course ? $payment->course->title : 'Không có khóa học' }}</td>
                                            <td>{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>
                                                @if ($payment->status == 'success')
                                                    <span class="text-success">Thành công</span>
                                                @else
                                                    <span class="text-danger">{{ ucfirst($payment->status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Phân trang -->
                        <div class="mt-4">
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection