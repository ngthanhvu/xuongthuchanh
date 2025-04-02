@extends('layouts.master')
@section('content')
    <style>
        /* General Card Styling */
        .course-card {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .course-card:hover {
            transform: scale(1.02);
        }

        .course-header {
            background-color: #f1f3f5;
            padding: 12px 16px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .course-body {
            padding: 16px;
        }

        /* Progress Bar Styling */
        .progress {
            height: 12px;
            border-radius: 6px;
            background-color: #e9ecef;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #28a745;
            transition: width 0.4s ease;
        }

        /* Lesson Item Styling */
        .lesson-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lesson-item a {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
            transition: color 0.2s;
        }

        .lesson-item a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Quiz Status Styling */
        .quiz-status {
            font-size: 0.9em;
            color: #6c757d;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .completed {
            color: #28a745;
            font-weight: bold;
        }

        .not-completed {
            color: #dc3545;
            font-weight: bold;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .btn-orange {
            background-color: #fd7e14;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-orange:hover {
            background-color: #e56700;
        }
    </style>

    <div class="header d-flex justify-content-between align-items-center">
        <h4 class="m-0">Lộ trình học tập</h4>
    </div>

    <div class="container mt-4">
        <h5 class="mb-3">Các khóa học đã đăng ký</h5>

        @if (Auth::check() && $courses->isNotEmpty())
            @foreach ($courses as $course)
                <div class="card mb-4 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-fluid rounded-start"
                                alt="Thumbnail" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->title }}</h5>
                                <p class="card-text"><strong>Tiến độ: </strong></p>
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $course->pivot->progress }}%;"
                                        aria-valuenow="{{ $course->pivot->progress }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="card-text text-muted">{{ $course->pivot->progress }}% hoàn thành</p>

                                @if ($course->pivot->status === 'completed')
                                    <p class="text-success">Hoàn thành vào:
                                        {{ $course->pivot->completed_at->format('d/m/Y') }}</p>
                                @endif

                                <button class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#courseModal"
                                    data-course-id="{{ $course->id }}">Xem chi tiết</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <!-- Modal -->
            <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="courseModalLabel">Chi tiết khóa học</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="courseModalBody">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="course-details" style="display: none;">
                @foreach ($courses as $course)
                    <div class="course-detail" data-course-id="{{ $course->id }}">
                        <div class="course-card">
                            <div class="course-header d-flex justify-content-between align-items-center">
                                <h6 class="m-0">{{ $course->title }}</h6>
                                <span>{{ $course->sections->sum(fn($section) => $section->lessons->count()) }} bài
                                    học</span>
                            </div>
                            <div class="course-body">
                                <div class="mb-3">
                                    <strong>Tiến độ: </strong>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $course->pivot->progress }}%"
                                            aria-valuenow="{{ $course->pivot->progress }}" aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ $course->pivot->progress }}%
                                        </div>
                                    </div>
                                    @if ($course->pivot->status === 'completed')
                                        <small class="text-success">Hoàn thành vào:
                                            {{ $course->pivot->completed_at->format('d/m/Y') }}</small>
                                    @endif
                                </div>

                                @foreach ($course->sections as $section)
                                    <div class="mb-3">
                                        <h6>{{ $section->title }}</h6>
                                        @foreach ($section->lessons as $lesson)
                                        <div class="lesson-item d-flex justify-content-between align-items-center">
                                            <a href="{{ route('lesson', $lesson->id) }}" class="text-decoration-none">
                                                {{ $lesson->title }}
                                            </a>
                                            
                                            <span>
                                                @if ($lesson->isCompletedBy(Auth::user()))
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @else
                                                    <i class="fas fa-circle-notch text-muted"></i>
                                                    <a href="{{ route('lesson', $lesson->id) }}" class="btn btn-orange btn-sm ms-3 text-white text-decoration-none">
                                                        Tiếp Tục Học
                                                    </a>
                                                @endif
                                            </span>
                                        </div>
                                        

                                            @if ($lesson->quizzes->isNotEmpty())
                                                @foreach ($lesson->quizzes as $quiz)
                                                    <div
                                                        class="lesson-item quiz-status d-flex justify-content-between ms-3">
                                                        <span>Quiz: {{ $quiz->title }}</span>
                                                        @if ($quiz->isCompletedBy(Auth::user()))
                                                            <span class="completed">
                                                                Điểm:
                                                                {{ number_format($quiz->getUserScore(Auth::user()), 0) }}/100
                                                            </span>
                                                        @else
                                                            <span class="not-completed">Chưa làm</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                Bạn chưa đăng ký khóa học nào. <a href="{{ route('courses') }}" class="alert-link">Xem danh sách khóa
                    học</a>.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var courseModal = document.getElementById('courseModal');
            courseModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var courseId = button.getAttribute('data-course-id');
                var courseDetail = document.querySelector(
                    '#course-details .course-detail[data-course-id="' + courseId + '"]');

                if (courseDetail) {
                    // Sao chép nội dung chi tiết vào modal
                    document.getElementById('courseModalBody').innerHTML = courseDetail.innerHTML;
                }
            });
        });
    </script>
@endsection
