@extends('back.template.master')
@section('title', 'Quản lý dịch vụ')
@section('servicelist', 'active')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Danh sách dịch vụ</h2>
            <a class="btn btn-primary m-2 mb-3" href="{{url('admin/service/add')}}" title="Thêm">Thêm</a>
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
                                        <th>Tên dịch vụ</th>
                                        <th>Số lần sử dụng</th>
                                        <th>Giá</th>
                                        <th class="text-center"><i class="fa-solid fa-wrench"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($services) && count($services) > 0)
                                    @foreach($services as $service => $v)
                                    <tr>
                                        <td>{{ $service + 1 }}</td>
                                        <td>{{ $v->name }}</td>
                                        <td>{{ $v->usage_count }}</td>
                                        <td>{{ number_format($v->price, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Hành động</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{url('admin/service/edit/'.$v->id)}}">Chỉnh sửa</a>
                                                <a class="dropdown-item" href="{{url('admin/service/delete/'.$v->id)}}">Xoá</a>
                                            </div>
                                        </td>
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
