@extends('back.template.master')
@section('title', "Quản lý người dùng")
@section('userlist', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Chỉnh sửa hồ sơ của {{ $User->fullname }}</h2>
        @if(Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
            {!!Session::get('flash_message')!!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @elseif($errors->first('email'))
        <div class="alert alert-danger" role="alert">
            {{__('admin/stafflist.error.email')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{url('admin/staff/edit/'.$User->id)}}" method="post">
                    <div class="row mt-5 align-items-center">
                        <div class="col-md-3 text-center mb-5">
                            <div class="avatar avatar-xl">
                                <img src="{{url($User->avatar)}}" alt="..." style="width: 128px; height: 128px; object-fit: cover;" class="avatar-img rounded-circle">
                            </div>
                        </div>
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <h4 class="mb-1">{{$User->fullname}}</h4>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col">
                                    <p class="small mb-0 text-muted">{{$User->email}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    {!! csrf_field() !!}
                    <div class="form-group mb-3">
                        <label for="level" class="form-label">Chức vụ</label>
                        <select class="form-control" name="level">
                            @if (isset($UserLevel) && count($UserLevel) > 0)
                            @foreach($UserLevel as $k => $v)
                            @if($v->id <= Auth::user()->role)
                            <option value="{{$v->id}}" @if($v->id == $User->role) selected="" @endif>
                                {{$v->name}}
                            </option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <a href="{{url('admin/staff/list')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
