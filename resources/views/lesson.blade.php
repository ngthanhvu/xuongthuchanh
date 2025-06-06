<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lesson->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="https://fullstack.edu.vn/favicon/favicon_32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            position: relative;
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

        .comment-section {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .comments-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .toggle-comments-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #fff;
            color: #f4511e;
            border: 1px solid #f4511e;
            /* Thêm viền cho giống các nút khác */
            padding: 6px 12px;
            /* Giảm padding để nút nhỏ hơn */
            border-radius: 5px;
            /* Bo góc nhẹ hơn */
            box-shadow: none;
            /* Loại bỏ shadow nếu muốn đơn giản */
            font-size: 14px;
            /* Giảm kích thước chữ */
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-comments-btn:hover {
            background-color: #ffece5;
        }

        .toggle-comments-btn .icon {
            font-size: 18px;
        }

        #commentSection {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            z-index: 10;
            overflow-y: auto;
            display: none;
        }

        #commentSection.show {
            display: block;
        }

        .comment-header {
            margin-bottom: 15px;
        }

        .comment-header h4 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .comment-header p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .comment-item {
            padding: 15px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .comment-item .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .comment-item .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-item .user-info span {
            font-weight: bold;
            font-size: 1rem;
        }

        .comment-item .comment-time {
            color: #6c757d;
            font-size: 0.85rem;
            margin-left: 10px;
        }

        .comment-item .comment-content {
            margin-top: 5px;
            font-size: 1rem;
            line-height: 1.5;
        }

        .comment-item .actions {
            margin-top: 5px;
        }

        .comment-item .actions a {
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
            margin-right: 15px;
        }

        .comment-item .actions a:hover {
            text-decoration: underline;
        }

        .close-comments-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6c757d;
        }

        /* Add these styles to the existing style section */
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .star-rating {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .star-rating .far {
            color: #ffc107;
        }

        .star-rating .fas {
            color: #ffc107;
        }

        .review-item {
            transition: all 0.3s ease;
        }

        .review-item:hover {
            background-color: #f8f9fa;
        }

        .admin-reply {
            border-left: 3px solid #0d6efd;
            background-color: #f8f9fa;
        }

        .toggle-reply {
            transition: all 0.3s ease;
        }

        .toggle-reply:hover {
            background-color: #007bff;
            color: white;
        }

        .reply-form {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    @if (session('success'))
    <script>
        iziToast.success({
            title: 'Thành công',
            message: '{{ session('
            success ') }}',
            position: 'topRight'
        });
    </script>
    @endif
    @if (session('error'))
    <script>
        iziToast.error({
            title: 'Lỗi',
            message: '{{ session('
            error ') }}',
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
                    <button class="toggle-comments-btn ms-2" type="button" onclick="toggleComments()">
                        <span class="icon">
                            <i class="fas fa-comments"></i>
                        </span>
                        <span class="text">Hỏi đáp</span>
                    </button>
                </div>

                <div class="footer d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $lesson->title }}</h5>
                        <p>Cập nhật {{ $lesson->updated_at->format('F Y') }}</p>
                        <p class="mt-3">{{ $lesson->content }}</p>
                    </div>
                </div>
                <div class="card card-custom mb-4 mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-center">Đánh giá khóa học</h5>
                        @php
                        $reviews = \App\Models\Review::with('user')
                        ->where('course_id', $lesson->section->course->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                        $averageRating = $reviews->avg('rating');
                        $ratingCounts = $reviews->groupBy('rating')->map->count();
                        @endphp

                        <div class="col-md-12 d-flex justify-content-center align-items-center mb-4">
                            <div class="col-md-3 text-center">
                                <h2 class="text-primary">{{ number_format($averageRating, 1) }}</h2>
                                <div class="star-rating mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor
                                </div>
                                <p>{{ $reviews->count() }} đánh giá</p>
                            </div>
                        </div>

                        @auth
                        @if(!$reviews->where('user_id', auth()->id())->first())
                        <div class="review-form mb-4">
                            <h6>Đánh giá của bạn</h6>
                            <form method="POST" action="{{ route('reviews.store') }}" id="reviewForm">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $lesson->section->course->id }}">

                                <div class="form-group mb-3">
                                    <div class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star" data-rating="{{ $i }}"></i>
                                            @endfor
                                            <input type="hidden" name="rating" id="ratingValue" value="5" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <textarea name="content" class="form-control" rows="3"
                                        placeholder="Chia sẻ trải nghiệm của bạn về khóa học này..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                            </form>
                        </div>
                        @endif
                        @else
                        <p><a href="{{ route('login') }}" class="btn btn-outline-primary">Đăng nhập</a> để đánh giá khóa học</p>
                        @endauth

                        <div class="reviews-list">
                            <h6>Đánh giá từ học viên</h6>
                            @if($reviews->count() > 0)
                            @foreach($reviews as $review)
                            <div class="review-item mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <strong>{{ $review->user->name }}</strong>
                                        <div class="star-rating d-inline-block ms-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                                @endfor
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        @auth
                                        @if(auth()->user()->role == 'admin'|| auth()->user()->role == 'teacher' || auth()->user()->role == 'owner' || auth()->user()->id === $review->user_id)
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-2" onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @endauth
                                    </div>
                                </div>

                                @if($review->content)
                                <p class="mb-2">{{ $review->content }}</p>
                                @endif

                                @if($review->admin_reply)
                                <div class="admin-reply p-3 bg-light rounded mt-2">
                                    <div class="d-flex justify-content-between">
                                        <strong>Phản hồi từ quản trị viên</strong>
                                        <small class="text-muted">{{ $review->updated_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0">{{ $review->admin_reply }}</p>
                                </div>
                                @endif

                                @auth
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher' || auth()->user()->role === 'owner' && !$review->admin_reply)
                                <button class="btn btn-sm btn-outline-primary mt-2 toggle-reply" data-review-id="{{ $review->id }}">
                                    <i class="fas fa-reply"></i> Phản hồi
                                </button>

                                <div class="reply-form mt-2" id="reply-form-{{ $review->id }}" style="display: none;">
                                    <form method="POST" action="{{ route('reviews.reply', $review) }}">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <textarea name="admin_reply" class="form-control" rows="2"
                                                placeholder="Nhập phản hồi của bạn..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary">Gửi</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary cancel-reply"
                                            data-review-id="{{ $review->id }}">Hủy</button>
                                    </form>
                                </div>
                                @endif
                                @endauth
                            </div>
                            @endforeach
                            @else
                            <p>Chưa có đánh giá nào cho khóa học này.</p>
                            @endif
                        </div>
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

                    <div class="comment-section" id="commentSection">
                        <button class="close-comments-btn" onclick="toggleComments()">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="comment-header">
                            <h4>Bình luận</h4>
                        </div>
                        <div class="card-body">
                            @if(Auth::check())
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $lesson->section->course->id }}">
                                <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                                <div class="d-flex align-items-center">
                                    @if (Auth::check())
                                    <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                        alt="{{ Auth::user()->username }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                    <div class="form-group flex-grow-1 mb-0">
                                        <input type="text" class="form-control comment-input" name="content"
                                            placeholder="Nhập bình luận mới của bạn"
                                            style="border-radius: 20px; background-color: #e6f0fa; border: none; padding: 10px 15px;">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="submit" id="submitButton" class="btn btn-primary btn-sm"
                                        style="border-radius: 20px;">Gửi</button>
                                </div>
                                @else
                                <div class="alert alert-info">
                                    Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi bình luận.
                                </div>
                                @endif
                            </form>
                            @else
                            <div class="alert alert-info">
                                Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để gửi câu hỏi.
                            </div>
                            @endif
                        </div>

                        <div class="comments-list mt-4">
                            @if($lesson->section->course->comments->where('parent_id', null)->count() > 0)
                            <div class="comment-header">
                                <h4>{{ $lesson->section->course->comments->where('parent_id', null)->count() }} bình luận</h4>
                            </div>
                            @foreach($lesson->section->course->comments->where('parent_id', null)->sortByDesc('created_at') as $comment)
                            <div class="comment-item" id="comment-{{ $comment->id }}">
                                @if(Auth::id() === $comment->user_id || Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                                <div class="dropdown text-end">
                                    <a class="text-muted" href="#" role="button" id="dropdownMenu{{ $comment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $comment->id }}">
                                        <li><a class="dropdown-item" href="#" onclick="showEditForm({{ $comment->id }}); return false;">Chỉnh sửa</a></li>
                                        <li>
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">Xóa bình luận</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @else
                                <div class="dropdown text-end">
                                    <a class="text-muted" href="#" role="button" id="dropdownMenuReport{{ $comment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuReport{{ $comment->id }}">
                                        <li><a class="dropdown-item" href="#">Báo cáo vi phạm</a></li>
                                    </ul>
                                </div>
                                @endif
                                <div class="user-info">
                                    <img src="{{ $comment->user->avatar ? asset($comment->user->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                        alt="{{ $comment->user->username }}">
                                    <span>{{ $comment->user->username }}</span>
                                    <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="comment-content">
                                    <p>{{ $comment->content }}</p>
                                </div>
                                <div class="actions">
                                    <a href="#" class="like-btn" data-comment-id="{{ $comment->id }}" onclick="likeComment({{ $comment->id }}); return false;">
                                        <i class="fa-{{ in_array($comment->id, $likedComments ?? []) ? 'solid' : 'regular' }} fa-thumbs-up"></i>
                                        <span id="likes-count-{{ $comment->id }}">{{ $comment->likes }}</span> Thích
                                    </a>
                                    <a href="#" onclick="showReplyForm({{ $comment->id }}); return false;">Phản hồi</a>
                                </div>

                                <!-- Form phản hồi -->
                                <div id="replyForm-{{ $comment->id }}" class="reply-form mt-3" style="display: none;">
                                    <form action="{{ route('comments.reply') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                                alt="{{ Auth::user()->username }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <div class="form-group flex-grow-1 mb-0">
                                                <input type="text" class="form-control reply-input" name="content"
                                                    placeholder="Viết phản hồi..."
                                                    data-username="{{ $comment->user->username }}"
                                                    style="border-radius: 20px; background-color: #e6f0fa; border: none; padding: 8px 15px;">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="button" class="btn btn-light btn-sm me-2" onclick="hideReplyForm({{ $comment->id }})"
                                                style="border-radius: 20px;">Hủy</button>
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                style="border-radius: 20px;">Gửi</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Hiển thị các phản hồi của bình luận này -->
                                @if($comment->replies->count() > 0)
                                <div class="replies ms-4 mt-3">
                                    @foreach($comment->replies as $reply)
                                    <div class="comment-item" id="comment-{{ $reply->id }}">
                                        <!-- Menu dropdown cho phản hồi -->
                                        @if(Auth::id() === $reply->user_id || Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                                        <div class="dropdown text-end">
                                            <a class="text-muted" href="#" role="button" id="dropdownMenuReply{{ $reply->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuReply{{ $reply->id }}">
                                                <li><a class="dropdown-item" href="#" onclick="showEditReplyForm({{ $reply->id }}); return false;">Chỉnh sửa</a></li>
                                                <li>
                                                    <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phản hồi này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Xóa phản hồi</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        @else
                                        <div class="dropdown text-end">
                                            <a class="text-muted" href="#" role="button" id="dropdownMenuReportReply{{ $reply->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuReportReply{{ $reply->id }}">
                                                <li><a class="dropdown-item" href="#">Báo cáo vi phạm</a></li>
                                            </ul>
                                        </div>
                                        @endif

                                        <div class="user-info">
                                            <img src="{{ $reply->user->avatar ? asset($reply->user->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                                alt="{{ $reply->user->username }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <span>{{ $reply->user->username }}</span>
                                            <span class="comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="comment-content">
                                            <p>{{ $reply->content }}</p>
                                        </div>

                                        <!-- Thêm nút "Thích" và "Phản hồi" cho phản hồi -->
                                        <div class="actions">
                                            <a href="#" class="like-btn" data-comment-id="{{ $reply->id }}" onclick="likeComment({{ $reply->id }}); return false;">
                                                <i class="fa-{{ in_array($reply->id, $likedComments ?? []) ? 'solid' : 'regular' }} fa-thumbs-up"></i>
                                                <span id="likes-count-{{ $reply->id }}">{{ $reply->likes }}</span> Thích
                                            </a>
                                            <a href="#" onclick="showNestedReplyForm({{ $reply->id }}); return false;">Phản hồi</a>
                                        </div>

                                        <!-- Form chỉnh sửa phản hồi (ẩn ban đầu) -->
                                        <div id="editReplyForm-{{ $reply->id }}" class="edit-reply-form mt-2" style="display: none;">
                                            <form action="{{ route('comments.update', $reply->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $reply->user->avatar ? asset($reply->user->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                                        alt="{{ $reply->user->username }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                                    <div class="form-group flex-grow-1 mb-0">
                                                        <input type="text" class="form-control edit-input" name="content"
                                                            value="{{ $reply->content }}"
                                                            style="border-radius: 20px; background-color: #e6f0fa; border: none; padding: 8px 15px;">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end mt-2">
                                                    <button type="button" class="btn btn-light btn-sm me-2" onclick="hideEditReplyForm({{ $reply->id }})"
                                                        style="border-radius: 20px;">Hủy</button>
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                        style="border-radius: 20px;">Lưu</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Form phản hồi cho phản hồi (nested reply) -->
                                        <div id="nestedReplyForm-{{ $reply->id }}" class="nested-reply-form mt-3" style="display: none;">
                                            <form action="{{ route('comments.reply') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="comment_id" value="{{ $reply->id }}">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                                        alt="{{ Auth::user()->username }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                                    <div class="form-group flex-grow-1 mb-0">
                                                        <input type="text" class="form-control nested-reply-input" name="content"
                                                            placeholder="Viết phản hồi..."
                                                            data-username="{{ $reply->user->username }}"
                                                            style="border-radius: 20px; background-color: #e6f0fa; border: none; padding: 8px 15px;">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end mt-2">
                                                    <button type="button" class="btn btn-light btn-sm me-2" onclick="hideNestedReplyForm({{ $reply->id }})"
                                                        style="border-radius: 20px;">Hủy</button>
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                        style="border-radius: 20px;">Gửi</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Hiển thị các phản hồi lồng nhau (nested replies) -->
                                        @if($reply->replies->count() > 0)
                                        <div class="nested-replies ms-4 mt-3">
                                            @foreach($reply->replies as $nestedReply)
                                            <div class="comment-item" id="comment-{{ $nestedReply->id }}">
                                                <!-- Menu dropdown cho phản hồi lồng nhau -->
                                                @if(Auth::id() === $nestedReply->user_id || Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
                                                <div class="dropdown text-end">
                                                    <a class="text-muted" href="#" role="button" id="dropdownMenuNestedReply{{ $nestedReply->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuNestedReply{{ $nestedReply->id }}">
                                                        <li><a class="dropdown-item" href="#" onclick="showEditReplyForm({{ $nestedReply->id }}); return false;">Chỉnh sửa</a></li>
                                                        <li>
                                                            <form action="{{ route('comments.destroy', $nestedReply->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phản hồi này?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">Xóa phản hồi</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @else
                                                <div class="dropdown text-end">
                                                    <a class="text-muted" href="#" role="button" id="dropdownMenuReportNestedReply{{ $nestedReply->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuReportNestedReply{{ $nestedReply->id }}">
                                                        <li><a class="dropdown-item" href="#">Báo cáo vi phạm</a></li>
                                                    </ul>
                                                </div>
                                                @endif

                                                <div class="user-info">
                                                    <img src="{{ $nestedReply->user->avatar ? asset($nestedReply->user->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                                        alt="{{ $nestedReply->user->username }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                                    <span>{{ $nestedReply->user->username }}</span>
                                                    <span class="comment-time">{{ $nestedReply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="comment-content">
                                                    <p>{{ $nestedReply->content }}</p>
                                                </div>

                                                <!-- Thêm nút "Thích" và "Phản hồi" cho phản hồi lồng nhau -->
                                                <div class="actions">
                                                    <a href="#" class="like-btn" data-comment-id="{{ $nestedReply->id }}" onclick="likeComment({{ $nestedReply->id }}); return false;">
                                                        <i class="fa-{{ in_array($nestedReply->id, $likedComments ?? []) ? 'solid' : 'regular' }} fa-thumbs-up"></i>
                                                        {{-- <span id="likes-count-{{ $nestedReply->id }}">{{ $nestedReply->likes }}</span> Thích --}}
                                                        <span id="likes-count-{{ $comment->id }}">{{ $comment->likes }}</span> Thích
                                                    </a>
                                                    <a href="#" onclick="showNestedReplyForm({{ $nestedReply->id }}); return false;">Phản hồi</a>
                                                </div>

                                                <!-- Form chỉnh sửa cho phản hồi lồng nhau -->
                                                <div id="editReplyForm-{{ $nestedReply->id }}" class="edit-reply-form mt-2" style="display: none;">
                                                    <form action="{{ route('comments.update', $nestedReply->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $nestedReply->user->avatar ? asset($nestedReply->user->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                                                alt="{{ $nestedReply->user->username }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                                            <div class="form-group flex-grow-1 mb-0">
                                                                <input type="text" class="form-control edit-input" name="content"
                                                                    value="{{ $nestedReply->content }}"
                                                                    style="border-radius: 20px; background-color: #e6f0fa; border: none; padding: 8px 15px;">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-2">
                                                            <button type="button" class="btn btn-light btn-sm me-2" onclick="hideEditReplyForm({{ $nestedReply->id }})"
                                                                style="border-radius: 20px;">Hủy</button>
                                                            <button type="submit" class="btn btn-primary btn-sm"
                                                                style="border-radius: 20px;">Lưu</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <!-- Form phản hồi cho phản hồi lồng nhau -->
                                                <div id="nestedReplyForm-{{ $nestedReply->id }}" class="nested-reply-form mt-3" style="display: none;">
                                                    <form action="{{ route('comments.reply') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="comment_id" value="{{ $nestedReply->id }}">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                                                alt="{{ Auth::user()->username }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                                            <div class="form-group flex-grow-1 mb-0">
                                                                <input type="text" class="form-control nested-reply-input" name="content"
                                                                    placeholder="Viết phản hồi..."
                                                                    data-username="{{ $nestedReply->user->username }}"
                                                                    style="border-radius: 20px; background-color: #e6f0fa; border: none; padding: 8px 15px;">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-2">
                                                            <button type="button" class="btn btn-light btn-sm me-2" onclick="hideNestedReplyForm({{ $nestedReply->id }})"
                                                                style="border-radius: 20px;">Hủy</button>
                                                            <button type="submit" class="btn btn-primary btn-sm"
                                                                style="border-radius: 20px;">Gửi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                <!-- Edit form (initially hidden) -->
                                <div id="editForm-{{ $comment->id }}" class="edit-comment-form mt-2" style="display: none;">
                                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $comment->user->avatar ? asset($comment->user->avatar) : asset('https://www.gravatar.com/avatar/dfb7d7bb286d54795ab66227e90ff048.jpg?s=80&d=mp&r=g') }}"
                                                alt="{{ $comment->user->username }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <div class="form-group flex-grow-1 mb-0">
                                                <input type="text" class="form-control edit-input" name="content"
                                                    value="{{ $comment->content }}"
                                                    style="border-radius: 20px; background-color: #e6f0fa; border: none; padding: 8px 15px;">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="button" class="btn btn-light btn-sm me-2" onclick="hideEditForm({{ $comment->id }})"
                                                style="border-radius: 20px;">Hủy</button>
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                style="border-radius: 20px;">Lưu</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="alert alert-info">
                                Chưa có bình luận nào về khóa học này. Hãy là người đầu tiên để lại bình luận!
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nextBtn = document.getElementById('nextLessonBtn');
            const countdownElement = document.getElementById('countdown');
            let timeLeft = 15;

            const countdown = setInterval(function() {
                timeLeft--;
                countdownElement.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    nextBtn.disabled = false;
                    nextBtn.innerHTML = nextBtn.innerHTML.replace(/ \(\d+s\)/, '');
                }
            }, 1000);

            // Xử lý input comment
            const input = document.querySelector('.comment-input');
            const button = document.getElementById('submitButton');

            if (input && button) {
                input.addEventListener('focus', function() {
                    button.style.display = 'inline-block';
                });

                input.addEventListener('input', function() {
                    if (input.value.trim() !== "") {
                        button.style.display = 'inline-block';
                    } else {
                        button.style.display = 'none';
                    }
                });
            }
        });

        // Biến lưu trạng thái hiển thị của comment section
        let commentsVisible = false;

        function toggleComments() {
            const commentSection = document.getElementById('commentSection');

            // Đảo ngược trạng thái hiển thị
            commentsVisible = !commentsVisible;

            // Cập nhật hiển thị dựa trên trạng thái
            if (commentsVisible) {
                commentSection.classList.add('show');
            } else {
                commentSection.classList.remove('show');
            }
        }

        function showEditForm(commentId) {
            try {
                // Ẩn nội dung bình luận
                document.querySelector(`#comment-${commentId} .comment-content`).style.display = 'none';
                // Ẩn các actions
                document.querySelector(`#comment-${commentId} .actions`).style.display = 'none';
                // Hiển thị form chỉnh sửa
                document.querySelector(`#editForm-${commentId}`).style.display = 'block';
            } catch (e) {
                console.error("Lỗi khi hiển thị form chỉnh sửa:", e);
            }
        }

        function hideEditForm(commentId) {
            try {
                // Hiển thị lại nội dung bình luận
                document.querySelector(`#comment-${commentId} .comment-content`).style.display = 'block';
                // Hiển thị lại actions
                document.querySelector(`#comment-${commentId} .actions`).style.display = 'block';
                // Ẩn form chỉnh sửa
                document.querySelector(`#editForm-${commentId}`).style.display = 'none';
            } catch (e) {
                console.error("Lỗi khi ẩn form chỉnh sửa:", e);
            }
        }

        function showEditReplyForm(replyId) {
            try {
                // Ẩn nội dung phản hồi
                document.querySelector(`#comment-${replyId} .comment-content`).style.display = 'none';
                // Ẩn các actions
                document.querySelector(`#comment-${replyId} .actions`).style.display = 'none';
                // Hiển thị form chỉnh sửa
                document.querySelector(`#editReplyForm-${replyId}`).style.display = 'block';
            } catch (e) {
                console.error("Lỗi khi hiển thị form chỉnh sửa phản hồi:", e);
            }
        }

        function hideEditReplyForm(replyId) {
            try {
                // Hiển thị lại nội dung phản hồi
                document.querySelector(`#comment-${replyId} .comment-content`).style.display = 'block';
                // Hiển thị lại actions
                document.querySelector(`#comment-${replyId} .actions`).style.display = 'block';
                // Ẩn form chỉnh sửa
                document.querySelector(`#editReplyForm-${replyId}`).style.display = 'none';
            } catch (e) {
                console.error("Lỗi khi ẩn form chỉnh sửa phản hồi:", e);
            }
        }

        function showNestedReplyForm(replyId) {
            const nestedReplyForm = document.getElementById(`nestedReplyForm-${replyId}`);
            if (nestedReplyForm) {
                nestedReplyForm.style.display = 'block';
                const input = nestedReplyForm.querySelector('.nested-reply-input');
                // Lấy username từ data-username
                const username = input.getAttribute('data-username');
                // Tự động chèn @username nếu ô input trống
                if (!input.value) {
                    input.value = `@${username} `;
                }
                // Focus vào ô input
                input.focus();
            }
        }

        function hideNestedReplyForm(replyId) {
            const nestedReplyForm = document.getElementById(`nestedReplyForm-${replyId}`);
            if (nestedReplyForm) {
                nestedReplyForm.style.display = 'none';
            }
        }

        function likeComment(commentId) {
            $.ajax({
                url: `/comments/${commentId}/like`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    const likeBtn = $(`.like-btn[data-comment-id="${commentId}"] i`);
                    const likesCount = $(`#likes-count-${commentId}`);

                    if (data.status === 'liked') {
                        likeBtn.removeClass('fa-regular').addClass('fa-solid');
                    } else {
                        likeBtn.removeClass('fa-solid').addClass('fa-regular');
                    }

                    likesCount.text(data.likes);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.log('Response:', xhr.responseText);

                    if (xhr.status === 401) {
                        alert('Vui lòng đăng nhập để thích bình luận');
                    } else {
                        alert('Có lỗi xảy ra khi thực hiện thao tác like');
                    }
                }
            });
        }

        function showReplyForm(commentId) {
            const replyForm = document.getElementById(`replyForm-${commentId}`);
            if (replyForm) {
                replyForm.style.display = 'block';
                const input = replyForm.querySelector('.reply-input');
                // Lấy username từ data-username
                const username = input.getAttribute('data-username');
                // Tự động chèn @username nếu ô input trống
                if (!input.value) {
                    input.value = `@${username} `;
                }
                // Focus vào ô input
                input.focus();
            }
        }

        function hideReplyForm(commentId) {
            const replyForm = document.getElementById(`replyForm-${commentId}`);
            if (replyForm) {
                replyForm.style.display = 'none';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#reviewForm .star-rating .far.fa-star');
            const ratingInput = document.getElementById('ratingValue');

            if (stars.length > 0) {
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = this.getAttribute('data-rating');
                        ratingInput.value = rating;

                        stars.forEach((s, index) => {
                            if (index < rating) {
                                s.classList.remove('far');
                                s.classList.add('fas');
                            } else {
                                s.classList.remove('fas');
                                s.classList.add('far');
                            }
                        });
                    });

                    star.addEventListener('mouseover', function() {
                        const rating = this.getAttribute('data-rating');

                        stars.forEach((s, index) => {
                            if (index < rating) {
                                s.classList.remove('far');
                                s.classList.add('fas');
                            } else {
                                s.classList.remove('fas');
                                s.classList.add('far');
                            }
                        });
                    });

                    star.addEventListener('mouseout', function() {
                        const currentRating = ratingInput.value;

                        stars.forEach((s, index) => {
                            if (index < currentRating) {
                                s.classList.remove('far');
                                s.classList.add('fas');
                            } else {
                                s.classList.remove('fas');
                                s.classList.add('far');
                            }
                        });
                    });
                });

                stars.forEach((star, index) => {
                    if (index < 5) {
                        star.classList.remove('far');
                        star.classList.add('fas');
                    }
                });
            }

            document.querySelectorAll('.toggle-reply').forEach(button => {
                button.addEventListener('click', function() {
                    const reviewId = this.getAttribute('data-review-id');
                    const replyForm = document.getElementById(`reply-form-${reviewId}`);
                    replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
                });
            });

            document.querySelectorAll('.cancel-reply').forEach(button => {
                button.addEventListener('click', function() {
                    const reviewId = this.getAttribute('data-review-id');
                    document.getElementById(`reply-form-${reviewId}`).style.display = 'none';
                });
            });
        });
    </script>
</body>

</html>