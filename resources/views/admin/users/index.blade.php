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
            <h3 class="tw-text-2xl tw-font-bold">Quản lý người dùng</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các người dùng đang có!</p>
        </div>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Tên</th>
                    <th class="tw-py-3">Email</th>
                    <th class="tw-py-3">Full name</th>
                    <th class="tw-py-3">Avatar</th>
                    <th class="tw-py-3">Role</th>
                    <th class="tw-py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $user->username ?? 'N/A' }}</td>
                        <td class="text-center">{{ $user->email ?? 'N/A' }}</td>
                        <td class="text-center">{{ $user->fullname ?? 'N/A' }}</td>
                        <td class="text-center">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="avatar" width="50px" class="tw-rounded-full">
                            @else
                                <div class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-gray-200 tw-flex tw-items-center tw-justify-center">
                                    <i class="fas fa-user tw-text-gray-500"></i>
                                </div>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($user->role == 'admin')
                                <span class="tw-bg-blue-100 tw-text-blue-800 tw-px-2 tw-py-1 tw-rounded tw-text-sm">Admin</span>
                            @else
                                <span class="tw-bg-green-100 tw-text-green-800 tw-px-2 tw-py-1 tw-rounded tw-text-sm">User</span>
                            @endif
                        </td>
                        <td class="text-center tw-space-x-1">
                            <!-- Dropdown để thay đổi role -->
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="roleDropdown{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-cog"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="roleDropdown{{ $user->id }}">
                                    <li>
                                        <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" name="role" value="admin" class="dropdown-item {{ $user->role == 'admin' ? 'active' : '' }}">
                                                <i class="fas fa-user-shield me-2"></i> Chuyển thành Admin
                                            </button>
                                            <button type="submit" name="role" value="user" class="dropdown-item {{ $user->role == 'user' ? 'active' : '' }}">
                                                <i class="fas fa-user me-2"></i> Chuyển thành User
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <!-- Nút xóa -->
                            @if ($user->role != 'admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled>
                                    <i class="fas fa-ban"></i>
                                </button>
                            @endif
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

    <div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-px-1">
        <span class="tw-text-sm tw-text-gray-600">Hiển thị 12 / 100 mục</span>
        <nav>
            <ul class="pagination mb-0">
                <li class="page-item active">
                    <a class="page-link text-white bg-primary border-primary" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link text-secondary" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link text-secondary" href="#">3</a>
                </li>
            </ul>
        </nav>
    </div>
@endsection