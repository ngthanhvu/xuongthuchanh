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
            <p class="tw-text-gray-500 tw-mt-1">Danh sách Quizzes</p>
        </div>
        <a href="{{ route('admin.quizzes.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Thêm Quizzes
        </a>
    </div>

    <!-- Table -->
    <div class="tw-bg-white tw-rounded-lg tw-shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="tw-bg-gray-100 tw-text-gray-700 text-center">
                <tr>
                    <th scope="col" class="tw-px-6 tw-py-4">#</th>
                    <th scope="col" class="tw-px-6 tw-py-4">Tiêu đề</th>
                    <th scope="col" class="tw-px-6 tw-py-4">Bài học</th>
                    <th scope="col" class="tw-px-6 tw-py-4">Thao tác</th>
                </tr>
                        </thead>
                        <tbody>
                            @foreach ($quizzes as $quiz)
                                <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600">
                                    <td class="tw-px-6 tw-py-4">{{ $quiz->id }}</td>
                                    <td class="tw-px-6 tw-py-4">{{ $quiz->title }}</td>
                                    <td class="tw-px-6 tw-py-4">{{ $quiz->lesson->title }}</td>
                                    <td class="tw-px-6 tw-py-4">
                                        <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST"
                                            onsubmit="return confirm('Ban co chac muon xoa bai hoc nay?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
