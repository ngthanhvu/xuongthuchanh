<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lesson->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="icon" type="image/png" sizes="32x32" href="https://fullstack.edu.vn/favicon/favicon_32x32.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .iframe-section {
            background-color: #000;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            position: relative;
        }
        .iframe-section iframe {
            width: 100%;
            height: 100%;
            display: block;
        }
        .lesson-list {
            background-color: #fff;
            border-left: 1px solid #dee2e6;
            height: 500px;
            overflow-y: auto;
        }
        .accordion-button {
            font-weight: bold;
            color: #dc3545;
        }
        .accordion-button:not(.collapsed) {
            color: #dc3545;
            background-color: #f8f9fa;
        }
        .accordion-body {
            padding: 0;
        }
        .lesson-item {
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
            display: block;
            text-decoration: none;
            color: inherit;
        }
        .lesson-item:hover {
            background-color: #f1f1f1;
        }
        .lesson-item.active {
            background-color: #ffe5e5;
        }
        .header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-top: 1px solid #dee2e6;
        }
        .btn-countdown:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
</head>

<body>
    @if (session('success'))
        <script>
            iziToast.success({
                title: 'Thành công',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            iziToast.error({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        </script>
    @endif
    <div class="header d-flex justify-content-between align-items-center">
        <a href="{{ route('home') }}" class="text-decoration-none text-white"><i class="fa-solid fa-arrow-left"></i> Trang chủ</a>
        <div>{{ $lesson->title }}</div>
        <div>{{ $sections->sum(fn($section) => $section->lessons->count()) }} bài học</div>
        <div class="progress" style="width: 200px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                {{ $progress }}%
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 p-0">
                <div class="iframe-section">
                    @if ($lesson->file_url)
                        <iframe width="100%" height="100%"
                            src="{{ preg_replace('/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', 'https://www.youtube.com/embed/$1', $lesson->file_url) }}?controls=0&rel=0&showinfo=0&modestbranding=1&iv_load_policy=3&fs=1"
                            title="{{ $lesson->title }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    @else
                        <img src="{{ asset('path-to-iframe-placeholder.jpg') }}" alt="Video Placeholder">
                    @endif
                </div>
                <div class="d-flex justify-content-end mt-3">
                    @if ($prevLesson)
                        <a href="{{ route('lesson', $prevLesson->id) }}" class="btn btn-light me-2">BÀI TRƯỚC</a>
                    @else
                        <button class="btn btn-light me-2" disabled>BÀI TRƯỚC</button>
                    @endif
                    @if ($nextLesson)
                        <form action="{{ route('nextLesson', $nextLesson->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="current_lesson_id" value="{{ $lesson->id }}">
                            <button type="submit" class="btn btn-primary btn-countdown" id="nextLessonBtn" disabled>
                                BÀI TIẾP THEO (<span id="countdown">15</span>s)
                            </button>
                        </form>
                    @else
                        <form action="{{ route('nextLesson') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="current_lesson_id" value="{{ $lesson->id }}">
                            <button type="submit" class="btn btn-primary btn-countdown" id="nextLessonBtn" disabled>
                                HOÀN THÀNH KHÓA HỌC (<span id="countdown">15</span>s)
                            </button>
                        </form>
                    @endif
                </div>

                {{-- @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif --}}

                <div class="footer d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $lesson->title }}</h5>
                        <p>Cập nhật {{ $lesson->updated_at->format('F Y') }}</p>
                        <p class="mt-3">{{ $lesson->content }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 p-0">
                <div class="lesson-list">
                    <h6 class="p-3 border-bottom">NỘI DUNG KHÓA HỌC</h6>
                    <div class="accordion" id="lessonAccordion">
                        @foreach ($sections as $index => $section)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#module{{ $section->id }}"
                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-controls="module{{ $section->id }}">
                                        {{ $index + 1 }}. {{ $section->title }}
                                    </button>
                                </h2>
                                <div id="module{{ $section->id }}"
                                    class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                    data-bs-parent="#lessonAccordion">
                                    <div class="accordion-body">
                                        @if ($section->lessons->isNotEmpty())
                                            @foreach ($section->lessons as $lessonItem)
                                                <a href="{{ route('lesson', $lessonItem->id) }}"
                                                    class="lesson-item {{ $lessonItem->id == $lesson->id ? 'active' : '' }}">
                                                    {{ $lessonItem->title }}
                                                    @if (in_array($lessonItem->id, $completedLessons))
                                                        <span class="float-end text-success">
                                                            <i class="fa-solid fa-check"></i>
                                                        </span>
                                                    @endif
                                                </a>

                                                @if ($lessonItem->quizzes->isNotEmpty())
                                                    @foreach ($lessonItem->quizzes as $quiz)
                                                        <div class="ms-3">
                                                            @if (Auth::check() && Auth::user()->hasEnrolled($lessonItem->section->course->id))
                                                                <a href="{{ route('quizzes', $lessonItem->id) }}"
                                                                    class="lesson-item">
                                                                    Quiz: {{ $quiz->title }}
                                                                    @if ($quiz->isCompletedBy(Auth::user()))
                                                                        <span class="float-end text-success">
                                                                            Điểm:
                                                                            {{ number_format($quiz->getUserScore(Auth::user()), 0) }}/100
                                                                        </span>
                                                                    @else
                                                                        <span class="float-end text-danger">
                                                                            Bạn Chưa Làm
                                                                        </span>
                                                                    @endif
                                                                </a>
                                                            @else
                                                                <span class="lesson-item text-muted">
                                                                    Quiz: {{ $quiz->title }}
                                                                    <small class="text-danger">(Đăng ký để làm)</small>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="lesson-item">Chưa có bài học</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nextBtn = document.getElementById('nextLessonBtn');
            const countdownElement = document.getElementById('countdown');
            let timeLeft = 15;

            const countdown = setInterval(function () {
                timeLeft--;
                countdownElement.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    nextBtn.disabled = false;
                    nextBtn.innerHTML = nextBtn.innerHTML.replace(/ \(\d+s\)/, ''); 
                }
            }, 1000);
        });
    </script>
</body>
</html>