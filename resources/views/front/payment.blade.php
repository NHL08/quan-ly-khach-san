@extends('front.template.master')
@section('title', 'Hình thức thanh toán')
{{-- @section('contact', 'active') --}}
@section('content')
<div class="breadcrumb-area contact-breadcrumb bg-img bg-overlay jarallax" style="background-image: url({{ url('main/img/bg-img/18.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center mt-100">
                    <h2 class="page-title">Hình thức thanh toán</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hình thức thanh toán</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="roberto-rooms-area section-padding-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="mb-4">
                    <h4>1. Thanh toán bằng chuyển khoản ngân hàng</h4>
                    <h6 class="text-secondary">Tên tài khoản: {{ $name_card }}</h6>
                    <h6 class="text-secondary">Số tài khoản: {{ $number_card }}</h6>
                    <h6 class="text-secondary">Tại: {{ $name_bank }}</h6>
                    <h6 class="text-secondary">Chi nhánh: {{ $branch_card }}</h6>
                </div>

                <div class="mb-4">
                    <h4>2. Thanh toán tại văn phòng của {{ $namehotel->content }}</h4>
                    <h6 class="text-secondary">Địa chỉ: {{ $address->content }}, {{ $wardName }}, {{ $districtName }}, {{ $provinceName }}</h6>
                    <h6 class="text-secondary">Số điện thoại hotline: {{ $phone->content }}</h6>
                    <h6 class="text-secondary">Giờ làm việc: {{ $time->content }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
