<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{url('favicon.ico')}}">
    <title>Đăng ký | Khách sạn VIP PRO</title>

    <link rel="stylesheet" href="{{url('admin/css/simplebar.css')}}">
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{url('admin/css/feather.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/app-light.css')}}" id="lightTheme">
    <link rel="stylesheet" href="{{url('admin/css/app-dark.css')}}" id="darkTheme" disabled>
</head>

<body class="light overflow-hidden">
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-6 col-md-8 col-10 mx-auto" action="{{url('register')}}" method="POST">
                {!! csrf_field() !!}
                <div class="mx-auto text-center my-4">
                    <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{url('/')}}">
                        <svg version="1.1" id="logo" class="navbar-brand-img brand-md"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                            y="0px" viewBox="0 0 120 120" xml:space="preserve">
                            <g>
                                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                            </g>
                        </svg>
                    </a>
                    <h2 class="my-3">Đăng ký</h2>
                    @if(session('notice'))
                    <div class="alert alert-danger" role="alert">
                        {{session('notice')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @elseif($errors->first('email'))
                    <div class="alert alert-danger" role="alert">
                        Email đã có người sủ dụng
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">Họ & đệm <strong style="color: red">*</strong></label>
                        <input autocomplete="off" type="text" value="{{ old('firstname') }}" name="firstname" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">Tên <strong style="color: red">*</strong></label>
                        <input autocomplete="off" type="text" value="{{ old('lastname') }}" name="lastname" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ <strong style="color: red">*</strong></label>
                    <input autocomplete="off" type="address" value="{{ old('address') }}" class="form-control" name="address">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Địa chỉ email <strong style="color: red">*</strong></label>
                        <input autocomplete="off" type="email" value="{{ old('email') }}" name="email" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Điện thoại <strong style="color: red">*</strong></label>
                        <input autocomplete="off" type="text" value="{{ old('phone') }}" name="phone" class="form-control" maxlength='10'>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Mật khẩu <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Xác nhận mật khẩu <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="password" class="form-control" name="confirmpassword">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">Yêu cầu về mật khẩu</p>
                        <p class="small text-muted mb-2">Để tạo mật khẩu mới, bạn phải đáp ứng tất cả các yêu cầu sau:</p>
                        <ul class="small text-muted pl-4 mb-0">
                            <li> Tối thiểu 8 ký tự </li>
                            <li> Ít nhất một ký tự đặc biệt </li>
                            <li> Ít nhất một ký tự viết hoa </li>
                            <li> Ít nhất một số </li>
                        </ul>
                    </div>
                </div>
                <button class="btn btn-lg btn-success btn-block" style="color: white" type="submit">Đăng ký</button>
                <a style="color: white" class="btn btn-lg btn-danger btn-block" href="{{url('/')}}">Quay lại trang chủ</a>
            </form>
        </div>
    </div>
    <script src="{{url('admin/js/jquery.min.js')}}"></script>
    <script src="{{url('admin/js/popper.min.js')}}"></script>
    <script src="{{url('admin/js/moment.min.js')}}"></script>
    <script src="{{url('admin/js/bootstrap.min.js')}}"></script>
    <script src="{{url('admin/js/simplebar.min.js')}}"></script>
    <script src="{{url('admin/js/daterangepicker.js')}}"></script>
    <script src="{{url('admin/js/jquery.stickOnScroll.js')}}"></script>
    <script src="{{url('admin/js/tinycolor-min.js')}}"></script>
    <script src="{{url('admin/js/config.js')}}"></script>
    <script src="{{url('admin/js/apps.js')}}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');

    </script>
</body>

</html>
</body>

</html>
