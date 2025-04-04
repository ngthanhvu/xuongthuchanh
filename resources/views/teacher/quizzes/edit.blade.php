@extends('layouts.teacher')

@section('content')
    <div class="container">
        <h2>Chỉnh sửa Quiz</h2>
        <form action="{{ route('teacher.quizzes.update', $quiz) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="lesson_id" class="form-label">Chọn bài học</label>
                <select name="lesson_id" id="lesson_id" class="form-control" required>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ $quiz->lesson_id == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $quiz->title }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control">{{ $quiz->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-secondary">Thoát</a>
        </form>
    </div>
@endsection
