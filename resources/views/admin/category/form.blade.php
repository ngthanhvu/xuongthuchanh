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


<button class="btn btn-success">Lưu</button>
<a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Thoát</a>
