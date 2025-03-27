@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Section -->
        <div class="form-group mb-3">
            <label for="section_id">Section</label>
            <select name="section_id" id="section_id" class="form-control" required>
                <option value="">Chọn section</option>
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}" 
                            {{ old('section_id', $lesson->section_id) == $section->id ? 'selected' : '' }}>
                        {{ $section->title }}
                    </option>
                @endforeach
            </select>
            @error('section_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Title -->
        <div class="form-group mb-3">
            <label for="title">Tiêu đề bài học</label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   class="form-control" 
                   value="{{ old('title', $lesson->title) }}"
                   required>
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Type -->
        <div class="form-group mb-3">
            <label for="type">Loại bài học</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Chọn loại</option>
                <option value="video" {{ old('type', $lesson->type) == 'video' ? 'selected' : '' }}>Video</option>
                <option value="text" {{ old('type', $lesson->type) == 'text' ? 'selected' : '' }}>Văn bản</option>
                <option value="quiz" {{ old('type', $lesson->type) == 'quiz' ? 'selected' : '' }}>Bài kiểm tra</option>
                <option value="file" {{ old('type', $lesson->type) == 'file' ? 'selected' : '' }}>Tệp</option>
            </select>
            @error('type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Content -->
        <div class="form-group mb-3">
            <label for="content">Nội dung</label>
            <textarea name="content" 
                      id="content" 
                      class="form-control" 
                      rows="5">{{ old('content', $lesson->content) }}</textarea>
            @error('content')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- YouTube Link -->
        <div class="form-group mb-3">
            <label for="file_url">Link Video YouTube (nếu có)</label>
            <input type="url" 
                   name="file_url" 
                   id="file_url" 
                   class="form-control" 
                   value="{{ old('file_url', $lesson->file_url) }}"
                   placeholder="https://www.youtube.com/watch?v=...">
            <small class="form-text text-muted">Nhập link YouTube nếu loại là Video.</small>
            @error('file_url')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Cập nhật bài học</button>
            <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>
@endsection