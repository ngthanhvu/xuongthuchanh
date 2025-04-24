@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chỉnh sửa bài viết</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nội dung</label>
            <textarea id="editor" name="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Khóa học</label>
            <select name="course_id" class="form-control" required>
                <option value="">Chọn khóa học</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $post->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật bài viết</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>

{{-- Thêm CKEditor --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
@endsection
