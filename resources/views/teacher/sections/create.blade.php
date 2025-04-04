@extends('layouts.teacher')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    

    <form action="{{ route('teacher.sections.store') }}" method="POST">
        @csrf
        
        <div class="form-group mb-3">
            <label for="course_id">Khóa học</label>
            <select name="course_id" id="course_id" class="form-control" placeholder="Chọn khóa học">
                <option value="">Chọn khóa học</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
                @error('course_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="title">Tiêu đề Section</label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   class="form-control" 
                   value="{{ old('title') }}"
                   placeholder="Nhập tiêu đề">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Thêm Section</button>
            <a href="{{ route('teacher.sections.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>
@endsection