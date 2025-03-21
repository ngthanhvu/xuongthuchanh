@extends('layouts.admin') 

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.course.create') }}" class="btn btn-primary mb-3">Thêm mới khóa học</a> 

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Tiêu đề</th>
                <th>Thumbnail</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Giảm giá</th>
                <th>Danh mục</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course as $courses)
                <tr>
                    <td>{{ $loop->iteration }}</td> 
                    <td>{{ $courses->title }}</td>
                    <td><img src="{{ asset('storage/' . $courses->thumbnail) }}" alt="Thumbnail" width="80"></td> 
                    <td>{{ Str::limit($courses->description, 50) }}</td>
                    <td>{{ number_format($courses->price, 2) }}</td>
                    <td>{{ number_format($courses->discount, 2) }}%</td>
                    <td>{{ $courses->category->name ?? 'No Category' }}</td> 
                    <td>
                        <a href="{{ route('admin.course.edit', $courses->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a> |
                        <form action="{{ route('admin.course.delete', $courses->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')"><i class="bi bi-trash"></i></button>
                        </form> 
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
