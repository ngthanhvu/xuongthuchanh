@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Thêm Quiz</h2>
        <form action="{{ route('admin.quizzes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="lesson_id" class="form-label">Chọn bài học</label>
                <select name="lesson_id" id="lesson_id" class="form-control" required>
                    <option value="">-- Chọn bài học --</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Thêm</button>
        </form>
    </div>
@endsection
