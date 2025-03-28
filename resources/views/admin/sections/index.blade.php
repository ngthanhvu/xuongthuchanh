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
            <h3 class="tw-text-2xl tw-font-bold">{{ $title }}</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các section đang có!</p>
        </div>
        <a href="{{ route('admin.sections.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Tạo section mới
        </a>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Tiêu đề Section</th>
                    <th class="tw-py-3">Khóa học</th>
                    <th class="tw-py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($sections as $section)
                    <tr>
                        <td class="text-center">{{ $index++ }}</td>
                        <td class="text-center">{{ $section->title }}</td>
                        <td class="text-center">{{ $courses->find($section->course_id)->title ?? 'Không xác định' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.sections.edit', $section->id) }}"
                                class="btn btn-sm btn-outline-primary tw-me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.sections.delete', $section->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa section này?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($sections->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-px-1">
        <span class="tw-text-sm tw-text-gray-600">
            Hiển thị {{ $sections->firstItem() }} - {{ $sections->lastItem() }} / {{ $sections->total() }} mục
        </span>
        <nav>
            {{ $sections->links('pagination::bootstrap-4') }}
        </nav>
    </div>
@endsection
