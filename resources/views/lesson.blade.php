<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $lessons->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    </style>
</head>
<body>
    <div class="header d-flex justify-content-between align-items-center">
        <a href="{{ route('home') }}" class="text-decoration-none text-white"><i class="fa-solid fa-arrow-left"></i> Trang chủ</a>
        <div>{{ $lessons->title }}</div>
        <div>{{ $sections->sum(fn($section) => $section->lessons->count()) }} bài học</div> 
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 p-0">
                <div class="iframe-section">
                    @if ($lessons->file_url)
                        <iframe width="100%" height="100%"
                            src="{{ preg_replace('/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', 'https://www.youtube.com/embed/$1', $lessons->file_url) }}?controls=0&rel=0&showinfo=0&modestbranding=1&iv_load_policy=3&fs=1"
                            title="{{ $lessons->title }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    @else
                        <img src="{{ asset('path-to-iframe-placeholder.jpg') }}" alt="Video Placeholder">
                    @endif
                </div>
                <div class="footer d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $lessons->title }}</h5>
                        <p>Cập nhật {{ $lessons->updated_at->format('F Y') }}</p>
                        <p class="mt-3">{{ $lessons->content }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    @if ($prevLesson)
                        <a href="{{ route('lesson', $prevLesson->id) }}" class="btn btn-light me-2">BÀI TRƯỚC</a>
                    @else
                        <button class="btn btn-light me-2" disabled>BÀI TRƯỚC</button>
                    @endif
                    @if ($nextLesson)
                        <a href="{{ route('lesson', $nextLesson->id) }}" class="btn btn-primary">BÀI TIẾP THEO</a>
                    @else
                        <button class="btn btn-primary" disabled>BÀI TIẾP THEO</button>
                    @endif
                </div>
            </div>

            <div class="col-md-4 p-0">
                <div class="lesson-list">
                    <h6 class="p-3 border-bottom">NỘI DUNG KHÓA HỌC</h6>
                    <div class="accordion" id="lessonAccordion">
                        @foreach ($sections as $index => $section)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#module{{ $section->id }}"
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
                                            @foreach ($section->lessons as $lessonsItem)
                                                <a href="{{ route('lesson', $lessonsItem->id) }}"
                                                    class="lesson-item {{ $lessonsItem->id == $lessons->id ? 'active' : '' }}">
                                                    {{ $lessonsItem->title }}
                                                    <span class="float-end">11:35</span> <!-- Có thể thay bằng thời lượng thực tế -->
                                                </a>
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
</body>
</html>