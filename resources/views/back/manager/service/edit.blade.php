@extends('back.template.master')
@section('title', "Quản lý dịch vụ")
@section('userlist', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Sửa giá dịch vụ {{ $Service->name }}</h2>
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
                <form action="{{url('admin/service/edit/'.$Service->id)}}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group mb-3">
                        <label for="custom-money">Giá tiền</label>
                        <input class="form-control input-money" id="custom-money" value="{{ $Service->price }}" type="text" name="price" autocomplete="off">
                    </div>
                    <a href="{{url('admin/service/list')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
