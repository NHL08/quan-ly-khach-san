@extends('back.template.master')
@section('title', 'Quản lý khách hàng')
@section('userlist', 'active')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Danh sách khách hàng</h2>
            {{-- <a class="btn btn-primary m-2 mb-3" href="{{url('admin/staff/add')}}" title="Thêm">Thêm</a> --}}
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
                                        <th style="cursor: pointer">STT</th>
                                        <th style="cursor: pointer">Họ và tên</th>
                                        <th style="cursor: pointer">Địa chỉ</th>
                                        <th style="cursor: pointer">Số điện thoại</th>
                                        <th style="cursor: pointer">Chức vụ</th>
                                        <th style="cursor: pointer">Email</th>
                                        @if(isset(Auth::user()->role) && Auth::user()->role >= 3)
                                        <th class="text-center"><i class="fa-solid fa-wrench"></i></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($User) && count($User) > 0)
                                    @foreach($User as $k => $v)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $v->fullname }}</td>
                                        <td>{{ $v->address }}</td>
                                        <td>{{ $v->phone }}</td>
                                        <td>{{ $v->name }}</td>
                                        <td>{{ $v->email }}</td>
                                        @if(isset(Auth::user()->role) && Auth::user()->role >= 3)
                                        <td class="text-center">
                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Hành động</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{url('admin/staff/edit/'.$v->id)}}">Chỉnh sửa</a>
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
