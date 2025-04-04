@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>Thêm Danh Mục</h2>

    <form action="{{ route('teacher.category.store') }}" method="POST" enctype="multipart/form-data">
        @include('teacher.category.form')
    </form>
</div>
@endsection
