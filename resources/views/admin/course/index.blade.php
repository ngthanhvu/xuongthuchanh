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
            <h3 class="tw-text-2xl tw-font-bold">Quản lý khoá học</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các khoá học đang có!</p>
        </div>
        <a href="{{ route('admin.category.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Tạo khoá học mới
        </a>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Tiêu đề</th>
                    <th class="tw-py-3">Danh mục</th>
                    <th class="tw-py-3">Thumbnail</th>
                    <th class="tw-py-3">Giá</th>
                    <th class="tw-py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($courses as $course)
                    <tr>
                        <td class="text-center">{{ $index++ }}</td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->category->name ?? 'No Category' }}</td>
                        <td><img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail" width="80"></td>
                        <td>{{ number_format($course->price, 0) }}đ</td>
                        <td class="text-center">
                            <a href="{{ route('admin.course.edit', $course->id) }}"
                                class="btn btn-sm btn-outline-primary tw-me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.course.delete', $course->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa danh mục?');" class="d-inline">
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
