@extends('back.template.master')
@section('title', 'Quản lý phòng')
@section('roomlist', 'active')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="h5 page-title"><small class="text-muted text-uppercase">Hóa đơn</small><br />#{{ $maHoaDon }}</h2>
                </div>
                <div class="col-auto">
                    <a class="btn btn-danger" href="{{ url('admin/room/list') }}">Quay lại</a>
                    <button type="button" id="printButton" class="btn btn-secondary" data-toggle="modal" data-target="#thanhtoanModal">Thanh toán</button>
                    <div class="modal fade" id="thanhtoanModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="defaultModalLabel">Thanh toán</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body d-flex">
                                    {{-- img qr --}}
                                    <img src="https://api.vietqr.io/image/{{ $number_bank }}-{{ $number_card }}-VMvoWhr.jpg?accountName={{ str_replace('+', '%20', urlencode($name_card)) }}&amount={{ number_format($room->totalPrice + ($room->totalPrice * 0.10), 0, '.', '') }}&addInfo=THANH%20TOAN%20HOA%20DON%20{{ $maHoaDon }}" style="width: 300px; height: 300px;" class="navbar-brand-img brand-sm mx-auto my-4" alt="QR CODE">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="d-inline" action="{{ url('admin/room/checkout/' . $roomId) }}" method="post">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary">Đã thanh toán</button>
                    </form>
                </div>
            </div>
            <div class="card shadow" id="invoiceContent">
                <div class="card-body p-5">
                    <div class="row mb-5">
                        <div class="col-12 text-center mb-4">
                            {{-- <img src="{{ url('admin/assets/images/logo.svg') }}" class="navbar-brand-img brand-sm mx-auto mb-4" alt="..."> --}}
                            <img class="navbar-brand-img brand-sm mx-auto mb-4" alt="..." style="width: 50px;" src="{{ url('favicon.png') }}">
                            <h2 class="mb-0 text-uppercase">Hóa đơn phòng {{ $roomId }}</h2>
                            <p class="text-muted"> {{ $namehotel->content }} <br /> {{ $address->content }}, {{ $wardName }}, {{ $districtName }}, {{ $provinceName }} </p>
                        </div>
                        <div class="col-md-7">
                            <p class="small text-muted text-uppercase mb-2">Hoá đơn từ</p>
                            <p class="mb-4">
                                <strong>{{ $Admin->fullname }}</strong><br /> {{ $Admin->levelname }}<br/> {{ $phone->content }}<br/> {{ $email->content }}
                            </p>
                            <p>
                                <span class="small text-muted text-uppercase">Hóa đơn </span><br/>
                                <strong>#{{ $maHoaDon }}</strong>
                            </p>
                        </div>
                        <div class="col-md-5">
                            <p class="small text-muted text-uppercase mb-2">Hoá đơn tới</p>
                            <p class="mb-4">
                                @if($room->user == 10000)
                                    <strong>Khách ngoại</strong>
                                @else
                                    <strong>{{ $client->fullname }}</strong><br/>{{ $client->address }}<br/> {{ $client->phone }}<br/>
                                @endif
                            </p>
                            <p>
                                <small class="small text-muted text-uppercase">Ngày lập hoá đơn</small><br/>
                                <strong>{{ $today }}</strong>
                            </p>
                        </div>
                    </div>

                    <table class="table table-borderless table-striped">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Dịch vụ</th>
                                <th scope="col" class="text-right">Tiền</th>
                                <th scope="col" class="text-right">Số lượng</th>
                                <th scope="col" class="text-right">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $room->type }}</td>
                                <td class="text-right">{{ number_format($room->room_price, 0, ',', '.') }}</td>
                                <td class="text-right">{{ $room->rented_days }} ngày (Từ {{ $room->startday . ' - ' . $room->endday}})</td>
                                <td class="text-right">{{ number_format($room->room_price * $room->rented_days, 0, ',', '.') }}</td>
                            </tr>

                            @foreach($room->serviceDetails as $index => $service)
                                <tr>
                                    <th scope="row">{{ $index + 2 }}</th>
                                    <td>{{ $service['name'] }}</td>
                                    <td class="text-right">{{ number_format($service['price'], 0, ',', '.') }}</td>
                                    <td class="text-right">{{ $service['quantity'] }}</td>
                                    <td class="text-right">{{ number_format($service['total'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row mt-5">
                        <div class="col-2 text-center">
                            <img src="https://api.vietqr.io/image/{{ $number_bank }}-{{ $number_card }}-VMvoWhr.jpg?accountName={{ str_replace('+', '%20', urlencode($name_card)) }}&amount={{ number_format($room->totalPrice + ($room->totalPrice * 0.10), 0, '.', '') }}&addInfo=THANH%20TOAN%20HOA%20DON%20{{ $maHoaDon }}" style="width: 100px; height: 100px;" class="navbar-brand-img brand-sm mx-auto my-4" alt="QR CODE">
                        </div>
                        <div class="col-md-5">
                            <p class="text-muted small">
                                <strong>Ghi chú :</strong> Vui lòng kiểm tra thông tin cẩn thận và liên hệ với chúng tôi nếu có bất kỳ câu hỏi hoặc yêu cầu nào. Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
                        </div>
                        <div class="col-md-5">
                            <div class="text-right mr-2">
                                <p class="mb-2 h6">
                                    <span class="text-muted">Tạm tính : </span>
                                    <strong>{{ number_format($room->totalPrice, 0, ',', '.') }} VNĐ</strong>
                                </p>
                                <p class="mb-2 h6">
                                    <span class="text-muted">VAT (10%) : </span>
                                    <strong>{{ number_format($room->totalPrice * 0.10, 0, ',', '.') }} VNĐ</strong>
                                </p>
                                <p class="mb-2 h6">
                                    <span class="text-muted">Tổng cộng : </span>
                                    <span>{{ number_format($room->totalPrice + ($room->totalPrice * 0.10), 0, ',', '.') }} VNĐ</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
