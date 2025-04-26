@extends('back.template.master')
@section('title', 'Quản lý loại phòng')
@section('typeroomlist', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Thêm loại phòng</h2>
        @if(Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
            {!!Session::get('flash_message')!!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{url('admin/typeroom/add')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Tên loại phòng <strong style="color: red">*</strong></label>
                        <input type="text" class="form-control" name="name" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label for="custom-money">Giá tiền <strong style="color: red">*</strong></label>
                        <input class="form-control input-money" id="custom-money" type="text" name="price" autocomplete="off">
                    </div>

                    <a href="{{url('admin/typeroom/list')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
