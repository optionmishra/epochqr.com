@extends('layouts.dashboard')

@section('styles')
    @parent
    <link href="{{ asset('tracklead/css/index.css') }}" rel="stylesheet">
    <style>
        #sales-analytics-chart .apexcharts-canvas {
            width: 100%;
        }

    </style>
@endsection

@section('pageTitle')
    <a href="#" class="nav-link">Dashboard</a>
@endsection

@section('content')
    <div class="row m-0">

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-shadow">
                <div class="inner">
                    <p class="f1 mb-2 text-black">Total Users</p>
                    <h5 class="mb-0 text-right">
                        <i class="las la-users float-left" style="font-size:30px;"></i>
                        <span>{{ $total_users }}</span>
                    </h5>
                    {{-- <p class="text-black mb-1 f1 text-right">
          <span class="float-left">Today Clicks</span>
          <span>100</span>
        </p> --}}
                </div>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-shadow">
                <div class="inner">
                    <p class="f1 mb-2 text-black">Total Projects</p>
                    <h5 class="mb-0 text-right">
                        <i class="las la-folder float-left"></i>
                        <span>{{ $total_projects }}</span>
                    </h5>
                    {{-- <p class="f1 mb-1 text-right text-black">
                        <span class="float-left">Today Conversion</span>
                        <span>100</span>
                    </p> --}}
                </div>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-shadow">
                <div class="inner">
                    <p class="f1 mb-2 text-black">Total Qrs</p>
                    <h5 class="mb-0 text-right">
                        <i class="las la-qrcode float-left"></i>
                        <span>{{ $total_qrs }}</span>
                    </h5>
                    {{-- <p class="f1 mb-1 text-right text-black">
                        <span class="float-left">Today Revenue</span>
                        <span>100</span>
                    </p> --}}
                </div>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-shadow">
                <div class="inner">
                    <p class="f1 mb-2 text-black">Total Clicks</p>
                    <h5 class="mb-0 text-right">
                        <i class="las la-mouse-pointer float-left"></i>
                        <span>{{ $total_clicks }}</span>
                    </h5>
                    {{-- <p class="f1 mb-1 text-right text-black">
                        <span class="float-left">This Month Balance</span>
                        <span>100</span>
                    </p> --}}
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <!-- / small-box -->

    {{-- <div class="row m-0">
        <div class="col-lg-12">
            <div class="card equalHeight-1 bg-shadow mb-4">
                <div class="card-body p-0">
                    <h5 class="card-title my-2 py-2 px-3">Total Orders(Last 10 days)
                    </h5>
                    <div class="mt-1">
                        <ul class="list-inline main-chart mb-0">
                            <li class="list-inline-item chart-border-left me-0 border-0">
                                <h3 class="text-primary">$<span data-plugin="counterup">2,371</span><span
                                        class="text-muted d-inline-block font-size-15 ml-3">Income</span></h3>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h3><span data-plugin="counterup">258</span><span
                                        class="text-muted d-inline-block font-size-15 ml-3">Sales</span>
                                </h3>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h3><span data-plugin="counterup">3.6</span>%<span
                                        class="text-muted d-inline-block font-size-15 ml-3">Conversation Ratio</span></h3>
                            </li>
                        </ul>
                    </div>
                    <div id="sales-analytics-chart"></div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('tracklead/apexchart/apexcharts.min.js') }}"></script>
    <script>
        //
        $(function() {
            var loc = window.location.href; // returns the full URL

            console.log(loc);

            if (/dashboard/.test(loc)) {
                $('.sidebar-mini').removeClass('sidebar-collapse');

                console.log('yes');
            }
        });

        options = {
            chart: {
                height: 295,
                type: "line",
                stacked: !1,
                toolbar: {
                    show: !1
                }
            },
            stroke: {
                width: [0, 2, 4],
                curve: "smooth"
            },
            plotOptions: {
                bar: {
                    columnWidth: "30%"
                }
            },
            colors: ["#5b73e8", "#dfe2e6", "#f1b44c"],
            series: [{
                name: "Desktops",
                type: "column",
                data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
            }, {
                name: "Laptops",
                type: "area",
                data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
            }, {
                name: "Tablets",
                type: "line",
                data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
            }],
            fill: {
                opacity: [.85, .25, 1],
                gradient: {
                    inverseColors: !1,
                    shade: "light",
                    type: "vertical",
                    opacityFrom: .85,
                    opacityTo: .55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: ["01/01/2003", "02/01/2003", "03/01/2003", "04/01/2003", "05/01/2003", "06/01/2003", "07/01/2003",
                "08/01/2003", "09/01/2003", "10/01/2003", "11/01/2003"
            ],
            markers: {
                size: 0
            },
            xaxis: {
                type: "datetime"
            },
            yaxis: {
                title: {
                    text: "Points"
                }
            },
            tooltip: {
                shared: !0,
                intersect: !1,
                y: {
                    formatter: function(e) {
                        return void 0 !== e ? e.toFixed(0) + " points" : e
                    }
                }
            },
            grid: {
                borderColor: "#f1f1f1"
            }
        };
        (chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options)).render();
    </script>
@endsection
