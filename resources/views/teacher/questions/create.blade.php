@extends('layouts.teacher')

@section('content')
    <div class="container">
        <h2>{{ $title }}</h2>
        <form action="{{ route('teacher.questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Quiz</label>
                <select name="quiz_id" class="form-control" >
                    <option value="">-- Chọn Quiz --</option>
                    @foreach ($quizzes as $quiz)
                        <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                    @endforeach
                    @error('quiz_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Câu hỏi</label>
                <input type="text" name="question_text" class="form-control" placeholder="Nhập câu hỏi">
                @error('question_text')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Thêm câu hỏi</button>
            <a href="{{ route('teacher.questions.index') }}" class="btn btn-secondary">Thoát</a>
        </form>
    </div>
@endsection
