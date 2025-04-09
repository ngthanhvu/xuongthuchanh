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
                <!-- Phần bình luận - Thêm vào sau phần nội dung khóa học -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        {{-- <h5 class="card-title">Bình luận ({{ $comments->count() }})</h5> --}}
                        
                        @if(Auth::check() && isset($isEnrolled) && $isEnrolled)
                            <form action="{{ route('comments.store', $course->id) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                            name="content" rows="3" 
                                            placeholder="Viết bình luận của bạn..."></textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Đăng bình luận</button>
                            </form>
                        @elseif(Auth::check())
                            <div class="alert alert-info">
                                Bạn cần đăng ký khóa học để có thể bình luận.
                            </div>
                        @else
                            <div class="alert alert-info">
                                Vui lòng <a href="{{ route('login') }}">đăng nhập</a> và đăng ký khóa học để bình luận.
                            </div>
                        @endif

                        <!-- Danh sách bình luận -->
                        <div class="comments-list mt-4">
                            @forelse($comments as $comment)
                                <div class="comment-item mb-3 pb-3 border-bottom" id="comment-{{ $comment->id }}">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $comment->user->avatar ? asset($comment->user->avatar) : asset('images/default-avatar.png') }}" 
                                                alt="{{ $comment->user->username }}" 
                                                class="rounded-circle" width="50" height="50">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0">{{ $comment->user->username }}</h6>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p>{{ $comment->content }}</p>
                                            
                                            @if(Auth::check() && $isEnrolled)
                                                <div class="comment-actions">
                                                    <button class="btn btn-sm btn-link reply-btn" 
                                                            data-parent-id="{{ $comment->id }}">Trả lời</button>
                                                    
                                                    @if(Auth::id() == $comment->user_id)
                                                        <button class="btn btn-sm btn-link edit-btn" 
                                                                data-comment-id="{{ $comment->id }}" 
                                                                data-comment-content="{{ $comment->content }}">Sửa</button>
                                                        
                                                        <form class="d-inline" 
                                                            action="{{ route('comments.destroy', $comment->id) }}" 
                                                            method="POST" 
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-link text-danger">Xóa</button>
                                                        </form>
                                                    @endif
                                                </div>
                                                
                                                <!-- Form trả lời (ẩn ban đầu) -->
                                                <div class="reply-form mt-2" style="display: none;">
                                                    <form action="{{ route('comments.store', $course->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="content" rows="2" 
                                                                    placeholder="Viết trả lời của bạn..."></textarea>
                                                        </div>
                                                        <div class="mt-2">
                                                            <button type="submit" class="btn btn-sm btn-primary">Gửi trả lời</button>
                                                            <button type="button" class="btn btn-sm btn-secondary cancel-reply">Hủy</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                
                                                <!-- Form chỉnh sửa (ẩn ban đầu) -->
                                                <div class="edit-form mt-2" style="display: none;">
                                                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <textarea class="form-control edit-content" name="content" rows="2"></textarea>
                                                        </div>
                                                        <div class="mt-2">
                                                            <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                                                            <button type="button" class="btn btn-sm btn-secondary cancel-edit">Hủy</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                            
                                            <!-- Phần trả lời -->
                                            @if($comment->replies->count() > 0)
                                                <div class="replies mt-3">
                                                    @foreach($comment->replies as $reply)
                                                        <div class="reply-item mt-2 ps-3 border-start" id="comment-{{ $reply->id }}">
                                                            <div class="d-flex">
                                                                <div class="flex-shrink-0">
                                                                    <img src="{{ $reply->user->avatar ? asset($reply->user->avatar) : asset('images/default-avatar.png') }}" 
                                                                        alt="{{ $reply->user->username }}" 
                                                                        class="rounded-circle" width="40" height="40">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <div class="d-flex justify-content-between">
                                                                        <h6 class="mb-0">{{ $reply->user->username }}</h6>
                                                                        <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                                    </div>
                                                                    <p>{{ $reply->content }}</p>
                                                                    
                                                                    @if(Auth::check() && Auth::id() == $reply->user_id)
                                                                        <div class="reply-actions">
                                                                            <button class="btn btn-sm btn-link edit-btn" 
                                                                                    data-comment-id="{{ $reply->id }}" 
                                                                                    data-comment-content="{{ $reply->content }}">Sửa</button>
                                                                            
                                                                            <form class="d-inline" 
                                                                                action="{{ route('comments.destroy', $reply->id) }}" 
                                                                                method="POST" 
                                                                                onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-link text-danger">Xóa</button>
                                                                            </form>
                                                                        </div>
                                                                        
                                                                        <!-- Form chỉnh sửa trả lời (ẩn ban đầu) -->
                                                                        <div class="edit-form mt-2" style="display: none;">
                                                                            <form action="{{ route('comments.update', $reply->id) }}" method="POST">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <div class="form-group">
                                                                                    <textarea class="form-control edit-content" name="content" rows="2"></textarea>
                                                                                </div>
                                                                                <div class="mt-2">
                                                                                    <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                                                                                    <button type="button" class="btn btn-sm btn-secondary cancel-edit">Hủy</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted">
                                    Chưa có bình luận nào cho khóa học này.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Section -->
            <div class="col-md-4">
                <div class="card iframe-card mb-4">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text">Xem giới thiệu khóa học</p>
                    <iframe width="380" height="200" src="https://www.youtube.com/embed/1nA33oSe0Qc?autoplay=1&mute=1">
                    </iframe>
                    
                </div>

                <div class="card card-custom">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $course->price == 0 ? 'Miễn phí' : number_format($course->price, 2) }} đ
                        </h5>
                        <p class="text-muted">Đăng ký học</p>
                        <form id="paymentForm" method="GET" action="{{ route('loading', ['course_id' => $course->id]) }}">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý hiển thị form trả lời
            document.querySelectorAll('.reply-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const parentId = this.getAttribute('data-parent-id');
                    const replyForm = this.closest('.comment-item').querySelector('.reply-form');
                    replyForm.style.display = 'block';
                });
            });
    
            // Xử lý hủy trả lời
            document.querySelectorAll('.cancel-reply').forEach(function(button) {
                button.addEventListener('click', function() {
                    const replyForm = this.closest('.reply-form');
                    replyForm.style.display = 'none';
                });
            });
    
            // Xử lý hiển thị form chỉnh sửa
            document.querySelectorAll('.edit-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const commentContent = this.getAttribute('data-comment-content');
                    const editForm = this.closest('.comment-item, .reply-item').querySelector('.edit-form');
                    
                    // Đặt nội dung hiện tại vào ô textarea
                    editForm.querySelector('.edit-content').value = commentContent;
                    
                    // Hiển thị form chỉnh sửa
                    editForm.style.display = 'block';
                });
            });
    
            // Xử lý hủy chỉnh sửa
            document.querySelectorAll('.cancel-edit').forEach(function(button) {
                button.addEventListener('click', function() {
                    const editForm = this.closest('.edit-form');
                    editForm.style.display = 'none';
                });
            });
        });
    </script>

    <style>
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .iframe-card {
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
