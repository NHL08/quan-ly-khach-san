@extends('back.template.master')
@section('title', 'Chỉnh sửa hồ sơ cá nhân')
@section('profile', 'active')
@section('style')
<style>
    #avatar-container {
        position: relative;
        width: 128px;
        height: 128px;
        border-radius: 50%;
        overflow: hidden;
    }

    img#avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        transition: filter 0.5s, transform 0.5s;
    }

    #avatar-container:hover img#avatar {
        filter: blur(3px) brightness(0.7);
        transform: scale(1.1);
    }

    #camera-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 24px;
        opacity: 0;
        transition: opacity 0.5s;
        pointer-events: none;
    }

    #avatar-container:hover #camera-icon {
        opacity: 1;
    }
</style>
@endsection
@section('content')
<div>
    <div style="padding: 0.75rem 1.25rem;">
        <h2 class="card-title">Chỉnh sửa hồ sơ cá nhân</h2>
        @if(Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
            {!!Session::get('flash_message')!!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @yield('profile')" href="{{url('admin/profile')}}">Hồ sơ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @yield('security')" href="#security">Bảo mật</a>
                </li>
            </ul>
            <form action="{{url('admin/profile')}}" enctype="multipart/form-data" method="post">
                <div class="row mt-5 align-items-center">
                    <div class="col-md-3 text-center mb-5">
                        <div class="avatar avatar-xl ml-5" id="avatar-container">
                            <img id="avatar" src="{{url('avatar_image/'.Auth::user()->avatar)}}" onclick="checkImage()" alt="...">
                            <i id="camera-icon" class="fa fa-camera"></i>
                        </div>
                        <input type="file" name="imageAvatar" id="imageAvatar" accept="image/*" style="display: none;">
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h4 class="mb-1">{{Auth::user()->fullname}}</h4>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <div class="col">
                                <p class="small mb-0 text-muted">{{Auth::user()->email}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{Auth::user()->id}}">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="fullname">Họ và tên <strong style="color: red">*</strong></label>
                        <input type="text" name="fullname" class="form-control" value="{{Auth::user()->fullname}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email <strong style="color: red">*</strong></label>
                    <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}" disabled>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="address">Địa chỉ <strong style="color: red">*</strong></label>
                        <input autocomplete="off" type="text" value="{{Auth::user()->address}}" name="address" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Điện thoại <strong style="color: red">*</strong></label>
                        <input autocomplete="off" type="text" value="{{Auth::user()->phone}}" name="phone" class="form-control" maxlength='10'>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Mật khẩu mới</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" name="confirmpassword">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">Yêu cầu về mật khẩu</p>
                        <p class="small text-muted mb-2"> Để tạo mật khẩu mới, bạn phải đáp ứng tất cả các yêu cầu sau:</p>
                        <ul class="small text-muted pl-4 mb-0">
                            <li> Tối thiểu 8 ký tự </li>
                            <li> Ít nhất một ký tự đặc biệt </li>
                            <li> Ít nhất một ký tự viết hoa </li>
                            <li> Ít nhất một số </li>
                        </ul>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Thay đổi</button>
            </form>
        </div>
    </div>
</div>

<script>
    function checkImage() {
        var file = document.getElementById('imageAvatar');
        file.click();
    }

    document.getElementById('imageAvatar').addEventListener('change', function(event) {
    const avatar = document.getElementById('avatar');
    const files = event.target.files;

    if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatar.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
@stop
