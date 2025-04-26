<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{url('favicon.ico')}}">

    <meta property="og:title" content="Khách sạn VIP PRO">
    <meta property="og:type" content="site">
    <meta property="og:url" content="{{ remove_protocol(url('/')) }}">
    <meta property="og:image" content="{{ url('favicon.png') }}">
    <meta property="og:site_name" content="{{ remove_protocol(url('/')) }}">
    <meta property="og:description" content="Đăng nhập vào hệ thống">

    <title>Đăng nhập | Khách sạn VIP PRO</title>

    <link rel="stylesheet" href="{{url('admin/css/simplebar.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('admin/css/feather.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/app-light.css')}}" id="lightTheme">
    <link rel="stylesheet" href="{{url('admin/css/app-dark.css')}}" id="darkTheme" disabled>

    <style>
        .or-text {
            position: relative;
            margin: 1.5rem 0;
            text-align: center;
            text-transform: uppercase;
        }

        .or-text span {
            position: relative;
            z-index: 1;
            background-color: #f8f9fa;
            padding: 0 0.9rem;
            font-size: 1.06rem;
        }

        .or-text::after {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background-color: #e0e0e0;
        }

        .icon {
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body class="light overflow-hidden">
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ url('login') }}" method="POST">
                {!! csrf_field() !!}
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{url('/')}}">
                    <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120"
                        xml:space="preserve">
                        <g>
                            <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                            <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                            <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                        </g>
                    </svg>
                </a>
                <h1 class="h6 mb-3">Đăng nhập</h1>
                @if(session('notice'))
                <div class="alert alert-danger" role="alert">
                    {{session('notice')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                <div class="form-group">
                    <label for="email" class="sr-only">Địa chỉ email đăng nhập</label>
                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Địa chỉ email đăng nhập" oninvalid="this.setCustomValidity('Vui lòng điền địa chỉ email')" oninput="setCustomValidity('')" autofocus>
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Mật khẩu</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Mật khẩu" oninvalid="this.setCustomValidity('Mật khẩu không thể để trống')" oninput="setCustomValidity('')">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="invalidCheck" name="remember">
                        <label class="form-check-label" for="invalidCheck"> Ghi nhớ tài khoản. </label>
                    </div>
                </div>
                <div class="loginwith">
                    <h5 class="or-text"><span>or</span></h5>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <a href="#google" id="btnGg" class="btn btn-lg btn-outline-danger icon"><i class="fa-brands fa-google"></i> Đăng nhập bằng Google</a>
                    </div>
                    <div class="form-group col-lg-6">
                        <a href="#facebook" id="btnFb" class="btn btn-lg btn-outline-primary icon"><i class="fa-brands fa-facebook-f"></i> Đăng nhập bằng Facebook</a>
                    </div>
                </div>
                <div class="mb-2">
                    <label><a href="{{url('forgot')}}">Quên mật khẩu?</a></label>
                </div>
                <div class="mb-3">
                    <label>Chưa có tài khoản? <a href="{{url('register')}}">Đăng ký</a></label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Đăng nhập</button>
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
    <script>
        document.getElementById('btnGg').addEventListener('click', function () {
            alert('Tính năng đăng nhập bằng google đang được phát triển');
        });

        document.getElementById('btnFb').addEventListener('click', function () {
            alert('Tính năng đăng nhập bằng facebook đang được phát triển');
        });
    </script>
</body>

</html>
</body>

</html>
