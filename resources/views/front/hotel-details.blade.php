@extends('front.template.master')
@section('title', 'Khách sạn')
@section('hotel', 'active')

@section('head')
<style>
    .textarea-container {
        position: relative;
    }

    textarea {
        width: 100%;
        padding-right: 50px;
        box-sizing: border-box;
    }

    emoji-picker {
        position: absolute;
        top: 40px;
        right: 10px;
        z-index: 1000;
        display: none;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        max-height: 275px;
        overflow-y: auto;
    }

    .emoji-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{ url('main/img/bg-img/16.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-end">
            <div class="col-12">
                <div class="breadcrumb-content d-flex align-items-center justify-content-between pb-5">
                    <h2 class="room-title">Phòng {{ $room->id }} @if($room->startday != "") (Phòng đã được đặt) @endif</h2>
                    <h2 class="room-price"> {{ number_format($room->price, 0, ',', '.') }} VNĐ <span>/ Đêm </span></h2>
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
            <div class="col-12 col-lg-8">
                <div class="single-room-details-area mb-50">
                    <div class="room-thumbnail-slides mb-50">
                        <div id="room-thumbnail--slide" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @if (is_array($room->image) && count($room->image) > 0)
                                    @foreach ($room->image as $k => $img)
                                        <div class="carousel-item {{ $k == 0 ? 'active' : '' }}">
                                            <img src="{{ url('room_images/'. $img) }}" class="d-block w-100" alt="">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="carousel-item active">
                                        <img src="{{ url('room_images/default.jpg') }}" class="d-block w-100" alt="Không có ảnh">
                                    </div>
                                @endif
                            </div>

                            <ol class="carousel-indicators">
                                @if (is_array($room->image) && count($room->image) > 0)
                                    @foreach ($room->image as $k => $img)
                                        <li data-target="#room-thumbnail--slide" data-slide-to="{{ $k }}" class="{{ $k == 0 ? 'active' : '' }}">
                                            <img src="{{ url('room_images/'. $img) }}" class="d-block w-100" alt="">
                                        </li>
                                    @endforeach
                                @endif
                            </ol>
                        </div>
                    </div>

                    <div class="room-features-area d-flex flex-wrap mb-50 justify-content-center">
                        <h6>Loại phòng: <span>{{ $room->type }}</span></h6>
                        <h6>Dịch vụ: <span>Có điều hoà, Wifi không giới hạn, Truyền hình cáp...</span></h6>
                    </div>

                    <p>Nếu bạn đang tìm kiếm một nơi nghỉ ngơi thoải mái và tiện nghi trong thành phố, chúng tôi có thể giúp bạn. Trang web cho thuê phòng của chúng tôi cung cấp nhiều lựa chọn phòng ở khác nhau. Với dịch vụ của chúng tôi, bạn sẽ dễ dàng tìm được nơi ở phù hợp với nhu cầu và ngân sách của mình.</p>

                    <ul>
                        <li><i class="fa fa-check"></i> Đa dạng lựa chọn phòng với nhiều mức giá khác nhau.</li>
                        <li><i class="fa fa-check"></i> Tiện nghi hiện đại và không gian thoải mái.</li>
                        <li><i class="fa fa-check"></i> Vị trí thuận tiện gần các điểm du lịch và dịch vụ.</li>
                        <li><i class="fa fa-check"></i> Dịch vụ chăm sóc khách hàng tận tình và chu đáo.</li>
                        <li><i class="fa fa-check"></i> Quy trình đặt phòng nhanh chóng và dễ dàng.</li>
                        <li><i class="fa fa-check"></i> Chính sách hủy phòng linh hoạt và rõ ràng.</li>
                    </ul>

                    <p>Chúng tôi hiểu rằng việc tìm kiếm một nơi lưu trú thoải mái có thể là một thách thức, đặc biệt là khi bạn không quen thuộc với khu vực. Hãy để chúng tôi giúp bạn dễ dàng tìm được phòng ở lý tưởng mà không phải lo lắng về chất lượng dịch vụ. Với nhiều năm kinh nghiệm trong ngành, chúng tôi cam kết mang đến cho bạn trải nghiệm nghỉ dưỡng tốt nhất.</p>
                </div>

                <div class="room-service mb-50">
                    <h4>Dịch vụ phòng</h4>

                    <ul>
                        <li><img src="{{ url('main/img/core-img/icon1.png') }}" alt=""> Có điều hoà</li>
                        <li><img src="{{ url('main/img/core-img/icon4.png') }}" alt=""> Truyền hình cáp</li>
                        <li><img src="{{ url('main/img/core-img/icon5.png') }}" alt=""> Wifi không giới hạn</li>
                        <li><img src="{{ url('main/img/core-img/icon6.png') }}" alt=""> Dịch vụ 24/24</li>
                    </ul>
                </div>

                <div class="room-review-area mb-100">
                    <h4>Đánh giá phòng</h4>
                    @if(isset($reviews) && count($reviews) > 0)
                    @foreach ($reviews as $review)
                    <div class="single-room-review-area d-flex align-items-center">
                        <div class="reviwer-thumbnail">
                            <img style="width: 70px; height: 70px; object-fit: cover" src="{{url('avatar_image/'.$review->avatar)}}" alt="">
                        </div>
                        <div class="reviwer-content">
                            <div class="reviwer-title-rating d-flex align-items-center justify-content-between">
                                <div class="reviwer-title mr-2">
                                    <span>{{ Carbon\Carbon::parse($review->created_at)->format('d \t\há\n\g m \nă\m Y') }}</span>
                                    <h6>{{ $review->fullname }}</h6>
                                </div>
                                <div class="reviwer-rating ml-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p>{{ $review->content }}</p>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p>Chưa có đánh giá nào</p>
                    @endif

                    <form class="mt-3" action="{{ url('review/' . $room->id) }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-10">
                                <label for="review">Đánh giá của bạn</label>
                                <textarea class="form-control" name="review" id="review" rows="5" placeholder="Đánh giá của bạn"></textarea>
                                <button type="button" class="btn btn-light emoji-toggle" id="emoji-toggle">
                                    <i class="fa fa-smile"></i>
                                </button>
                                <emoji-picker></emoji-picker>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="rating">Đánh giá</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="1">1 sao</option>
                                    <option value="2">2 sao</option>
                                    <option value="3">3 sao</option>
                                    <option value="4">4 sao</option>
                                    <option value="5">5 sao</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn roberto-btn mt-15">Gửi đánh giá</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="hotel-reservation--area mb-100">
                    <form action="{{ url('hotel/room/'. $room->id) }}" method="post">
                        @csrf
                        <div class="form-group mb-30">
                            <label for="checkInDate">Ngày</label>
                            <div class="row no-gutters">
                                <div class="col-6">
                                    <div class="input-daterange" id="datepicker">
                                        <input type="text" class="input-small form-control" value="{{ old('checkIn') ?? Request::get('checkIn') }}" name="checkIn" id="checkInDate" placeholder="Ngày nhận phòng" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-daterange" id="datepicker">
                                        <input type="text" class="input-small form-control" value="{{ old('checkOut') ?? Request::get('checkOut') }}" name="checkOut" placeholder="Ngày trả phòng" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-30">
                            <label for="guests">Khách</label>
                            <div class="row">
                                <div class="col-6">
                                    <select name="adults" id="adults" class="form-control">
                                        <option value="0">Người lớn</option>
                                        <option value="1">01</option>
                                        <option value="2">02</option>
                                        <option value="3">03</option>
                                        <option value="4">04</option>
                                        <option value="5">05</option>
                                        <option value="6">06</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="children" id="children" class="form-control">
                                        <option value="0">Trẻ em</option>
                                        <option value="1">01</option>
                                        <option value="2">02</option>
                                        <option value="3">03</option>
                                        <option value="4">04</option>
                                        <option value="5">05</option>
                                        <option value="6">06</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn roberto-btn w-100" @if($room->startday != "") disabled @endif>Đặt phòng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="module">
    import 'https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/picker.js'
    import 'https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/database.js'

    document.addEventListener('DOMContentLoaded', () => {
        const emojiPicker = document.querySelector('emoji-picker');
        const emojiToggle = document.getElementById('emoji-toggle');
        const textarea = document.getElementById('review');

        // Hiển thị emoji-picker khi nhấn nút
        emojiToggle.addEventListener('click', (event) => {
            event.stopPropagation(); // Ngăn không cho sự kiện nhấp chuột lan ra ngoài
            emojiPicker.style.display = emojiPicker.style.display === 'none' || emojiPicker.style.display === '' ? 'block' : 'none';
        });

        // Thêm emoji vào textarea khi chọn
        emojiPicker.addEventListener('emoji-click', (event) => {
            const cursorPos = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos, textarea.value.length);
            textarea.value = textBefore + event.detail.unicode + textAfter;
            textarea.selectionStart = cursorPos + event.detail.unicode.length;
            textarea.selectionEnd = cursorPos + event.detail.unicode.length;
            textarea.focus();
        });

        // Ẩn emoji-picker khi nhấp ra ngoài
        document.addEventListener('click', (event) => {
            if (!emojiPicker.contains(event.target) && event.target !== emojiToggle) {
                emojiPicker.style.display = 'none';
            }
        });
    });
</script>
@endsection
