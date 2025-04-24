@extends('layouts.teacher')

@section('content')
<div class="container">
    <h1>Chỉnh sửa Section</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teacher.sections.update', $section->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-3">
            <label for="course_id">Khóa học</label>
            <select name="course_id" id="course_id" class="form-control" required>
                <option value="">Chọn khóa học</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" 
                            {{ $section->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="title">Tiêu đề Section</label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   class="form-control" 
                   value="{{ old('title', $section->title) }}"
                   required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('teacher.sections.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>
@endsection