@extends('back.template.master')
@section('title', 'Bảng thống kê')
@section('dashboard', 'active')
@section('style')
<style>
    .navbarScoll::-webkit-scrollbar {
        width: 4px;
    }

    .navbarScoll::-webkit-scrollbar-track {
        /* background: #f1f1f1; */
        background: transparent;
    }

    .navbarScoll::-webkit-scrollbar-thumb {
        background: linear-gradient(to top, #00aefd, #20e3b2);
        border-radius: 10px;
    }

    .navbarScoll::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to top, #00aefd, #20e3b2);
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title">Xin chào, {{Auth::user()->fullname}}!</h2>
                </div>
                <div class="col-auto">
                    <form class="form-inline" onsubmit="location.reload(); return false;">
                        <div class="form-group">
                            <button type="submit" title="Tải lại" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                        </div>
                    </form>
                </div>
            </div>
            @if(Session::has('flash_message'))
            <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
                {!!Session::get('flash_message')!!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="card-title">
                                <strong>Dịch vụ</strong>
                                {{-- <a class="float-right small text-muted" href="#!">Xem tất cả</a> --}}
                            </div>
                            <div class="row">
                                @if (!empty($serviceDetails))
                                <div class="col-md-12">
                                    <div id="chart-box">
                                        <div id="donutChartWidgetService"></div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12">
                                    @if (!empty($serviceDetails))
                                        @foreach ($serviceDetails as $service)
                                            <div class="row align-items-center my-3">
                                                <div class="col">
                                                    <strong>{{ $service['label'] }}</strong>
                                                </div>
                                                <div class="col-auto">
                                                    <strong>{{ number_format($service['series'], 0, ',', '.') }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <div class="progress" style="height: 4px;">
                                                        @php
                                                            $percentage = $totalUsageCount > 0 ? ($service['series'] / $totalUsageCount) * 100 : 0;
                                                            $percentage = min($percentage, 100);
                                                        @endphp
                                                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>Không có dữ liệu để hiển thị.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="py-5 text-center">
                                <p class="text-muted mb-2">Thời gian thực</p>
                                <h2 class="mb-1" id="real-time-clock"></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const donutChartWidgetService = document.querySelector("#donutChartWidgetService");

        const chart = new ApexCharts(donutChartWidgetService, {
            series: [@foreach ($serviceDetails as $service) {{ $service['series'] }} @if (!$loop->last),@endif @endforeach ],
            labels: [@foreach ($serviceDetails as $service) "{{ $service['label'] }}" @if (!$loop->last),@endif @endforeach ],
            chart: {
                type: "donut",
                height: 180,
                zoom: {
                    enabled: !1
                },
                toolbar: {
                    show: !1
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "40%",
                        background: "transparent"
                    },
                    expandOnClick: !1
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: "10px",
                    fontFamily: base.defaultFontFamily,
                    fontWeight: "300",
                    color: '#fff',
                }
            },
            legend: {
                show: !1
            },
            stroke: {
                show: !1,
                colors: extend.primaryColorLight,
                width: 1,
                dashArray: 0
            },
            fill: {
                opacity: 1,
                colors: ['#1b68ff', '#3ad29f', '#ffc107', '#ff5722', '#9c27b0', '#00bcd4', '#4caf50', '#ffeb3b', '#e91e63', '#673ab7']
            }
        });

        chart.render();
    });
</script>

<script>
    function updateTime() {
        const d = new Date();

        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();
        const hours = String(d.getHours()).padStart(2, '0');
        const minutes = String(d.getMinutes()).padStart(2, '0');
        const seconds = String(d.getSeconds()).padStart(2, '0');

        const formattedTime = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        document.getElementById('real-time-clock').innerHTML = formattedTime;
    }

    setInterval(updateTime, 1000);
    updateTime();
</script>

@stop
