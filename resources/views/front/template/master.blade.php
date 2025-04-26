<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') | {{ $namehotel->content }}</title>

    <link rel="icon" href="{{url('favicon.ico')}}">

    <link rel="stylesheet" href="{{ url('main/style.css') }}">
    <link rel="stylesheet" href="{{ url('main/font.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .noselect {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>

    @yield('head')
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <header class="header-area">
        <div class="main-header-area">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <nav class="classy-navbar justify-content-between" id="robertoNav">
                        <a class="nav-brand" href="{{ url('/') }}"><img width="160px" src="{{ url('hotel_images/'. $logowebsite->content) }}" alt=""></a>
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </div>
                        <div class="classy-menu">
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>
                            <div class="classynav">
                                <ul id="nav">
                                    <li class="@yield('home')"><a href="{{ url('/') }}">Trang chủ</a></li>
                                    <li class="@yield('hotel')"><a href="{{ url('hotel') }}">Khách sạn</a></li>
                                    <li class="@yield('contact')"><a href="{{ url('contact') }}">Liên hệ</a></li>
                                </ul>
                                @if (isset(Auth::user()->email))
                                    <ul id="nav">
                                        <li><a style="@yield('account')" href="#">Xin chào <strong>{{ Auth::user()->fullname }}</strong></a>
                                            <ul class="dropdown">
                                                <li><a href="{{ url('account') }}">- Thông tin cá nhân</a></li>
                                                <li><a href="{{ url('room') }}">- Phòng đã đặt</a></li>
                                                @if (Auth::user()->role > 1)
                                                <li><a href="{{ url('admin') }}">- Quản trị</a></li>
                                                @endif
                                                <li><a href="{{ url('logout') }}">- Đăng xuất</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                @else
                                <ul id="nav">
                                    <li><a href="{{ url('login') }}">Đăng nhập</a></li>
                                </ul>
                                <div class="book-now-btn">
                                    <a href="{{ url('register') }}">Đăng ký <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="footer-area section-padding-80-0">
        <div class="main-footer-area">
            <div class="container">
                <div class="row align-items-baseline justify-content-between">
                    <div class="col-12 col-sm-6 col-lg-9">
                        <div class="single-footer-widget mb-80">
                            <a href="{{ url('/') }}" class="footer-logo"><img width="160px" src="{{ url('hotel_images/'. $logofooter->content) }}" alt=""></a>

                            <h4><a href="tel:{{ $phone->content }}">Hotline: {{ $phone->content }}</a></h4>
                            <span><a href="mailto:{{ $email->content }}">Email: {{ $email->content }}</a></span>
                            <span>{{ $address->content }}, {{ $wardName }}, {{ $districtName }}, {{ $provinceName }}</span>
                            <span>{{ $time->content }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 col-lg-3">
                        <div class="single-footer-widget mb-80">
                            <h5 class="widget-title">Giới thiệu</h5>
                            <ul class="footer-nav">
                                <li><a href="{{ url('hotel') }}"><i class="fa fa-caret-right" aria-hidden="true"></i> Xem phòng</a></li>
                                <li><a href="{{ url('contact') }}"><i class="fa fa-caret-right" aria-hidden="true"></i> Liên hệ</a></li>
                                <li><a href="{{ url('hinh-thuc-thanh-toan') }}"><i class="fa fa-caret-right" aria-hidden="true"></i> Hình thức thanh toán</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="copywrite-content">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8">
                        <div class="copywrite-text">
                            <p>
                                Copyright &copy; <script> document.write(new Date().getFullYear());</script>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="social-info">
                            <a href="#facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
                            <a href="#instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ url('main/js/jquery.min.js') }}"></script>
    <script src="{{ url('main/js/popper.min.js') }}"></script>
    <script src="{{ url('main/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('main/js/roberto.bundle.js') }}"></script>
    <script src="{{ url('main/js/default-assets/active.js') }}"></script>
    @yield('script')
</body>

</html>
