@extends('layouts.teacher')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    <form action="{{ route('teacher.answers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="question_id" class="form-label">Chọn câu hỏi</label>
            <select name="question_id" id="question_id" class="form-control">
                @foreach ($questions as $question)
                    <option value="{{ $question->id }}">{{ $question->question_text }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="answer_text" class="form-label">Câu trả lời</label>
            <input type="text" name="answer_text" id="answer_text" class="form-control" placeholder="Nhập câu trả lời">
        </div>

        <div class="mb-3">
            <label class="form-label">Đáp án đúng?</label>
            <select name="is_correct" class="form-control">
                <option value="1">Đúng</option>
                <option value="0">Sai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thêm câu hỏi</button>
        <a href="{{ route('teacher.answers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
