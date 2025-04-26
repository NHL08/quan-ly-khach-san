@extends('back.template.master')
@section('title', 'Quản lý phòng')
@section('roomlist', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Thuê phòng {{ $roomId }}</h2>
        @if(Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
            {!! Session::get('flash_message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ url('admin/room/checkin/' . $roomId) }}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date-input1">Ngày ở</label>
                            <input type="text" name="datetimes" class="form-control datetimes" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user" class="form-label">Người thuê</label>
                            <select class="form-control" name="user">
                                <option value="10000">
                                    Khách ngoài
                                </option>
                                @if (isset($User) && count($User) > 0)
                                @foreach($User as $k => $v)
                                <option value="{{$v->id}}">
                                    {{$v->fullname}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="adults" class="form-label">Người lớn <strong style="color: red">*</strong></label>
                            <input type="number" class="form-control" name="adults" autocomplete="off" value="0">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="children" class="form-label">Trẻ em <strong style="color: red">*</strong></label>
                            <input type="number" class="form-control" name="children" autocomplete="off" value="0">
                        </div>
                    </div>
                    <a href="{{ url('admin/room/list') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary">Thuê</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
