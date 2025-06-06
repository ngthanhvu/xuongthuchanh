@extends('layouts.admin')

@section('content')
@if (session('success'))
<script>
    iziToast.success({
        title: 'Thành công',
        message: '{{ session('
        success ') }}',
        position: 'topRight'
    });
</script>
@endif
@if (session('error'))
<script>
    iziToast.error({
        title: 'Lỗi',
        message: '{{ session('
        error ') }}',
        position: 'topRight'
    });
</script>
@endif


<div class="tw-flex tw-justify-between tw-items-center tw-mb-6">
    <div>
        <h3 class="tw-text-2xl tw-font-bold">Quản lý người dùng</h3>
        <p class="tw-text-gray-500 tw-mt-1">Danh sách người dùng hệ thống</p>
    </div>
</div>


<ul class="nav nav-tabs mb-4" id="userTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-users-tab" data-bs-toggle="tab" data-bs-target="#all-users" type="button" role="tab">
            Tất cả người dùng
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="teacher-requests-tab" data-bs-toggle="tab" data-bs-target="#teacher-requests" type="button" role="tab">
            Yêu cầu giảng viên
            @if($pendingRequestsCount > 0)
            <span class="badge bg-danger ms-1">{{ $pendingRequestsCount }}</span>
            @endif
        </button>
    </li>
</ul>

