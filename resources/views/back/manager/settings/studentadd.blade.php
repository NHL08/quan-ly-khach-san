@extends('back.template.master')
@section('title', 'Thêm thành viên tham gia')
@section('student', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Thêm thành viên tham gia</h2>
        @if(Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
            {!! Session::get('flash_message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ url('admin/settings/student/add') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="manager">Tên thành viên <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" name="namestudent" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="manager">Mã sinh viên thành viên <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" name="masvstudent" class="form-control input-masv" maxlength="10">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="manager">Chức vụ thành viên <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" name="role" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="manager">Ảnh thành viên <strong style="color: red">*</strong></label>
                            <input type="file" name="imagestudent" id="images_student" class="form-control-file" accept="image/*">

                            <div id="image-preview-student" class="mt-3"></div>
                        </div>
                    </div>
                    <script>
                        document.getElementById('images_student').addEventListener('change', function(event) {
                            const previewContainer = document.getElementById('image-preview-student');

                            previewContainer.innerHTML = '<h4>Ảnh xem trước:</h4>';
                            const files = event.target.files;

                            if (files.length > 0) {
                                Array.from(files).forEach(file => {
                                    if (file.type.startsWith('image/')) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const img = document.createElement('img');
                                            img.src = e.target.result;
                                            img.classList.add('img-thumbnail');
                                            img.style.width = '150px';
                                            img.style.marginRight = '10px';
                                            previewContainer.appendChild(img);
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                });
                            }
                        });
                        </script>

                    <a href="{{ url('admin/settings/student') }}" class="btn btn-danger mt-2"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary mt-2">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
