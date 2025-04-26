@extends('back.template.master')
@section('title', 'Quản lý loại phòng')
@section('typeroomlist', 'active')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Danh sách loại phòng</h2>
            @if(isset(Auth::user()->role) && Auth::user()->role >= 3)
            <a class="btn btn-primary m-2 mb-3" href="{{url('admin/typeroom/add')}}" title="Thêm">Thêm</a>
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
                                        <th>STT</th>
                                        <th>Loại phòng</th>
                                        <th>Số phòng hiện có</th>
                                        <th>Giá</th>
                                        @if(isset(Auth::user()->role) && Auth::user()->role >= 3)
                                        <th class="text-center"><i class="fa-solid fa-wrench"></i></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($RoomType) && count($RoomType) > 0)
                                    @foreach($RoomType as $k => $v)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $v->name }}</td>
                                        <td>{{ isset($roomCounts[$v->id]) ? $roomCounts[$v->id] : 0 }}</td>
                                        <td>{{ number_format($v->price, 0, ',', '.') }}</td>
                                        @if(isset(Auth::user()->role) && Auth::user()->role >= 3)
                                        <td class="text-center">
                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Hành động</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{url('admin/typeroom/delete/'.$v->id)}}">Xoá</a>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
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
