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

                    <form method="POST" action="{{ route('request.teacher') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="qualifications">Trình độ chuyên môn</label>
                            <textarea class="form-control" id="qualifications" name="qualifications" rows="3" required placeholder="Nhập trình độ chuyên môn"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="message">Lý do muốn trở thành giảng viên</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Nhập lý do muốn trở thành giảng viên"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="certificates">Ảnh bằng cấp/chứng chỉ</label>
                            <input type="file" class="form-control" id="certificates" name="certificates[]" multiple accept="image/*">
                            <small class="text-muted">Chỉ chấp nhận file ảnh (jpg, png, jpeg)</small>
                        </div>

                        <div id="preview-container" class="mb-3 d-flex flex-wrap gap-2"></div>

                        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('certificates').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = '';

        const files = e.target.files;
        const maxFiles = 5;

        if (files.length > maxFiles) {
            alert(`Bạn chỉ được upload tối đa ${maxFiles} ảnh`);
            e.target.value = '';
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!file.type.match('image.*')) continue;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '150px';
                img.style.maxHeight = '150px';
                img.className = 'img-thumbnail';
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection