@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Chỉnh sửa câu hỏi</h2>
        <form action="{{ route('admin.questions.update', $question) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Quiz</label>
                <select name="quiz_id" class="form-control" required>
                    @foreach ($quizzes as $quiz)
                        <option value="{{ $quiz->id }}" {{ $question->quiz_id == $quiz->id ? 'selected' : '' }}>
                            {{ $quiz->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Câu hỏi</label>
                <input type="text" name="question_text" class="form-control" value="{{ $question->question_text }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Thoát</a>
        </form>
    </div>
@endsection
