@extends('layouts.teacher')

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
        <a href="{{ route('teacher.course.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Tạo khoá học mới
        </a>
    </div>

    <!-- Search and Sort Form -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-p-4 tw-mb-4">
        <form action="{{ route('teacher.course.index') }}" method="GET" class="tw-flex tw-gap-4 tw-items-center">
            <!-- Search Section (60%) -->
            <div class="tw-w-3/5">
                <input type="text" 
                       name="search" 
                       class="form-control tw-w-full" 
                       placeholder="Tìm kiếm theo tên khóa học..." 
                       value="{{ request('search') }}">
            </div>
            
            <!-- Sort Section (40%) -->
            <div class="tw-w-2/5 tw-flex tw-gap-2 tw-items-center">
                <select name="sort" 
                        class="form-control tw-flex-grow" 
                        onchange="this.form.submit()">
                    <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="a-z" {{ $sort == 'a-z' ? 'selected' : '' }}>Tiêu đề A-Z</option>
                    <option value="z-a" {{ $sort == 'z-a' ? 'selected' : '' }}>Tiêu đề Z-A</option>
                </select>
                <button type="submit" class="tw-w-1/5 btn btn-danger tw-px-2 tw-py-1">
                    <i class="fa-solid fa-search tw-mr-1 tw-text-sm"></i>
                </button>
                @if(request()->has('search') || request()->has('sort'))
                    <a href="{{ route('teacher.course.index') }}" 
                       class="tw-w-1/5 btn btn-outline-secondary">
                        <i class="fa-solid fa-times tw-mr-1"></i> Xóa
                    </a>
                @endif
            </div>
        </form>
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
                        <td class="text-center">{{ $course->category->name ?? 'No Category' }}</td>
                        <td class="text-center">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail" width="80" class="tw-rounded">
                            @else
                                <span class="tw-text-gray-400">No image</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($course->price == 0 || (isset($course->is_free) && $course->is_free))
                                <span class="badge bg-success">Miễn phí</span>
                            @else
                                <span>{{ number_format($course->price, 0) }}đ</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('teacher.course.edit', $course->id) }}"
                                class="btn btn-sm btn-outline-primary tw-me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('teacher.course.delete', $course->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa khóa học này?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($courses->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-3">Không có dữ liệu</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($courses, 'hasPages') && $courses->hasPages())
    <div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-px-1">
        <span class="tw-text-sm tw-text-gray-600">
            Hiển thị {{ $courses->firstItem() }} - {{ $courses->lastItem() }} / {{ $courses->total() }} mục
        </span>
        {{ $courses->links() }}
    </div>
    @endif
@endsection