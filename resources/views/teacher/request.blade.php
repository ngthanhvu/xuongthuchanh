@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Đăng ký làm giảng viên</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('request.teacher') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="qualifications">Trình độ chuyên môn</label>
                            <textarea class="form-control" id="qualifications" name="qualifications" rows="3" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="message">Lý do muốn trở thành giảng viên</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection