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
            <h3 class="tw-text-2xl tw-font-bold">Danh sách bài viết</h3>
            <p class="tw-text-gray-500 tw-mt-1">Quản lý tất cả bài viết của bạn!</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Thêm bài viết
        </a>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Tiêu đề</th>
                    <th class="tw-py-3">Khóa học</th>
                    <th class="tw-py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($posts as $post)
                    <tr>
                        <td class="text-center">{{ $index++ }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->course->title ?? 'Không có' }}</td>
                        <td class="text-center">
                            <a href="#"
                                class="btn btn-sm btn-outline-info tw-me-1">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                                class="btn btn-sm btn-outline-primary tw-me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($posts->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Không có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-px-1">
        <span class="tw-text-sm tw-text-gray-600">
            Hiển thị {{ $posts->firstItem() }} - {{ $posts->lastItem() }} / {{ $posts->total() }} mục
        </span>
        <nav>
            {{ $posts->links('pagination::bootstrap-4') }}
        </nav>
    </div>
@endsection