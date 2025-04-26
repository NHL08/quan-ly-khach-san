@extends('front.template.master')
@section('title', 'Đặt phòng'. $id)
@section('hotel', 'active')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
                            <li class="breadcrumb-item active" aria-current="page">Đặt phòng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="roberto-rooms-area section-padding-100-0">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="single-room-area d-flex align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms">
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
            </div>

            <div class="col-12 col-lg-6">
                <div class="hotel-reservation--area mb-100">
                    <form action="{{ url('hotel/room/'.$id.'/book') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ Request::get('checkIn') }}" name="checkIn">
                        <input type="hidden" value="{{ Request::get('checkOut') }}" name="checkOut">
                        <input type="hidden" value="{{ Request::get('adults') }}" name="adults">
                        <input type="hidden" value="{{ Request::get('children') }}" name="children">

                        <div class="single-room-details-area mb-50">
                            <h2>Thông tin đặt phòng {{ $id }}</h2>

                            <p>Ngày nhận phòng: {{ Request::get('checkIn') ? Request::get('checkIn') : 'Chưa có thông tin' }} - Ngày trả phòng: {{ Request::get('checkOut') ? Request::get('checkOut') : 'Chưa có thông tin' }}</p>
                            <p>Loại phòng: {{ $room->type ?? 'Chưa có thông tin' }}</p>
                            <p>Số người ở: {{ Request::get('adults') ?? 0 }} người lớn | {{ Request::get('children') ?? 0 }} trẻ em</p>
                            <p>Thuê: {{ $room->rented_days ?? 0 }} ngày ({{ number_format($room->price ?? 0, 0, ',', '.') }} VNĐ/Ngày)</p>

                            <div class="form-group">
                                <label for="note">Ghi chú</label>
                                <textarea class="form-control" style="height: 130px; overflow: hidden;" name="note" id="note" rows="15" placeholder="Ghi chú"></textarea>
                            </div>
                        </div>
                        <div class="text-right mr-2">
                            <p class="mb-2 h6">
                                <span class="text-muted">Tạm tính : </span>
                                <strong>{{ number_format($room->total_price, 0, ',', '.') }} VNĐ</strong>
                            </p>
                            <p class="mb-2 h6">
                                <span class="text-muted">VAT (10%) : </span>
                                <strong>{{ number_format($room->total_price * 0.10, 0, ',', '.') }} VNĐ</strong>
                            </p>
                            <p class="mb-2 h6">
                                <span class="text-muted">Tổng cộng : </span>
                                <span>{{ number_format($room->total_price + ($room->total_price * 0.10), 0, ',', '.') }} VNĐ</span>
                            </p>
                            <p class="mb-2 h6">
                                <span class="text-muted">Tạm thu : </span>
                                <span>{{ number_format(($room->total_price + ($room->total_price * 0.10)) * 0.2, 0, ',', '.') }} VNĐ</span>
                            </p>
                        </div>
                        <div class="form-group mt-5">
                            <button type="button" data-toggle="modal" data-target="#payModal" class="btn roberto-btn w-100">Thanh toán</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyModalLabel">Thanh toán</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex">
                <img src="https://api.vietqr.io/image/{{ $number_bank }}-{{ $number_card }}-VMvoWhr.jpg?accountName={{ str_replace('+', '%20', urlencode($name_card)) }}&amount={{ ($room->total_price + ($room->total_price * 0.10)) * 0.2 }}&addInfo=THANH%20TOAN%20HOA%20DON%20PHONG%20{{ $id }}" style="width: 350px; height: 350px;" class="navbar-brand-img brand-sm mx-auto my-4" alt="QR CODE">
            </div>
            <div class="modal-footer">
                <button type="submit" data-dismiss="modal" class="btn mb-2 btn-secondary">Đóng</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('button[data-target="#payModal"]').on('click', function() {
            var roomId = {{ $room->id }};
            var url = '/hotel/room/' + roomId + '/book';

            var data = {
                roomId: roomId,
                checkIn: '{{ Request::get('checkIn') }}',
                checkOut: '{{ Request::get('checkOut') }}',
                adults: '{{ Request::get('adults') }}',
                children: '{{ Request::get('children') }}',
                note: $('#note').val()
            };

            $.post(url, data, function(response) {
                setTimeout(function() {
                    sessionStorage.setItem('flash_level', response.flash_level);
                    sessionStorage.setItem('flash_message', response.flash_message);

                    window.location.href = '{{ route("roomUser") }}';
                }, 5000); // 5000 ms = 5 giây
            }).fail(function(xhr, status, error) {
                console.error("Có lỗi xảy ra:", error);
            });
        });
    });
</script>
@endsection
