@extends('layouts.master')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <!-- Left Section -->
            <div class="col-md-8">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Bạn sẽ học được gì?</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fa-solid fa-check"></i>
                                {{ $course->description ?? 'Các kiến thức căn bản, nền móng của ngành IT' }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Nội dung khóa học</h5>
                        <p>
                            {{ is_countable($sections) ? count($sections) : 0 }} chương •
                            {{ is_countable($lessons) ? count($lessons) : 0 }} bài học •
                            {{ is_countable($quizzes) ? count($quizzes) : 0 }} bài kiểm tra •
                            Thời lượng {{ $course->duration ?? '03 giờ 26 phút' }}
                        </p>
                        <div class="accordion" id="courseContentAccordion">
                            @if ($sections->count() > 0)
                                @foreach ($sections as $index => $section)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $index }}"
                                                aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $index }}">
                                                {{ $index + 1 }}. {{ $section->title }}
                                                <span class="float-end">{{ count($section->lessons) }} bài học</span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}"
                                            class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                            aria-labelledby="heading{{ $index }}"
                                            data-bs-parent="#courseContentAccordion">
                                            <div class="accordion-body">
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($section->lessons as $lesson)
                                                        <li class="list-group-item">
                                                            <input type="radio" class="me-2"> {{ $lesson->title }}
                                                            <span
                                                                class="float-end">{{ $lesson->duration ?? '10:00' }}</span>
                                                        </li>
                                                        @if ($lesson->quizzes->count() > 0)
                                                            <ul class="list-group ms-4">
                                                                @foreach ($lesson->quizzes as $quiz)
                                                                <li class="list-group-item">
                                                                    @if (Auth::check() && \App\Models\Enrollment::where('user_id', Auth::id())->where('course_id', $lesson->section->course->id)->exists())
                                                                        <a href="{{ route('showquizz', ['quiz' => $quiz->id]) }}" class="text-decoration-none">
                                                                            Quizz {{ $loop->iteration }}: {{ $quiz->title }}
                                                                        </a>
                                                                    @else
                                                                        <span class="text-muted">
                                                                            Quizz {{ $loop->iteration }}: {{ $quiz->title }}
                                                                            <small class="text-danger">(Đăng kí khóa học mới có thể làm)</small>
                                                                        </span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                            </ul>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Chưa có nội dung khóa học nào.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Section -->
            <div class="col-md-4">
                <div class="card video-card mb-4">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text">Xem giới thiệu khóa học</p>
                    <video controls width="100%">
                        <source src="{{ $lessons->first()->file_url ?? 'path-to-video.mp4' }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div class="card card-custom">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $course->price == 0 ? 'Miễn phí' : number_format($course->price, 2) }}đ
                        </h5>
                        <p class="text-muted">Đăng ký học</p>
                        <form method="POST" action="{{ route('payment.create') }}">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <input type="hidden" name="price" value="{{ $course->price }}">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </form>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle me-2"></i> Trình độ cơ bản</li>
                            <li><i class="bi bi-check-circle me-2"></i> Tổng số {{ $lessons ? count($lessons) : 0 }} bài
                                học</li>
                            <li><i class="bi bi-check-circle me-2"></i> Thời lượng
                                {{ $course->duration ?? '03 giờ 26 phút' }}</li>
                            <li><i class="bi bi-check-circle me-2"></i> Học mọi lúc, mọi nơi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .video-card {
            background: linear-gradient(to right, #ff4b1f, #ff9068);
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .accordion-button {
            font-weight: bold;
        }

        .accordion-button:not(.collapsed) {
            color: #dc3545;
            background-color: #f8f9fa;
        }

        .accordion-body {
            padding: 0;
        }

        .list-group-item {
            border: none;
        }
    </style>
@endsection
