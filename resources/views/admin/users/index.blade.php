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
                    <th class="tw-py-3">Tên </th>
                    <th class="tw-py-3">Email</th>
                    <th class="tw-py-3">Full name</th>
                    <th class="tw-py-3">Avatar</th>
                    <th class="tw-py-3">Role</th>
                    <th class="tw-py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $index++ }}</td>
                        <td class="text-center">{{ $user->username }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->fullname }}</td>
                        <td class="text-center">
                            <img src="{{ asset(  $user->avatar) }}" alt="avatar" width="50px">
                        </td>
                        <td class="text-center">
                            @if ($user->role == 'admin')
                                Admin
                            @elseif ($user->role == 'user')
                                user
                            @endif

                        </td>
                        <td class="text-center">
                            <a href="#"
                                class="btn btn-sm btn-outline-primary tw-me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            @if ($user->role != 'admin')
                            <form action="#" method="POST"
                                onsubmit="return confirm('Ban co chac muon xoa user?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @elseif ($user->role == 'admin')
                            <button type="button" class="btn btn-outline-primary disabled" aria_disabled="true">Không đủ quyền hạn!</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
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
