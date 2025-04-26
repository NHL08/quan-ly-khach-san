@extends('back.template.master')
@section('title', 'Quản lý phòng')
@section('roomlist', 'active')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center my-3">
                <div class="col">
                    <h2 class="page-title">Danh sách phòng</h2>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#findDayModal"><i class="fa-solid fa-magnifying-glass mr-3"></i>Tìm ngày</button>
                </div>
            </div>
            <div class="modal fade" id="findDayModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="varyModalLabel">Tìm ngày</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form method="GET" action="{{ url('admin/room/list/find') }}">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="date-input1">Chọn ngày <span style="color: red">* </span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
                                            </div>
                                            <input autocomplete="off" type="text" class="form-control drgpicker" id="drgpicker-start" name="datestart">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn mb-2 btn-primary">Tìm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if (isset(Auth::user()->role) && Auth::user()->role >= 3)
            <a class="btn btn-primary m-2 mb-3" href="{{url('admin/room/add')}}" title="Thêm">Thêm</a>
            @endif
            @if(Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
                {!!Session::get('flash_message')!!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>Mã phòng</th>
                                        <th>Loại phòng</th>
                                        <th>Dịch vụ</th>
                                        <th>Giá phòng</th>
                                        <th>Ngày nhận phòng</th>
                                        <th>Ngày trả phòng</th>
                                        <th>Tình trạng phòng</th>
                                        <th class="text-center"><i class="fa-solid fa-wrench"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($rooms) && count($rooms) > 0)
                                    @foreach($rooms as $room)
                                    <tr>
                                        <td>{{ $room->id }}</td>
                                        <td>{{ $room->type }}</td>
                                        <td>{{ $room->service }}</td>
                                        <td>
                                            {{ number_format($room->price, 0, ',', '.') }}
                                            @if(!empty($room->rented_days) && $room->rented_days > 0)
                                                ({{ $room->rented_days }} ngày)
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($room->startday))
                                                {{ $room->startday }}
                                            @else
                                                (Chưa thuê)
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($room->endday_formatted))
                                                {{ $room->endday_formatted }}
                                                @if($room->isPast2PM)
                                                    (Chưa trả)
                                                @endif
                                            @else
                                                (Chưa thuê)
                                            @endif
                                        </td>

                                        <td>
                                            {{ $room->status == 1 ? 'Đang thuê' : 'Trống' }}
                                            @if ($room->deposited == 1)
                                                (Đã cọc)
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Hành động</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(isset($room->status) && $room->status == 1)
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#infoRoom_{{ $room->id }}">Thông tin phòng</a>
                                                    <a class="dropdown-item" href="{{url('admin/room/service/'.$room->id)}}">Dịch vụ</a>
                                                    <a class="dropdown-item" href="{{url('admin/room/checkout/'.$room->id)}}">Trả phòng</a>
                                                    @if (isset(Auth::user()->role) && Auth::user()->role >= 3)
                                                        <a class="dropdown-item" href="{{url('admin/room/edit/'.$room->id)}}">Chỉnh sửa</a>
                                                    @endif
                                                @else
                                                    <a class="dropdown-item" href="{{url('admin/room/checkin/'.$room->id)}}">Thuê phòng</a>
                                                    @if (isset(Auth::user()->role) && Auth::user()->role >= 3)
                                                        <a class="dropdown-item" href="{{url('admin/room/edit/'.$room->id)}}">Chỉnh sửa</a>
                                                        <a class="dropdown-item" href="{{url('admin/room/delete/'.$room->id)}}">Xoá</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="infoRoom_{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="varyModalLabel">Thông tin phòng {{ $room->id }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            @if($room->user_id == 10000)
                                                                <label for="date-input1">Người đặt phòng: Khách ngoại (Người lớn: {{ $room->adults }} | Trẻ em: {{ $room->children }})</label>
                                                            @else
                                                                <label for="date-input1">Người đặt phòng: {{ $room->fullname }} (Người lớn: {{ $room->adults }} | Trẻ em: {{ $room->children }})</label>
                                                            @endif
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="date-input1">
                                                                Thuê
                                                                @if(!empty($room->rented_days) && $room->rented_days > 0)
                                                                    {{ $room->rented_days }} ngày
                                                                @endif
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="date-input1">
                                                                Ngày đặt phòng: {{ $room->startday }}
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="date-input1">
                                                                Ngày trả phòng:
                                                                @if(!empty($room->endday_formatted))
                                                                    {{ $room->endday_formatted }}
                                                                    @if($room->isPast2PM)
                                                                        (Chưa trả)
                                                                    @endif
                                                                @else
                                                                    (Chưa thuê)
                                                                @endif
                                                            </label>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="date-input1">Ghi chú: {{ $room->note }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <button type="submit" class="btn mb-2 btn-secondary" data-dismiss="modal" aria-label="Close">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
