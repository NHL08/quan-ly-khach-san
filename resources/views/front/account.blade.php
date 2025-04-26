@extends('front.template.master')
@section('title', 'Thông tin tài khoản')
@section('account', 'color: #1cc3b2')
@section('head')
<style>
    #avatar-container {
        position: relative;
        width: 100px;
        height: 100px;
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
<div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{ url('main/img/bg-img/17.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ $namehotel->content }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thông tin cá nhân</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@if(Session::has('flash_message'))
<div class="mt-5 ml-4 mr-4 alert alert-{!! Session::get('flash_level') !!}" role="alert">
    {!!Session::get('flash_message')!!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif

<div class="roberto-news-area section-padding-100-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="comment_area mb-5 clearfix">
                    <ol>
                        <li class="single_comment_area">
                            <div class="comment-content d-flex align-items-center flex-column">
                                <div id="avatar-container">
                                    <img id="avatar" src="{{ url('avatar_image/'.Auth::user()->avatar) }}" onclick="checkImage()" alt="avatar">
                                    <i id="camera-icon" class="fa fa-camera"></i>
                                </div>
                                <div class="comment-meta mt-3 d-flex align-items-center flex-column">
                                    <h5>{{Auth::user()->fullname}}</h5>
                                    <p>{{Auth::user()->email}}</p>
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>

                <div class="roberto-contact-form mt-5 mb-100">
                    <form action="{{ url('account') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="d-none" accept="image/*" name="imageAvatar" id="imageAvatar">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" class="form-control mb-30" placeholder="Email" value="{{Auth::user()->email}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Họ và tên</label>
                                    <input type="text" name="fullname" class="form-control mb-30" placeholder="Họ và tên" value="{{Auth::user()->fullname}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control mb-30" placeholder="Số điện thoại" value="{{Auth::user()->phone}}" maxlength="10">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="address">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control mb-30" placeholder="Địa chỉ" value="{{Auth::user()->address}}">
                                </div>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn roberto-btn btn-3 mt-15">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
