@extends('layouts.admin')

@section('content')
    <div class="">
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-6">
            <div>
                <h3 class="tw-text-2xl tw-font-bold">Quản lý câu hỏi</h3>
                <p class="tw-text-gray-500 tw-mt-1">Danh sách các câu hỏi đang có!</p>
            </div>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Thêm câu hỏi
            </a>
        </div>

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

        <!-- Table -->
        <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
            <table class="table table-bordered align-middle mb-0">
                <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                    <tr>
                        <th class="tw-py-3">#</th>
                        <th class="tw-py-3">Câu hỏi</th>
                        <th class="tw-py-3">Quiz</th>
                        <th class="tw-py-3">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $index => $question)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $question->question_text }}</td>
                            <td class="text-center">{{ $question->quiz->title }}</td>
                            <td class="text-center">

                                <a href="{{ route('admin.questions.edit', $question) }}"
                                    class="btn btn-sm btn-outline-primary tw-me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($questions->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">Không có dữ liệu</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>


    </div>
@endsection
