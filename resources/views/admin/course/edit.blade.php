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
                <input type="text" id="title" name="title" class="form-control"
                    value="{{ old('title', $course->title) }}" placeholder="Nhập tiêu đề" required>
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $course->description) }}</textarea>
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
                <label>Ảnh hiện tại:</label><br>
                <img id="thumbnail-preview" src="{{ asset('storage/' . $course->thumbnail) }}" alt="Image Preview"
                    class="img-thumbnail" style="max-height: 100px; {{ $course->thumbnail ? '' : 'display: none;' }}">
            </div>

            <div class="form-check mt-2">
                <input type="checkbox" id="is_free" class="form-check-input" onchange="togglePriceField()"
                    {{ old('price', $course->price) == 0 ? 'checked' : '' }}>
                <label for="is_free" class="form-check-label">Miễn phí</label>
            </div>

            <div class="form-group mt-3">
                <label for="price">Giá</label>
                <input type="number" id="price" name="price" class="form-control"
                    value="{{ old('price', $course->price) }}" placeholder="Nhập giá">
                @error('price')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="categories_id">Danh mục</label>
                <select name="categories_id" id="categories_id" class="form-control" required>
                    <option value="">Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id == $course->categories_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('categories_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.course.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event, inputId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(inputId + '-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function togglePriceField() {
            const isFree = document.getElementById('is_free').checked;
            const priceInput = document.getElementById('price');

            if (isFree) {
                priceInput.value = 0;
                priceInput.readOnly = true;
            } else {
                if (priceInput.value == 0) priceInput.value = '';
                priceInput.readOnly = false;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            togglePriceField();
        });
    </script>
@endsection
