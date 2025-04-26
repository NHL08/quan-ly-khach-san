<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{url('favicon.ico')}}">

    <meta property="og:title" content="KHÁCH SẠN VIP PRO WEBSITE ADMIN">
    <meta property="og:type" content="site">
    <meta property="og:url" content="{{ remove_protocol(url('/')) }}">
    <meta property="og:image" content="{{ url('favicon.png') }}">
    <meta property="og:site_name" content="{{ remove_protocol(url('/')) }}">
    <meta property="og:description" content="Trang quản lý">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('adminback/css/simplebar.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/feather.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/fullcalendar.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/select2.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/uppy.min.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/jquery.steps.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/jquery.timepicker.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/quill.snow.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('adminback/css/app-light.css')}}" id="lightTheme">
    <link rel="stylesheet" disabled href="{{url('adminback/css/app-dark.css')}}" id="darkTheme">

    @yield('style')
</head>

<body class="vertical light">
    <div class="wrapper">
        <nav class="topnav navbar navbar-light">
            <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
                <i class="fe fe-menu navbar-toggler-icon"></i>
            </button>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
                        <i class="fe fe-sun fe-16"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-sm mt-2">
                            <img src="{{url('avatar_image/'.Auth::user()->avatar)}}" alt="..." style="width: 32px; height: 32px; object-fit: cover;" class="avatar-img rounded-circle">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{url('admin/profile')}}">Thông tin tài khoản</a>
                        <a class="dropdown-item" href="{{url('logout')}}">Đăng xuất</a>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
            <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <nav class="vertnav navbar navbar-light">
                <div class="w-100 mb-4 d-flex">
                    <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{url('/')}}">
                        <img id="logo" style="width: 50px;" src="{{ url('favicon.png') }}">
                    </a>
                </div>

                <ul class="navbar-nav flex-fill w-100 mb-2">
                    <li class="nav-item w-100">
                        <a class="nav-link @yield('dashboard')" href="{{ url('admin') }}">
                            <i class="fa-solid fa-layer-group"></i>
                            <span class="pl-3 item-text">Bảng thống kê</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link @yield('roomlist')" href="{{ url('admin/room/list') }}">
                            <i class="fa-solid fa-building-circle-exclamation"></i>
                            <span class="pl-3 item-text">Quản lý phòng</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link @yield('servicelist')" href="{{ url('admin/service/list') }}">
                            <i class="fa-solid fa-building-wheat"></i>
                            <span class="pl-3 item-text">Quản lý dịch vụ</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link @yield('typeroomlist')" href="{{ url('admin/typeroom/list') }}">
                            <i class="fa-solid fa-building-shield"></i>
                            <span class="pl-3 item-text">Quản lý loại phòng</span>
                        </a>
                    </li>
                    @if (isset(Auth::user()->role) && Auth::user()->role >= 3)
                    <li class="nav-item w-100">
                        <a class="nav-link @yield('userlist')" href="{{ url('admin/staff/list') }}">
                            <i class="fa-regular fa-user"></i>
                            <span class="pl-3 ml-1 item-text">Quản lý khách hàng</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link @yield('student')" href="{{ url('admin/settings/student') }}">
                            <i class="fa-solid fa-book"></i>
                            <span class="pl-3 ml-1 item-text">Cài đặt thành viên</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link @yield('settings')" href="{{ url('admin/settings') }}">
                            <i class="fa-solid fa-gear"></i>
                            <span class="pl-3 ml-1 item-text">Cài đặt website</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link @yield('pays')" href="{{ url('admin/settings/pay') }}">
                            <i class="fa-solid fa-building-columns"></i>
                            <span class="pl-3 ml-1 item-text">Cài đặt thanh toán</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
        </aside>
        <main role="main" class="main-content">
            @yield('content')
        </main>
    </div>

    @include("back.template.script")
</body>

</html>
