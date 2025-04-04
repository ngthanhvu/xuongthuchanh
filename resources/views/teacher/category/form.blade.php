@csrf
<div class="mb-3">
    <label>Tên Danh Mục</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $categories->name ?? '') }}" placeholder="Nhập tên danh mục">
    @error('name')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="mb-3">
    <label>Mô Tả</label>
    <textarea name="description" class="form-control" placeholder="Nhập mô tả">{{ old('description', $categories->description ?? '') }}</textarea>
    @error('description')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>


<button class="btn btn-primary">Lưu Danh Mục</button>
<a href="{{ route('teacher.category.index') }}" class="btn btn-secondary">Thoát</a>
