<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{url('favicon.ico')}}">
    <title>Lấy lại mật khẩu</title>

    <link rel="stylesheet" href="{{url('admin/css/simplebar.css')}}">
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{url('admin/css/feather.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/app-light.css')}}" id="lightTheme">
    <link rel="stylesheet" href="{{url('admin/css/app-dark.css')}}" id="darkTheme" disabled>
</head>

<body class="light overflow-hidden">
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center">
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
                    <h2 class="my-3">Lấy lại mật khẩu</h2>
                    @if(session('notice'))
                    <div class="alert alert-danger" role="alert">
                        {{session('notice')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                </div>
                <p class="text-muted">Nhập địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn một email kèm theo mã OTP để đặt lại mật khẩu của bạn</p>
                <div class="form-group">
                    <label for="email" class="sr-only">Địa chỉ Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Nhập địa chỉ Email">
                </div>
                <button class="btn btn-lg btn-primary btn-block" id="btnForgot" type="submit">Lấy lại mật khẩu</button>
            </form>
        </div>
    </div>
    <script src="{{url('admin/js/jquery.min.js')}}"></script>
    <script src="{{url('admin/js/popper.min.js')}}"></script>
    <script src="{{url('admin/js/moment.min.js')}}"></script>
    <script src="{{url('admin/js/bootstrap.min.js')}}"></script>
    <script src="{{url('admin/js/simplebar.min.js')}}"></script>
    <script src='{{url('admin/js/daterangepicker.js')}}'></script>
    <script src='{{url('admin/js/jquery.stickOnScroll.js')}}'></script>
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
        document.getElementById('btnForgot').addEventListener('click', function () {
            if (document.querySelector('input[name="email"]').value == '') {
                alert('Vui lòng nhập địa chỉ email');
                return false;
            }
            alert('Chức năng này đang được phát triển');
        });
    </script>
</body>

</html>
</body>

</html>
