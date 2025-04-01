@extends('layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Thông tin</th>
                            <th>Trình độ</th>
                            <th>Lý do đăng ký</th>
                            <th>Ngày gửi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>
                                <strong>{{ $request->name }}</strong><br>
                                {{ $request->email }}<br>
                                @if($request->profile)
                                <small class="text-muted">{{ $request->profile->phone ?? '' }}</small>
                                @endif
                            </td>
                            <td>{{ Str::limit($request->qualifications, 100) }}</td>
                            <td>{{ Str::limit($request->teacher_request_message, 100) }}</td>
                            <td>{{ $request->teacher_request_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form method="POST" action="{{ route('admin.users.approve-teacher', $request->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="btn btn-success"
                                            onclick="return confirm('Xác nhận duyệt yêu cầu này?')">
                                            <i class="fas fa-check"></i> Duyệt
                                        </button>
                                    </form>

                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#rejectModal{{ $request->id }}">
                                        <i class="fas fa-times"></i> Từ chối
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.teacher.reject', $request->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Từ chối yêu cầu</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Lý do từ chối</label>
                                                <textarea name="reason" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Không có yêu cầu nào đang chờ duyệt</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $requests->links() }}
        </div>
    </div>
</div>

@endsection