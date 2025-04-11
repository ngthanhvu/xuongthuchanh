@extends('layouts.master')

@section('content')
<div class="container mt-3">
    <div class="row">
        
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

            <div class="card card-custom mb-4">
                <div class="card-body">
                    <h5 class="card-title text-center">Đánh giá khóa học</h5>
                    @php
                    
                    $reviews = \App\Models\Review::with('user')
                    ->where('course_id', $course->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                    $averageRating = $reviews->avg('rating');
                    $ratingCounts = $reviews->groupBy('rating')->map->count();
                    @endphp

                    <div class="col-md-12
                        d-flex justify-content-center align-items-center mb-4">
                        <div class="col-md-3 text-center">
                            <h2 class="text-primary">{{ number_format($averageRating, 1) }}</h2>
                            <div class="star-rating mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                            </div>
                            <p>{{ $reviews->count() }} đánh giá</p>
                        </div>
                        <!-- <div class="col-md-9">
                            @for($i = 5; $i >= 1; $i--)
                            <div class="row align-items-center mb-2">
                                <div class="col-2 text-end">
                                    <span>{{ $i }} <i class="fas fa-star text-warning"></i></span>
                                </div>
                                <div class="col-7">
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                            style="width: {{ $reviews->count() > 0 ? ($ratingCounts[$i] ?? 0) / $reviews->count() * 100 : 0 }}%"
                                            aria-valuenow="{{ $ratingCounts[$i] ?? 0 }}"
                                            aria-valuemin="0"
                                            aria-valuemax="{{ $reviews->count() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <span>{{ $ratingCounts[$i] ?? 0 }}</span>
                                </div>
                            </div>
                            @endfor
                        </div> -->
                    </div>

                    @auth
                    @if(!$reviews->where('user_id', auth()->id())->first())
                    <div class="review-form mb-4">
                        <h6>Đánh giá của bạn</h6>
                        <form method="POST" action="{{ route('reviews.store') }}" id="reviewForm">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

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
                                    @if(auth()->user()->role == 'admin'|| auth()->user()->role == 'teacher' || auth()->user()->role == 'owner' ||  auth()->user()->id === $review->user_id)
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
                            <div style="display: none;">
                                User Role: {{ auth()->user()->role }}<br>
                                Is Admin: {{ auth()->user()->role === 'admin' ? 'Yes' : 'No' }}<br>
                                Review ID: {{ $review->id }}<br>
                                Has Reply: {{ $review->admin_reply ? 'Yes' : 'No' }}
                            </div>
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
                            {{ $course->duration ?? '03 giờ 26 phút' }}
                        </li>
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

    .iframe-card {
        background: linear-gradient(to right, #ff4b1f, #ff9068);
        color: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }

    .admin-reply {
        border-left: 3px solid #007bff;
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
    }

    .progress {
        background-color: #e9ecef;
    }
    
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        
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
    document.addEventListener('DOMContentLoaded', function() {
       
        const stars = document.querySelectorAll('.star-rating .far.fa-star');
        const ratingInput = document.getElementById('ratingValue');

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
    });
</script>

@endsection