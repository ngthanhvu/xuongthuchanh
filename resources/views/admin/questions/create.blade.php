@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Thêm câu hỏi mới</h2>
        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Quiz</label>
                <select name="quiz_id" class="form-control" required>
                    <option value="">-- Chọn Quiz --</option>
                    @foreach ($quizzes as $quiz)
                        <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Câu hỏi</label>
                <input type="text" name="question_text" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>
@endsection
