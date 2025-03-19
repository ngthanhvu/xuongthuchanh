@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Thêm Danh Mục</h2>

    <form action="{{ route('admin.category.update', $categories->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.category.form')
    </form>
</div>
@endsection
