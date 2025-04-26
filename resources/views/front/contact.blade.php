@extends('front.template.master')
@section('title', 'Liên hệ')
@section('contact', 'active')
@section('content')
<div class="breadcrumb-area contact-breadcrumb bg-img bg-overlay jarallax" style="background-image: url({{ url('main/img/bg-img/18.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center mt-100">
                    <h2 class="page-title">Liên hệ chúng tôi</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liên hệ chúng tôi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="google-maps-contact-info mb-5">
    <div class="container-fluid">
        <div class="google-maps-contact-content">
            <div class="row">
                <div class="col-6 col-lg-3">
                    <div class="single-contact-info">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <h4>Điện thoại</h4>
                        <p>{{ $phone->content }}</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="single-contact-info">
                        <i class="fa-solid fa-location-pin" aria-hidden="true"></i>
                        <h4>Địa chỉ</h4>
                        <p>{{ $address->content }}, {{ $wardName }}, {{ $districtName }}, {{ $provinceName }}</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="single-contact-info">
                        <i class="fa-regular fa-clock" aria-hidden="true"></i>
                        <h4>Giờ mở cửa</h4>
                        <p>{{ $time->content }}</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="single-contact-info">
                        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                        <h4>Email</h4>
                        <p>{{ $email->content }}</p>
                    </div>
                </div>
            </div>

            <div class="google-maps">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29793.98845886395!2d105.8163641185006!3d21.02273835998308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9bd9861ca1%3A0xe7887f7b72ca17a9!2zSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1722938256507!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>
@stop
