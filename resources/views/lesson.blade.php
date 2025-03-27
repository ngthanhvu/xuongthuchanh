<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$lesson->title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .video-section {
            background-color: #000;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
        }

        .video-section video,
        .video-section img {
            max-width: 100%;
            height: auto;
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
        <a href="/" class="text-decoration-none text-white"><i class="fa-solid fa-arrow-left"></i> Trang chủ</a>
        <div>{{ $lesson->title }}</div>
        <div>0/{{ $sections->sum(fn($section) => $section->lessons->count()) }} bài học</div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 p-0">
                <div class="video-section">
                    @if ($lesson->file_url)
                    <video controls width="100%" height="100%">
                        <source src="{{ asset($lesson->file_url) }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ thẻ video.
                    </video>
                    @else
                    <img src="{{ asset('path-to-video-placeholder.jpg') }}" alt="Video Placeholder">
                    @endif
                </div>
                <div class="footer d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $lesson->title }}</h5>
                        <p>Cập nhật tháng 11 năm 2022</p>
                    </div>
                    <div>
                        <button class="btn btn-light me-2">BÀI TRƯỚC</button>
                        <button class="btn btn-primary">BÀI TIẾP THEO</button>
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
                                <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#module{{ $section->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                    aria-controls="module{{ $section->id }}">
                                    {{ $index + 1 }}. {{ $section->title }}
                                </button>
                            </h2>
                            <div id="module{{ $section->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                data-bs-parent="#lessonAccordion">
                                <div class="accordion-body">
                                    @if ($section->lessons->isNotEmpty())
                                    @foreach ($section->lessons as $lessonItem)
                                    <div class="lesson-item {{ $lessonItem->id == $lesson->id ? 'active' : '' }}">
                                        {{ $lessonItem->title }}
                                        <span class="float-end">11:35</span>
                                    </div>
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