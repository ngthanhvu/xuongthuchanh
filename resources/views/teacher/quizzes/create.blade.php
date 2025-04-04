@extends('layouts.teacher')

@section('content')
    <div class="container">
        <h2>Thêm Quiz</h2>
        <form action="{{ route('teacher.quizzes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="lesson_id" class="form-label">Chọn bài học</label>
                <select name="lesson_id" id="lesson_id" class="form-control">
                    <option value="">-- Chọn bài học --</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                    @error('lesson_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Nhập tiêu đề">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control" placeholder="Nhập mô tả"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Thêm Quiz</button>
            <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-secondary">Thoát</a>
        </form>
    </div>
@endsection
