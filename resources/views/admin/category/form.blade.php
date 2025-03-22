@csrf
<div class="mb-3">
    <label>Tên Danh Mục</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $categories->name ?? '') }}">
    @error('name')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="mb-3">
    <label>Mô Tả</label>
    <textarea name="description" class="form-control">{{ old('description', $categories->description ?? '') }}</textarea>
    @error('description')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="mb-3">
    <label>Hình Ảnh</label>
    <input type="file" name="image" class="form-control">
    @if (isset($categories) && $categories->image)
        <img src="{{ asset('storage/' . $categories->image) }}" width="100" class="mt-2">
    @endif
    @error('image')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<button class="btn btn-success">Lưu</button>
<a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Thoát</a>
