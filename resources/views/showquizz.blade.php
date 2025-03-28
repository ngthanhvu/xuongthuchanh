@extends('layouts.master')

@section('content')
    <div class="container">
        <h2 class="mb-4">Bài kiểm tra cho bài học: {{ $lesson->title }}</h2>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (!$isEnrolled)
            <div class="alert alert-warning" role="alert">
                Vui lòng đăng ký khóa học để làm bài kiểm tra!
                <a href="{{ route('detail', $course->id) }}" class="btn btn-primary mt-2">Đăng ký ngay</a>
            </div>
        @else
            @if ($quizzes->isEmpty())
                <div class="alert alert-info">
                    Chưa có bài kiểm tra nào cho bài học này.
                </div>
            @else
                @foreach ($quizzes as $quiz)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-1">{{ $quiz->title }}</h3>
                                <small class="text-muted">Số câu hỏi: {{ $quiz->questions->count() }}</small>
                            </div>
                            @if ($userQuizResult && $userQuizResult->score >= 100)
                                <span class="badge bg-success">Hoàn thành</span>
                            @endif
                        </div>

                        <div class="card-body">
                            @php
                                $score = $userQuizResult?->score;
                                $selectedAnswers = session('selectedAnswers', []);
                                $answerResults = session('answerResults', []);
                            @endphp

                            @if ($score >= 100)
                                <div class="alert alert-success text-center">
                                    🎉 <strong>Chúc mừng!</strong> Bạn đã hoàn thành bài kiểm tra này với số điểm tuyệt đối!
                                </div>
                            @endif

                            <form action="{{ route('submit.quiz', ['quiz' => $quiz->id]) }}" method="POST">
                                @csrf
                                <div class="quiz-questions">
                                    @foreach ($quiz->questions as $index => $question)
                                        @php
                                            $selected = $selectedAnswers[$question->id] ?? null;
                                        @endphp

                                        <div class="card mb-3 
                                            @if($score >= 100)
                                                border border-success
                                            @elseif($score !== null)
                                                @if(isset($answerResults[$question->id]) && $answerResults[$question->id] == 'incorrect')
                                                    border border-danger
                                                @endif
                                            @endif
                                        ">
                                            <div class="card-body">
                                                <h5 class="card-title">Câu {{ $index + 1 }}: {{ $question->question_text }}</h5>

                                                @if ($question->answers->isNotEmpty())
                                                    <div class="list-group">
                                                        @foreach ($question->answers as $answer)
                                                            @php
                                                                $answerClass = '';
                                                                if ($score !== null) {
                                                                    if ($answer->is_correct && $selected == $answer->id) {
                                                                        $answerClass = 'border border-success';
                                                                    } elseif ($selected == $answer->id && !$answer->is_correct) {
                                                                        $answerClass = 'list-group-item-danger';
                                                                    } elseif ($score >= 100 && $answer->is_correct) {
                                                                        $answerClass = 'list-group-item-success';
                                                                    }
                                                                }
                                                            @endphp
                                                            <label class="list-group-item list-group-item-action {{ $answerClass }}">
                                                                <input type="radio" 
                                                                    name="answers[{{ $question->id }}]"
                                                                    value="{{ $answer->id }}"
                                                                    class="form-check-input me-2"
                                                                    {{ $selected == $answer->id ? 'checked' : '' }}
                                                                    {{ $score >= 100 ? 'disabled' : '' }}>
                                                                {{ $answer->answer_text }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-muted">Chưa có câu trả lời cho câu hỏi này.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    @if ($score !== null && $score < 100)
                                        <button type="submit" class="btn btn-primary">Nộp bài</button>
                                    @elseif ($score === null)
                                        <button type="submit" class="btn btn-primary">Nộp bài</button>
                                    @else

                                    @endif
                                </div>
                                <a href="{{ route('lesson', $lesson->id) }}" class="btn btn-secondary">Quay lại</a>

                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
@endsection