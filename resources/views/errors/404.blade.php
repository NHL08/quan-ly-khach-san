<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <meta property="og:title" content="Không tìm thấy trang">
    <meta property="og:type" content="site">
    <meta property="og:url" content="{{ remove_protocol(url('/')) }}">
    <meta property="og:image" content="{{ url('favicon.png') }}">
    <meta property="og:site_name" content="{{ remove_protocol(url('/')) }}">
    <meta property="og:description" content="Không tìm thấy trang">

    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('favicon.ico')}}">
    <title>404 Không tìm thấy trang</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{url('admin/css/simplebar.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/feather.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/select2.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/uppy.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/jquery.steps.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/jquery.timepicker.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/quill.snow.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/app-light.css')}}" id="lightTheme">
    <link rel="stylesheet" disabled href="{{url('admin/css/app-dark.css')}}" id="darkTheme">
</head>

<body class="light ">
    <div class="wrapper vh-100">
        <div class="align-items-center h-100 d-flex w-50 mx-auto">
            <div class="mx-auto text-center">
                <h1 class="display-1 m-0 font-weight-bolder text-muted" style="font-size:80px;">404</h1>
                <h1 class="mb-1 text-muted font-weight-bold">LỖI</h1>
                <h6 class="mb-3 text-muted">Lỗi không tìm thấy trang</h6>
                <a href="{{url('/')}}" class="btn btn-lg btn-primary px-5">Quay lại trang chủ</a>
            </div>
        </div>
    </div>

    @include('back.template.script')
</body>

</html>
</body>

</html>