<div class="tab-content" id="userTabsContent">

    <div class="tab-pane fade show active" id="all-users" role="tabpanel">
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
            <table class="table table-bordered align-middle mb-0">
                <thead class="tw-bg-gray-100">
                    <tr>
                        <th class="tw-py-3 tw-px-4">#</th>
                        <th class="tw-py-3 tw-px-4">Tên</th>
                        <th class="tw-py-3 tw-px-4">Email</th>
                        <th class="tw-py-3 tw-px-4">Họ tên</th>
                        <th class="tw-py-3 tw-px-4">Avatar</th>
                        <th class="tw-py-3 tw-px-4">Role</th>
                        <th class="tw-py-3 tw-px-4 tw-text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td class="tw-px-4">{{ $loop->iteration }}</td>
                        <td class="tw-px-4">{{ $user->username ?? 'N/A' }}</td>
                        <td class="tw-px-4">{{ $user->email ?? 'N/A' }}</td>
                        <td class="tw-px-4">{{ $user->fullname ?? 'N/A' }}</td>
                        <td class="tw-px-4">
                            @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="Avatar" class="tw-w-10 tw-h-10 tw-rounded-full tw-object-cover">
                            @else
                            <div class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-gray-200 tw-flex tw-items-center tw-justify-center">
                                <i class="fas fa-user tw-text-gray-500"></i>
                            </div>
                            @endif
                        </td>
                        <td class="tw-px-4">
                            @switch($user->role)
                            @case('owner')
                            <span class="tw-bg-purple-100 tw-text-purple-800 tw-px-2 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium">Owner</span>
                            @break
                            @case('admin')
                            <span class="tw-bg-blue-100 tw-text-blue-800 tw-px-2 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium">Admin</span>
                            @break
                            @case('teacher')
                            <span class="tw-bg-orange-100 tw-text-orange-800 tw-px-2 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium">Giảng viên</span>
                            @break
                            @default
                            <span class="tw-bg-green-100 tw-text-green-800 tw-px-2 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium">User</span>
                            @endswitch
                        </td>
                        <td class="tw-px-4 tw-text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2"> @if(Auth::user()->id !== $user->id)
                                @if((Auth::user()->role == 'owner' && $user->role != 'owner') ||
                                (Auth::user()->role == 'admin' && $user->role != 'owner'))
                                <div class="dropdown tw-mr-2">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                        type="button"
                                        id="roleDropdown{{ $user->id }}"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-user-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="roleDropdown{{ $user->id }}">
                                        <li>
                                            <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" name="role" value="admin"
                                                    class="dropdown-item {{ $user->role == 'admin' ? 'active' : '' }}">
                                                    <i class="fas fa-user-shield me-2"></i> Chuyển Admin
                                                </button>
                                                <button type="submit" name="role" value="user"
                                                    class="dropdown-item {{ $user->role == 'user' ? 'active' : '' }}">
                                                    <i class="fas fa-user me-2"></i> Chuyển User
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                                @if(($user->role == 'user' && Auth::user()->role == 'admin') ||
                                (Auth::user()->role == 'owner' && $user->role != 'owner'))
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled
                                    title="Không đủ quyền hạn">
                                    <i class="fas fa-ban"></i>
                                </button>
                                @endif
                                @else
                                <span class="tw-text-sm tw-text-gray-500">Tài khoản của bạn</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Không có người dùng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="tw-flex tw-justify-between tw-items-center tw-mt-4">
            <div class="tw-text-sm tw-text-gray-600">
                Hiển thị {{ $users->firstItem() }} đến {{ $users->lastItem() }} trong tổng số {{ $users->total() }} người dùng
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>

    <div class="tab-pane fade" id="teacher-requests" role="tabpanel">
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
            <table class="table table-bordered align-middle mb-0 text-center">
                <thead class="tw-bg-gray-100">
                    <tr>
                        <th class="tw-py-3 tw-px-4">#</th>
                        <th class="tw-py-3 tw-px-4">Tên</th>
                        <th class="tw-py-3 tw-px-4">Email</th>
                        <th class="tw-py-3 tw-px-4">Trình độ</th>
                        <th class="tw-py-3 tw-px-4">Lý do</th>
                        <th class="tw-py-3 tw-px-4">Bằng cấp</th>
                        <th class="tw-py-3 tw-px-4">Trạng thái</th>
                        <th class="tw-py-3 tw-px-4 tw-text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teacherRequests as $request)
                    <tr>
                        <td class="tw-px-4">{{ $loop->iteration }}</td>
                        <td class="tw-px-4">{{ $request->username }}</td>
                        <td class="tw-px-4">{{ $request->email }}</td>
                        <td class="tw-px-4">{{ Str::limit($request->qualifications, 50) }}</td>
                        <td class="tw-px-4">{{ Str::limit($request->teacher_request_message, 50) }}</td>
                        <td class="tw-px-4">
                            @if(!empty($request->certificate_images) && is_array($request->certificate_images))
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                @foreach($request->certificate_images as $index => $image)
                                @php
                                $filePath = public_path($image);
                                @endphp
                                @if(file_exists($filePath))
                                <!-- Nút kích hoạt modal -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $request->id }}_{{ $index }}">
                                    <img src="{{ asset($image) }}" alt="Bằng cấp"
                                        class="img-thumbnail"
                                        style="max-width: 50px; max-height: 50px;">
                                </a>

                                <div class="modal fade" id="imageModal{{ $request->id }}_{{ $index }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">Ảnh bằng cấp</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="{{ asset($image) }}" alt="Bằng cấp" class="img-fluid" style="max-width: 100%;">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="text-danger small">File không tồn tại: {{ $image }}</span>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td class="tw-px-4">
                            @if($request->teacher_request_status === 'pending')
                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                            @elseif($request->teacher_request_status === 'approved')
                            <span class="badge bg-success">Đã duyệt</span>
                            @else
                            <span class="badge bg-danger">Từ chối</span>
                            @endif
                        </td>
                        <td class="tw-px-4 tw-text-center">
                            @if($request->teacher_request_status === 'pending')

                            <form action="{{ route('admin.users.approve-teacher', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success me-1" onclick="return confirm('Bạn có chắc muốn duyệt yêu cầu này?')">
                                    <i class="fas fa-check"></i> Duyệt
                                </button>
                            </form>

                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                <i class="fas fa-times"></i> Từ chối
                            </button>

                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="rejectForm{{ $request->id }}" action="{{ route('admin.users.reject-teacher', $request->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Lý do từ chối</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="reason{{ $request->id }}" class="form-label">Nhập lý do từ chối</label>
                                                    <textarea name="reason" id="reason{{ $request->id }}" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">Đã xử lý</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">Không có yêu cầu nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($teacherRequests->hasPages())
        <div class="tw-flex tw-justify-between tw-items-center tw-mt-4">
            <div class="tw-text-sm tw-text-gray-600">
                Hiển thị {{ $teacherRequests->firstItem() }} đến {{ $teacherRequests->lastItem() }} trong tổng số {{ $teacherRequests->total() }} yêu cầu
            </div>
            <div>
                {{ $teacherRequests->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabEls.forEach(function(tabEl) {
            tabEl.addEventListener('shown.bs.tab', function(event) {
                var dropdowns = document.querySelectorAll('.dropdown-toggle');
                dropdowns.forEach(function(dropdown) {
                    var dropdownInstance = bootstrap.Dropdown.getInstance(dropdown) || new bootstrap.Dropdown(dropdown);
                });
            });
        });
    });
</script>
@endpush