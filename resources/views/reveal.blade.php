@extends('layouts.master')
@section('content')
    <style>
        /* General Styling */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h3.tw-text-2xl {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }

        h5.mb-3 {
            color: #374151;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Stats Cards Styling */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Chia đều thành 3 cột */
            gap: 1rem; /* Khoảng cách giữa các cột */
            margin-bottom: 1.5rem;
        }

        .stats-grid .card {
            background: linear-gradient(145deg, #ffffff, #f9fafb);
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-grid .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        .stats-grid .card-body {
            padding: 1.5rem;
        }

        .stats-grid .card-title {
            color: #4b5563;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .stats-grid .card-text {
            color: #1f2937;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-grid .tw-text-sm {
            color: #6b7280;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tw-text-blue-600 { color: #2563eb; }
        .tw-text-green-600 { color: #16a34a; }
        .tw-text-purple-600 { color: #7c3aed; }
        .tw-text-green-500 { color: #22c55e; }
        .tw-text-red-500 { color: #ef4444; }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr; /* Trên màn hình nhỏ, chuyển thành 1 cột */
            }
        }

        /* Learning Path Card Styling */
        .path-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .path-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .path-card h5 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .path-card p {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1.25rem;
        }

        .path-card .icons {
            display: flex;
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .path-card .icons img {
            width: 32px;
            height: 32px;
            transition: transform 0.3s ease;
        }

        .path-card .icons img:hover {
            transform: scale(1.1);
        }

        .path-card .btn {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: #fff;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.85rem;
            transition: background 0.3s ease;
        }

        .path-card .btn:hover {
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
        }

        .path-image {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 1.25rem;
            border: 3px solid #e5e7eb;
            border-radius: 50%;
            overflow: hidden;
        }

        .path-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Course Card Styling */
        .course-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .course-header {
            background: #f3f4f6;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            color: #374151;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .course-body {
            padding: 1rem;
        }

      

        /* Lesson Item Styling */
        .lesson-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lesson-item a {
            text-decoration: none;
            color: #2563eb;
            font-weight: 500;
            transition: color 0.2s;
        }

        .lesson-item a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Quiz Status Styling */
        .quiz-status {
            font-size: 0.9em;
            color: #6b7280;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .completed {
            color: #16a34a;
            font-weight: 600;
        }

        .not-completed {
            color: #ef4444;
            font-weight: 600;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
            font-weight: 600;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
        }

        .btn-orange {
            background: linear-gradient(90deg, #fd7e14, #ea580c);
            color: #fff;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .btn-orange:hover {
            background: linear-gradient(90deg, #ea580c, #d94600);
        }

        
    </style>

    <div class="container mt-4">
        <h3 class="tw-text-2xl tw-font-bold tw-mb-6">Lộ Trình Của Bạn</h3>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="card tw-shadow-md">
                <div class="card-body">
                    <h5 class="card-title tw-text-lg tw-font-semibold">Khóa học đã đăng ký</h5>
                    <p class="card-text tw-text-3xl tw-font-bold tw-text-blue-600">{{ $courses->count() }}</p>
                    <p class="tw-text-sm tw-text-gray-500">
                        @if ($courses->count() > 0)
                            <i class="fas fa-arrow-up tw-text-green-500"></i>
                        @else
                            <i class="fas fa-arrow-down tw-text-red-500"></i>
                        @endif
                        {{ $courses->count() }} khóa học
                    </p>
                </div>
            </div>

            <div class="card tw-shadow-md">
                <div class="card-body">
                    <h5 class="card-title tw-text-lg tw-font-semibold">Tiến độ trung bình</h5>
                    <p class="card-text tw-text-3xl tw-font-bold tw-text-green-600">
                        {{ $courses->isNotEmpty() ? number_format($courses->avg('pivot.progress'), 1) : 0 }}%</p>
                    <p class="tw-text-sm tw-text-gray-500">
                        @if ($courses->avg('pivot.progress') > 0)
                            <i class="fas fa-arrow-up tw-text-green-500"></i>
                        @else
                            <i class="fas fa-arrow-down tw-text-red-500"></i>
                        @endif
                        {{ $courses->isNotEmpty() ? number_format($courses->avg('pivot.progress'), 1) : 0 }}% tiến độ
                    </p>
                </div>
            </div>

            <div class="card tw-shadow-md">
                <div class="card-body">
                    <h5 class="card-title tw-text-lg tw-font-semibold">Khóa học đang học</h5>
                    <p class="card-text tw-text-3xl tw-font-bold tw-text-purple-600">
                        {{ $courses->where('pivot.status', '!=', 'completed')->count() }}</p>
                    <p class="tw-text-sm tw-text-gray-500">
                        @if ($courses->where('pivot.status', '!=', 'completed')->count() > 0)
                            <i class="fas fa-arrow-up tw-text-green-500"></i>
                        @else
                            <i class="fas fa-arrow-down tw-text-red-500"></i>
                        @endif
                        {{ $courses->where('pivot.status', '!=', 'completed')->count() }} khóa học chưa hoàn thành
                    </p>
                </div>
            </div>
        </div>

        <!-- Learning Paths Section -->
        <h5 class="mb-3 mt-5">Các Khóa Học</h5>
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
                                                        <a href="{{ route('lesson', $lesson->id) }}"
                                                            class="btn btn-orange btn-sm ms-3 text-white text-decoration-none">
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
                Bạn chưa đăng ký khóa học nào. <a href="/" class="alert-link">Xem các khóa học</a>.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal logic
            var courseModal = document.getElementById('courseModal');
            courseModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var courseId = button.getAttribute('data-course-id');
                var courseDetail = document.querySelector(
                    '#course-details .course-detail[data-course-id="' + courseId + '"]');

                if (courseDetail) {
                    document.getElementById('courseModalBody').innerHTML = courseDetail.innerHTML;
                }
            });

          
        });
    </script>
@endsection