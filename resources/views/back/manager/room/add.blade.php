@extends('back.template.master')
@section('title', 'Quản lý phòng')
@section('roomlist', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Thêm phòng</h2>
        @if(Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
            {!!Session::get('flash_message')!!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{url('admin/room/add')}}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Số phòng <strong style="color: red">*</strong></label>
                        <input type="text" class="form-control" name="idroom" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label for="level" class="form-label">Loại phòng <strong style="color: red">*</strong></label>
                        <select class="form-control" name="type">
                            @if (isset($RoomType) && count($RoomType) > 0)
                                @foreach($RoomType as $k => $v)
                                    <option value="{{$v->id}}">
                                        {{$v->name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="images" class="form-label">Upload ảnh</label>
                        <input type="file" name="images[]" id="images" class="form-control-file" multiple accept="image/*">
                    </div>

                    <div id="image-preview" class="mt-3"></div>

                    <a href="{{url('admin/room/list')}}" class="btn btn-danger mt-2"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary mt-2">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('images').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('image-preview');

        previewContainer.innerHTML = '<h4>Ảnh xem trước:</h4>'; // Reset the preview section
        const files = event.target.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.width = '150px'; // Set a fixed width for preview images
                    img.style.marginRight = '10px'; // Add some spacing between images
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    </script>
@stop
