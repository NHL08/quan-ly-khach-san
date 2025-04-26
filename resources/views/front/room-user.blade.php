@extends('front.template.master')
@section('title', 'Phòng của bạn')
@section('account', 'color: #1cc3b2')
@section('content')
<div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{ url('main/img/bg-img/16.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2 class="page-title">{{ $namehotel->content }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Phòng đã đặt</li>
                            @if (Request::has('page'))
                            <li class="breadcrumb-item active" aria-current="page">Trang {{ $rooms->currentPage() }}</li>
                            @endif
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

<div class="roberto-rooms-area section-padding-100-0">
    <div class="container">
        <div class="row">
            <div id="room-list" class="col-12">
                @if(isset($rooms)&&count($rooms) > 0)
                @foreach ( $rooms as $room )
                <div class="single-room-area d-flex align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms">
                    <div class="room-thumbnail">
                        <div class="testimonial-thumbnail owl-carousel">
                            @if (is_array($room->image) && count($room->image) > 0)
                                @foreach ($room->image as $image)
                                    <img src="{{ url('room_images/'. $image) }}" alt="">
                                @endforeach
                            @else
                                <img src="{{ url('room_images/default.jpg') }}" alt="Không có ảnh">
                            @endif
                        </div>
                    </div>
                    <div class="room-content">
                        <h2>Phòng {{ $room->id }}</h2>
                        <h4>{{ number_format($room->price, 0, ',', '.') }} VNĐ <span>/ Đêm </span></h4>
                        <div class="room-feature">
                            <h6>Loại phòng: <span>{{ $room->type }}</span></h6>
                            <h6>Dịch vụ: <br><span>Có điều hoà, Truyền hình cáp.....</span></h6>
                            @if (isset($room->note))
                            <h6>Ghi chú: <span>{{ $room->note }}</span></h6>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="single-room-area d-flex align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms">
                    <div class="room-content">
                        <h2>Không có phòng nào</h2>
                    </div>
                </div>
                @endif
                @if(isset($rooms) && $rooms->count() > 0)
                <nav class="roberto-pagination wow fadeInUp mb-100" data-wow-delay="1000ms">
                    <ul class="pagination">
                        @if($rooms->currentPage() > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ url('room') . '?page=' . ($rooms->currentPage() - 1) }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @endif

                        @for($i = 1; $i <= $rooms->lastPage(); $i++)
                            <li class="page-item {{ $i == $rooms->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ url('room') . '?page=' . $i }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($rooms->currentPage() < $rooms->lastPage())
                            <li class="page-item">
                                <a class="page-link" href="{{ url('room') . '?page=' . ($rooms->currentPage() + 1) }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
