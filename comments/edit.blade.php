@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Chỉnh sửa bình luận</h4>
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <textarea name="content" class="form-control" rows="4">{{ old('content', $comment->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
    </form>
</div>
@endsection
