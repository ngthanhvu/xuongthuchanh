@extends('layouts.master')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="container">
        <h2>{{ $quiz->title }}</h2>
        <p><strong>Số câu hỏi:</strong> {{ $quiz->questions->count() }}</p>

        <form action="{{ route('submit.quiz', ['quiz' => $quiz->id]) }}" method="POST">
            @csrf
            <ul class="list-group">
                @foreach ($quiz->questions as $index => $question)
                    <li class="list-group-item">
                        <strong>Câu {{ $index + 1 }}:</strong> {{ $question->question_text }}

                        @if ($question->answers->count() > 0)
                            <ul class="list-group mt-2">
                                @foreach ($question->answers as $answer)
                                    <li class="list-group-item">
                                        <input type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $answer->id }}">
                                        {{ $answer->answer_text }}

                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Chưa có câu trả lời cho câu hỏi này.</p>
                        @endif
                    </li>
                @endforeach
            </ul>
            <button type="submit" class="btn btn-primary mt-3">Nộp bài</button>
        </form>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
@endsection
