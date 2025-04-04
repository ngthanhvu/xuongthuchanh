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
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các đáp án và câu hỏi</p>
        </div>
        <a href="{{ route('teacher.answers.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Thêm đáp án 
        </a>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th class="tw-py-3">#</th>
                    <th class="tw-py-3">Câu hỏi</th>
                    <th class="tw-py-3">Câu trả lời</th>
                    <th class="tw-py-3">Đúng/Sai</th>
                    <th class="tw-py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers as $answer)
                    <tr>
                        <td class="tw-py-3 tw-text-center">{{ $answer->id }}</td>
                        <td class="tw-py-3 tw-text-center">{{ $answer->question->question_text }}</td>
                        <td class="tw-py-3 tw-text-center">{{ $answer->answer_text }}</td>
                        <td class="tw-py-3 tw-text-center">
                            @if ($answer->is_correct)
                                <span class="tw-text-green-500">Đúng</span>
                            @else
                                <span class="tw-text-red-500">Sai</span>
                            @endif
                        </td>
                        <td class="tw-py-3 tw-text-center">
                            <a href="{{ route('teacher.answers.edit', $answer->id) }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <!-- Form xóa -->
                            <form action="{{ route('teacher.answers.destroy', $answer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($answers->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">Không có dữ liệu</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>


@endsection
