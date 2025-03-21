@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>{{ $title }}</h2>
        
        <form action="{{ route('admin.course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            <!-- Title -->
            <div class="form-group mt-3">
                <label for="title">Tiêu đề khóa học</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                @error('title')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>

            <!-- Description -->
            <div class="form-group mt-3">
                <label for="description">Mô tả khóa học</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description', $course->description) }}</textarea>
                @error('description')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>

            <!-- Thumbnail -->
            <div class="form-group mt-3">
                <label for="thumbnail">Hình ảnh thumbnail</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                @if($course->thumbnail)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="Course Thumbnail" width="100">
                    </div>
                @endif
                @error('thumbnail')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>

            <!-- Price -->
            <div class="form-group mt-3">
                <label for="price">Giá khóa học</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $course->price) }}" required>
                @error('price')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>

            <!-- Discount -->
            <div class="form-group mt-3">
                <label for="discount">Giảm giá</label>
                <input type="number" class="form-control" id="discount" name="discount" value="{{ old('discount', $course->discount) }}" required>
                @error('discount')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>

            <!-- Category -->
            <div class="form-group mt-3">
                <label for="category_id">Danh mục</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $course->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                <a href="{{ route('admin.course.index') }}" class="btn btn-secondary w-100 mt-2">Hủy</a>
            </div>
        </form>
    </div>
@endsection
