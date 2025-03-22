@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Chỉnh sửa khóa học</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mt-3">
                <label for="title">Tiêu đề</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $course->title) }}"
                    placeholder="Nhập tiêu đề">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control"
                    onchange="previewImage(event, 'thumbnail')">
                @error('thumbnail')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <img id="thumbnail-preview" src="{{ asset('uploads/' . $course->thumbnail) }}" alt="Image Preview"
                    class="img-fluid" style="max-height: 100px; {{ $course->thumbnail ? '' : 'display: none;' }}">
            </div>

            <div class="form-group mt-3">
                <label for="price">Giá</label>
                <input type="number" id="price" name="price" class="form-control"
                    value="{{ old('price', $course->price) }}">
                @error('price')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="categories_id">Danh mục</label>
                <select name="categories_id" id="categories_id" class="form-control">
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $course->categories_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('categories_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                <a href="{{ route('admin.course.index') }}" class="btn btn-secondary w-100 mt-2">Hủy</a>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event, inputId) {
            var input = document.getElementById(inputId);
            var preview = document.getElementById(inputId + '-preview');

            preview.style.display = 'block';

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
