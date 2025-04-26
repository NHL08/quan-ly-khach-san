@extends('back.template.master')
@section('title', 'Quản lý phòng')
@section('roomlist', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Dịch vụ phòng {{ $Room->id }}</h2>
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
                <form action="{{ url('admin/room/service/' . $Room->id) }}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-row">
                        @foreach($allServices as $service)
                            <div class="form-group col-md-6">
                                <label for="service-{{ $service->id }}">{{ $service->name }}</label>
                                <input class="form-control" id="service-{{ $service->id }}" min="0" type="number" name="services[{{ $service->id }}]" value="{{ isset($selectedServiceQuantities[$service->id]) ? $selectedServiceQuantities[$service->id] : 0 }}">
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ url('admin/room/list') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
