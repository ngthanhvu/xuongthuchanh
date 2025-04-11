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
        <h3 class="tw-text-2xl tw-font-bold">Quản lý bình luận</h3>
        <p class="tw-text-gray-500 tw-mt-1">Danh sách các bình luận hiện có!</p>
    </div>
</div>

<!-- Form tìm kiếm và lọc -->
<div class="tw-mb-4">
    <form method="GET" action="{{ route('admin.comments') }}" class="tw-flex tw-gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm bình luận hoặc người dùng" class="form-control tw-w-64">
        <select name="course_id" class="form-control tw-w-48">
            <option value="">Tất cả khóa học</option>
            @foreach(\App\Models\Course::all() as $course)
            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                {{ $course->title }}
            </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-outline-secondary">Lọc</button>
    </form>
</div>

<!-- Table -->
<div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
    <form method="POST" action="{{ route('admin.comments.bulk-delete') }}" onsubmit="return confirm('Bạn có chắc muốn xóa các bình luận đã chọn?');">
        @csrf
        @method('DELETE')
        <div class="tw-p-4">
            <button type="submit" class="btn btn-outline-danger tw-mb-4">
                <i class="fa-solid fa-trash tw-mr-1"></i> Xóa các bình luận được chọn
            </button>
        </div>
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3"><input type="checkbox" id="select-all"></th>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Nội dung</th>
                    <th class="tw-py-3">Người dùng</th>
                    <th class="tw-py-3">Khóa học</th>
                    <th class="tw-py-3">Bài học</th>
                    <th class="tw-py-3">Thích</th>
                </tr>
            </thead>
            <tbody>
                @php $index = ($comments->currentPage() - 1) * $comments->perPage() + 1; @endphp
                @foreach ($comments as $comment)
                <tr>
                    <td class="text-center"><input type="checkbox" name="comment_ids[]" value="{{ $comment->id }}"></td>
                    <td class="text-center">{{ $index++ }}</td>
                    <td>{{ Str::limit($comment->content, 50) }}</td>
                    <td class="text-center">{{ $comment->user ? $comment->user->username : 'Không xác định' }}</td>
                    <td class="text-center">{{ $comment->course ? $comment->course->title : 'Không xác định' }}</td>
                    <td class="text-center">{{ $comment->lesson ? $comment->lesson->title : 'Không xác định' }}</td>
                    <td class="text-center">{{ $comment->likes ?? 0 }}</td>
                </tr>
                @endforeach
                @if ($comments->isEmpty())
                <tr>
                    <td colspan="8" class="text-center">Không có dữ liệu</td>
                </tr>
                @endif
            </tbody>
        </table>
    </form>
</div>

<!-- Pagination -->
<div class="tw-flex tw-justify-between tw-items-center tw-mt-4 tw-px-1">
    <span class="tw-text-sm tw-text-gray-600">Hiển thị {{ $comments->count() }} / Tổng số bình luận</span>
    {{ $comments->links() }}
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('input[name="comment_ids[]"]').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection