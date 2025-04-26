@extends('front.template.master')
@section('title', 'Trang chủ')
@section('home', 'active')
@section('content')
<section class="welcome-area">
    <div class="welcome-slides owl-carousel">
        @foreach ($imagehotel as $hotel)
        <div class="single-welcome-slide bg-img bg-overlay" style="background-image: url({{ url('hotel_images/'. $hotel) }});"
            data-img-url="{{ url('hotel_images/'. $hotel) }}">
            <div class="welcome-content h-100">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <div class="welcome-text text-center">
                                <h6 data-animation="fadeInLeft" data-delay="200ms">Hotel &amp; Resort</h6>
                                <h2 data-animation="fadeInLeft" data-delay="500ms">Chào mừng đến {{ $namehotel->content }}</h2>
                                <a href="{{ url('hotel') }}" class="btn roberto-btn btn-2" data-animation="fadeInLeft"
                                    data-delay="800ms">Khám phá ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
</section>

<section class="roberto-about-area section-padding-100-0">
    <div class="hotel-search-form-area">
        <div class="container-fluid">
            <div class="hotel-search-form">
                <form action="{{ url('hotel') }}" method="get">
                    <div class="row justify-content-between align-items-end">
                        <div class="col-6 col-md-2 col-lg-3">
                            <label for="checkIn">Ngày nhận phòng</label>
                            <div class="input-daterange" id="datepicker">
                                <input type="text" class="form-control" id="checkIn" name="checkIn" placeholder="Ngày nhận phòng" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6 col-md-2 col-lg-3">
                            <label for="checkOut">Ngày trả phòng</label>
                            <div class="input-daterange" id="datepicker">
                                <input type="text" class="form-control" id="checkOut" name="checkOut" placeholder="Ngày trả phòng" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6 col-md-2 col-lg-3">
                            <label for="room">Loại phòng</label>
                            <select name="typeroom" id="room" class="form-control">
                                @foreach($roomtype as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <button type="submit" class="form-control btn roberto-btn w-100">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-100">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="section-heading wow fadeInUp" data-wow-delay="100ms">
                    <h6>Về chúng tôi</h6>
                    <h2>Chào mừng bạn đến <br>{{  $namehotel->content }}</h2>
                </div>
                <div class="about-us-content mb-100">
                    <h5 class="wow fadeInUp" data-wow-delay="300ms">{{ $namehotel->content }} mới thành lập tại trung tâm, có 15 phòng hiện đại, nhà hàng, spa, gym, và hồ bơi. Đội ngũ nhân viên chuyên nghiệp đảm bảo kỳ nghỉ tuyệt vời cho khách hàng.</h5>
                    <p class="wow fadeInUp" data-wow-delay="400ms">Quản lý: <span>{{ $manager->content }}</span></p>

                    @php
                        $nameParts = explode(' ', preg_replace('/\d+/', '', $manager->content));
                        $lastPart = end($nameParts);
                        $lastPartNoAccents = removeAccents(strtolower($lastPart));
                        $formattedName = ucfirst($lastPartNoAccents);
                    @endphp

                    <p class="wow fadeInUp noselect" data-wow-delay="500ms" style="font-family: 'QuickLetter'; font-size: 2.75em; color: rgb(125,125,125)">{{ $formattedName }}</p>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="about-us-thumbnail mb-100 wow fadeInUp" data-wow-delay="700ms">
                    <div class="row no-gutters">
                        <div class="col-6">
                            <div class="single-thumb">
                                <img src="{{ url('main/img/bg-img/13.jpg') }}" alt="">
                            </div>
                            <div class="single-thumb">
                                <img src="{{ url('main/img/bg-img/14.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="single-thumb">
                                <img src="{{ url('main/img/bg-img/15.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="roberto-rooms-area mb-">
    <div class="rooms-slides owl-carousel">
        @if(isset($rooms)&&count($rooms) > 0)
        @foreach ( $rooms as $room )
        <div class="single-room-slide d-flex align-items-center">
            @if (is_array($room->image) && count($room->image) > 0)
                <div class="room-thumbnail h-100 bg-img" style="background-image: url({{ url('room_images/'. $room->image[0]) }});"></div>
            @endif
            <div class="room-content">
                <h2 data-animation="fadeInUp" data-delay="100ms">Phòng {{ $room->id }}</h2>
                <h3 data-animation="fadeInUp" data-delay="300ms">{{ number_format($room->price, 0, ',', '.') }} VNĐ <span>/ Đêm </span></h3>
                <ul class="room-feature" data-animation="fadeInUp" data-delay="500ms">
                    <li><span><i class="fa-solid fa-check"></i> Loại phòng</span> <span>: {{ $room->type }}</span></li>
                    <li><span><i class="fa-solid fa-check"></i> Dịch vụ</span> <span>: Có điều hoà, Truyền hình cáp.....</span>
                    </li>
                </ul>
                <a href="{{ url('hotel/room/'. $room->id) }}" class="btn roberto-btn mt-30" data-animation="fadeInUp" data-delay="700ms">Xem chi tiết</a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</section>

<section class="roberto-testimonials-area section-padding-100-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="section-heading d-flex justify-content-center">
                    <h2>Giới thiệu thành viên nhóm</h2>
                </div>
                <div class="testimonial-slides owl-carousel mb-100">
                    @foreach ($students as $student)
                    <div class="single-testimonial-slide d-flex justify-content-center align-items-center flex-column ">
                        <img src="{{ url('student_image/' . $student->avatar) }}" class="mb-3" style="width:175px; height:175px; object-fit: cover; border-radius: 100%"  alt="">
                        <h5>{{ $student->masv }}</h5>
                        <div class="rating-title">
                            <h6>{{ $student->fullname }}</h6>
                        </div>
                        <div class="rating-title">
                            <h6><span class="d-flex justify-content-center">{{ $student->role }}</span></h6>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
