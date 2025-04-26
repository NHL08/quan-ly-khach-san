@extends('back.template.master')
@section('title', 'Cài đặt thành viên tham gia')
@section('student', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Cài đặt thành viên tham gia ({{ $countStudent }} thành viên)</h2>
        <a class="btn btn-primary m-2 mb-3" href="{{url('admin/settings/student/add')}}" title="Thêm">Thêm</a>
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
                <form action="{{ url('admin/settings/student') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    @foreach ($students as $k => $v)
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="manager">Thành viên thứ {{ $k + 1 }} <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{ $v->fullname }}" name="namestudent{{ $k + 1 }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="manager">Mã sinh viên thành viên thứ {{ $k + 1 }} <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{ $v->masv }}" name="masvstudent{{ $k + 1 }}" class="form-control input-masv" maxlength="10">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="manager">Chức vụ thành viên thứ {{ $k + 1 }} <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{ $v->role }}" name="role{{ $k + 1 }}" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="manager">Ảnh thành viên thứ {{ $k + 1 }} <strong style="color: red">*</strong></label>
                            <input type="file" name="imagestudent{{ $k + 1 }}" id="images_student_{{ $k + 1 }}" class="form-control-file" accept="image/*">
                            <div id="existing-images-student-{{ $k + 1 }}" class="mb-3 mt-3">
                                <h4>Ảnh hiện có:</h4>
                                @if(isset($v->avatar) && !empty($v->avatar))
                                    <img src="{{ url('student_image/' . $v->avatar) }}" class="img-thumbnail" style="width: 150px; margin-right: 10px; background: rgb(210, 210, 210)" alt="Ảnh hiện có">
                                @else
                                    <p>Không có ảnh nào.</p>
                                @endif
                            </div>

                            <div id="image-preview-student-{{ $k + 1 }}" class="mt-3"></div>
                        </div>
                        <div class="form-group col-md-1">
                            @if (isset($v->status) && $v->status == 1)
                            <a href="{{ url('admin/settings/student/off/'. $v->id) }}" class="btn btn-danger mt-2">Tắt</a>
                            @else
                            <a href="{{ url('admin/settings/student/on/'. $v->id) }}" class="btn btn-primary mt-2">Bật</a>
                            @endif
                        </div>
                    </div>
                    <script>
                        document.getElementById('images_student_{{ $k + 1 }}').addEventListener('change', function(event) {
                            const previewContainer = document.getElementById('image-preview-student-{{ $k + 1 }}');
                            const existingImagesContainer = document.getElementById('existing-images-student-{{ $k + 1 }}');

                            if (event.target.files.length > 0) {
                                existingImagesContainer.style.display = 'none';
                            } else {
                                existingImagesContainer.style.display = 'block';
                            }

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
                    @endforeach

                    <a href="{{ url('admin/settings/student') }}" class="btn btn-danger mt-2"><i class="fa-solid fa-arrows-rotate"></i> Tải lại</a>
                    <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
