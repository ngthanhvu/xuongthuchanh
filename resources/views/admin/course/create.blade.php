<!-- resources/views/admin/course/create.blade.php -->

@extends('layouts.admin') <!-- Extend your main layout here, adjust it as needed -->

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    
    <!-- Check if there's a success message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form to create a new course -->
    <form action="{{ route('admin.course.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title')<div class="alert alert-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
            @error('description')<div class="alert alert-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="thumbnail">Thumbnail</label>
            <input type="file" id="thumbnail" name="thumbnail" class="form-control-file" required>
            @error('thumbnail')<div class="alert alert-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
            @error('price')<div class="alert alert-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" id="discount" name="discount" class="form-control" value="{{ old('discount') }}" required>
            @error('discount')<div class="alert alert-danger">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<div class="alert alert-danger">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Course</button>
    </form>
</div>
@endsection
