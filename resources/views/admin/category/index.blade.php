@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Danh sách danh mục </h2>
    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Thêm danh mục</a>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên Danh Mục</th>
                <th>Slug</th>
                <th>Hình Ảnh</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>
                    @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" width="80">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.category.delete', $category->id) }}" method="POST" onsubmit="return('Bạn có chức muốn xóa danh mục?');" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
