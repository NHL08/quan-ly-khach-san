@extends('back.template.master')
@section('title', 'Cài đặt website')
@section('settings', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Cài đặt website</h2>
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
                <form action="{{ url('admin/settings') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="namehotel">Tên khách sạn <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{$setting->namehotel}}" name="namehotel" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone">Điện thoại <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{$setting->phone}}" name="phone" class="form-control" maxlength="10">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{$setting->email}}" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="address">Địa chỉ <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{ old('address', $setting->address ?? '') }}" name="address" class="form-control">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="ward" class="form-label">Phường/Xã <strong style="color: red">*</strong></label>
                            <select class="form-control" name="ward" id="wardSelect">
                                <option value="">Chọn phường/xã</option>
                                @if (isset($wards) && count($wards) > 0)
                                    @foreach($wards as $ward)
                                        <option value="{{ $ward['Code'] }}" {{ $ward['Code'] == old('ward', $setting->ward) ? 'selected' : '' }}>
                                            {{ $ward['FullName'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="district" class="form-label">Quận/Huyện <strong style="color: red">*</strong></label>
                            <select class="form-control" name="district" id="districtSelect">
                                <option value="">Chọn quận/huyện</option>
                                @if (isset($districts) && count($districts) > 0)
                                    @foreach($districts as $district)
                                        <option value="{{ $district['Code'] }}" {{ $district['Code'] == old('district', $setting->district) ? 'selected' : '' }}>
                                            {{ $district['FullName'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="province" class="form-label">Tỉnh/Thảnh phố <strong style="color: red">*</strong></label>
                            <select class="form-control" name="province" id="provinceSelect">
                                <option value="">Chọn tỉnh/thành phố</option>
                                @if (isset($provinces) && count($provinces) > 0)
                                    @foreach($provinces as $province)
                                        <option value="{{ $province['Code'] }}" {{ $province['Code'] == old('province', $setting->province) ? 'selected' : '' }}>
                                            {{ $province['FullName'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="manager">Tên quản lý <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{$setting->manager}}" name="manager" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time">Thời gian làm việc <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{$setting->time}}" name="time" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="manager">Logo trang web <strong style="color: red">*</strong></label>
                            <input type="file" name="logowebsite" id="images_logo" class="form-control-file" accept="image/*">
                            <div id="existing-images-logo" class="mb-3 mt-3">
                                <h4>Ảnh hiện có:</h4>
                                @if(isset($setting->logowebsite) && !empty($setting->logowebsite))
                                    <img src="{{ url('hotel_images/' . $setting->logowebsite) }}" class="img-thumbnail" style="width: 150px; margin-right: 10px; background: rgb(210, 210, 210)" alt="Ảnh hiện có">
                                @else
                                    <p>Không có ảnh nào.</p>
                                @endif
                            </div>

                            <div id="image-preview-logo" class="mt-3"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time">Logo footer <strong style="color: red">*</strong></label>
                            <input type="file" name="logofooter" id="images_footer" class="form-control-file" accept="image/*">
                            <div id="existing-images-footer" class="mb-3 mt-3">
                                <h4>Ảnh hiện có:</h4>
                                @if(isset($setting->logofooter) && !empty($setting->logofooter))
                                    <img src="{{ url('hotel_images/' . $setting->logofooter) }}" class="img-thumbnail" style="width: 150px; margin-right: 10px; background: rgb(210, 210, 210)" alt="Ảnh hiện có">
                                @else
                                    <p>Không có ảnh nào.</p>
                                @endif
                            </div>

                            <div id="image-preview-footer" class="mt-3"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="images" class="form-label">Upload ảnh trang chủ</label>
                        <input type="file" name="images[]" id="images" class="form-control-file" multiple accept="image/*">
                    </div>

                    <div id="existing-images" class="mb-3">
                        <h4>Ảnh hiện có:</h4>
                        @if(is_array($setting->image) && !empty($setting->image))
                            @foreach($setting->image as $image)
                                <img src="{{ url('hotel_images/' . $image) }}" class="img-thumbnail" style="width: 150px; margin-right: 10px;" alt="Ảnh hiện có">
                            @endforeach
                        @else
                            <p>Không có ảnh nào.</p>
                        @endif
                    </div>

                    <div id="image-preview" class="mt-3"></div>

                    <button type="submit" class="btn btn-primary mt-2">Chỉnh sửa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('provinceSelect').addEventListener('change', function() {
        var provinceCode = this.value;
        if (provinceCode) {
            fetch(`/api/vn/districts/${provinceCode}`)
                .then(response => response.json())
                .then(data => {
                    var districtSelect = document.getElementById('districtSelect');
                    districtSelect.innerHTML = '<option value="">Chọn quận</option>';

                    var wardSelect = document.getElementById('wardSelect');
                    wardSelect.innerHTML = '<option value="">Chọn phường</option>';

                    data.forEach(function(district) {
                        var option = document.createElement('option');
                        option.value = district.Code;
                        option.textContent = district.FullName;
                        districtSelect.appendChild(option);
                    });

                    var districtCode = document.getElementById('districtSelect').value;
                    if (districtCode) {
                        fetch(`/api/vn/wards/${provinceCode}/${districtCode}`)
                            .then(response => response.json())
                            .then(data => {
                                var wardSelect = document.getElementById('wardSelect');
                                wardSelect.innerHTML = '<option value="">Chọn phường</option>';
                                data.forEach(function(ward) {
                                    var option = document.createElement('option');
                                    option.value = ward.Code;
                                    option.textContent = ward.FullName;
                                    wardSelect.appendChild(option);
                                });
                            });
                    }
                });
        }
    });

    document.getElementById('districtSelect').addEventListener('change', function() {
        var provinceCode = document.getElementById('provinceSelect').value;
        var districtCode = this.value;
        if (provinceCode && districtCode) {
            fetch(`/api/vn/wards/${provinceCode}/${districtCode}`)
                .then(response => response.json())
                .then(data => {
                    var wardSelect = document.getElementById('wardSelect');
                    wardSelect.innerHTML = '<option value="">Chọn phường</option>';
                    data.forEach(function(ward) {
                        var option = document.createElement('option');
                        option.value = ward.Code;
                        option.textContent = ward.FullName;
                        wardSelect.appendChild(option);
                    });
                });
        }
    });

    function setDefaultValues() {
        var provinceCode = '{{ old('province', $setting->provinceCode ?? '') }}';
        var districtCode = '{{ old('district', $setting->districtCode ?? '') }}';
        var wardCode = '{{ old('ward', $setting->wardCode ?? '') }}';

        if (provinceCode) {
            document.getElementById('provinceSelect').value = provinceCode;
            fetch(`/api/vn/districts/${provinceCode}`)
                .then(response => response.json())
                .then(data => {
                    var districtSelect = document.getElementById('districtSelect');
                    districtSelect.innerHTML = '<option value="">Chọn quận</option>';
                    data.forEach(function(district) {
                        var option = document.createElement('option');
                        option.value = district.Code;
                        option.textContent = district.FullName;
                        districtSelect.appendChild(option);
                    });
                    if (districtCode) {
                        districtSelect.value = districtCode;
                        fetch(`/api/vn/wards/${provinceCode}/${districtCode}`)
                            .then(response => response.json())
                            .then(data => {
                                var wardSelect = document.getElementById('wardSelect');
                                wardSelect.innerHTML = '<option value="">Chọn phường</option>';
                                data.forEach(function(ward) {
                                    var option = document.createElement('option');
                                    option.value = ward.Code;
                                    option.textContent = ward.FullName;
                                    wardSelect.appendChild(option);
                                });
                                if (wardCode) {
                                    wardSelect.value = wardCode;
                                }
                            });
                    }
                });
        }
    }

    setDefaultValues();
});

document.getElementById('images').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('image-preview');
    const existingImagesContainer = document.getElementById('existing-images');

    if (event.target.files.length > 0) {
        existingImagesContainer.style.display = 'none';
    } else {
        existingImagesContainer.style.display = 'block';
    }

    previewContainer.innerHTML = '<h4>Ảnh xem trước:</h4>';
    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (file && file.type.startsWith('image/')) {
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
    }
});

document.getElementById('images_logo').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('image-preview-logo');
    const existingImagesContainer = document.getElementById('existing-images-logo');

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

document.getElementById('images_footer').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('image-preview-footer');
    const existingImagesContainer = document.getElementById('existing-images-footer');

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
@stop
