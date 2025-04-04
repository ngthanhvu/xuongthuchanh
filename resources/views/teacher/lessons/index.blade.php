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
            <h3 class="tw-text-2xl tw-font-bold">{{ $title }}</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các bài học đang có!</p>
        </div>
        <a href="{{ route('teacher.lessons.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Tạo bài học mới
        </a>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Tiêu đề bài học</th>
                    <th class="tw-py-3">Section</th>
                    <th class="tw-py-3">Loại</th>
                    <th class="tw-py-3">Thumbnail</th>
                    <th class="tw-py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($lessons as $lesson)
                    <tr>
                        <td class="text-center">{{ $index++ }}</td>
                        <td class="text-center">{{ $lesson->title }}</td>
                        <td class="text-center">{{ $sections->find($lesson->section_id)->title ?? 'Không xác định' }}</td>
                        <td class="text-center">{{ ucfirst($lesson->type) }}</td>
                        <td class="text-center">
                            @if ($lesson->type === 'video' && $lesson->file_url)
                                @php
                                    $videoId = '';
                                    if (preg_match('/youtube\.com\/watch\?v=([^&]+)/i', $lesson->file_url, $match)) {
                                        $videoId = $match[1];
                                    } elseif (preg_match('/youtu\.be\/([^?]+)/i', $lesson->file_url, $match)) {
                                        $videoId = $match[1];
                                    }
                                @endphp
                                @if ($videoId)
                                    <img src="https://img.youtube.com/vi/{{ $videoId }}/default.jpg"
                                        alt="{{ $lesson->title }}" style="max-width: 100px; height: auto;">
                                @else
                                    Không có thumbnail
                                @endif
                            @elseif ($lesson->type === 'file' && $lesson->file_url)
                                <img src="{{ $lesson->file_url }}" alt="{{ $lesson->title }}"
                                    style="max-width: 100px; height: auto;" onerror="this.src='/images/placeholder.jpg';">
                            @else
                                Không có file
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('teacher.lessons.edit', $lesson->id) }}"
                                class="btn btn-sm btn-outline-primary tw-me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('teacher.lessons.delete', $lesson->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa bài học này?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($lessons->isEmpty())
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
            Hiển thị {{ $lessons->firstItem() }} - {{ $lessons->lastItem() }} / {{ $lessons->total() }} mục
        </span>
        <nav>
            {{ $lessons->links('pagination::bootstrap-4') }}
        </nav>
    </div>
@endsection
