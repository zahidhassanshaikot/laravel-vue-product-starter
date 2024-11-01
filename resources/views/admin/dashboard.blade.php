@extends('admin.layouts.app')

@section('content')

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat ic-bg-dashboard-card text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <i class="fa fa-users bx-fade-right fa-2x pt-3"></i>
                            {{--                            <i class="mdi mdi-cube-outline bx-fade-right"></i>--}}
                            {{--                            <img src="assets/images/services-icon/01.png" alt="">--}}
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">{{__('Total User')}}</h5>
                        <h4 class="fw-medium font-size-24">{{ $total_user }}
                            {{--                            <i class="mdi mdi-arrow-up text-success ms-2"></i>--}}
                        </h4>
                        {{--                        <div class="mini-stat-label bg-success">--}}
                        {{--                            <p class="mb-0">+ 12%</p>--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="pt-2">
                        <div class="float-end">
                            <a href="{{ route('users.index') }}" class="text-white-50"><i
                                    class="mdi mdi-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">{{__('Total User In Application')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-blue-grey text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <i class="fa fa-list bx-fade-right fa-2x pt-3"></i>
                            {{--                            <i class="mdi mdi-cube-outline bx-fade-right"></i>--}}
                            {{--                            <img src="assets/images/services-icon/01.png" alt="">--}}
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">{{__('Total Role')}}</h5>
                        <h4 class="fw-medium font-size-24">{{ $total_role }}
                            {{--                            <i class="mdi mdi-arrow-up text-success ms-2"></i>--}}
                        </h4>
                        {{--                        <div class="mini-stat-label bg-success">--}}
                        {{--                            <p class="mb-0">+ 12%</p>--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="pt-2">
                        <div class="float-end">
                            <a href="{{ route('users.index') }}" class="text-white-50"><i
                                    class="mdi mdi-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">{{__('Total Role In Application')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
{{--                            <img src="assets/images/services-icon/03.png" alt="">--}}
                            <i class="fa fa-percent bx-fade-right fa-2x pt-3"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Average Price</h5>
                        <h4 class="fw-medium font-size-24">15.8 <i
                                class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                        <div class="mini-stat-label bg-info">
                            <p class="mb-0"> 00%</p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="float-end">
                            <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">Since last month</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-info text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <i class="fa fa-dollar-sign bx-fade-right fa-2x pt-3"></i>
{{--                            <img src="assets/images/services-icon/04.png" alt="">--}}
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Product Sold</h5>
                        <h4 class="fw-medium font-size-24">2436 <i
                                class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                        <div class="mini-stat-label bg-warning">
                            <p class="mb-0">+ 84%</p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="float-end">
                            <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                        </div>

                        <p class="text-white-50 mb-0 mt-1">Since last month</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">User Analysis</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">{{ $user_this_month }}</h5>
                                <p class="text-muted">This Month</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20"> {{ $user_last_six_month }}</h5>
                                <p class="text-muted">Last 6 Month</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">{{ $user_this_year }}</h5>
                                <p class="text-muted">This Year</p>
                            </div>
                        </div>
                    </div>

                    <canvas id="lineChart" height="300"></canvas>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Analysis</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">$ 1111</h5>
                                <p class="text-muted">This Month</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20"> $ 6666</h5>
                                <p class="text-muted">Last 6 Month</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">$ 9999</h5>
                                <p class="text-muted">This Year</p>
                            </div>
                        </div>
                    </div>

                    <canvas id="bar" height="300"></canvas>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@push('script')
    <!-- Chart JS -->
    <script src="{{ asset('libs/chart.js/Chart.bundle.min.js')}}"></script>
    {{--    <script src="{{ asset('js/pages/chartjs.init.js')}}"></script>--}}
    <script>
        !function (d) {
            "use strict";

            function r() {
            }

            r.prototype.respChart = function (r, o, e, a) {
                Chart.defaults.global.defaultFontColor = "#adb5bd", Chart.defaults.scale.gridLines.color = "rgba(108, 120, 151, 0.1)";
                var t = r.get(0).getContext("2d"), n = d(r).parent();

                function i() {
                    r.attr("width", d(n).width());
                    switch (o) {
                        case"Line":
                            new Chart(t, {type: "line", data: e, options: a});
                            break;
                        // case"Doughnut":
                        //     new Chart(t, {type: "doughnut", data: e, options: a});
                        //     break;
                        // case"Pie":
                        //     new Chart(t, {type: "pie", data: e, options: a});
                        //     break;
                        case"Bar":
                            new Chart(t, {type: "bar", data: e, options: a});
                            break;
                        // case"Radar":
                        //     new Chart(t, {type: "radar", data: e, options: a});
                        //     break;
                        // case"PolarArea":
                        //     new Chart(t, {data: e, type: "polarArea", options: a})
                    }
                }

                d(window).resize(i), i()
            }, r.prototype.init = function () {
                this.respChart(d("#lineChart"), "Line", {
                    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    datasets: [
                        {
                            label: "User Created",
                            type: "line",
                            fill: !0,
                            lineTension: .5,
                            backgroundColor: "rgba(60, 76, 207, 0.2)",
                            borderColor: "#3c4ccf",
                            borderCapStyle: "butt",
                            borderDash: [],
                            borderDashOffset: 0,
                            borderJoinStyle: "miter",
                            pointBorderColor: "#3c4ccf",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "#3c4ccf",
                            pointHoverBorderColor: "#fff",
                            pointHoverBorderWidth: 2,
                            pointRadius: 2,
                            pointStyle: 'circle',
                            pointHitRadius: 10,
                            data: @php echo json_encode($user_monthly_analytics) @endphp
                        },
                    //     {
                    //     label: "Monthly Earnings",
                    //     fill: !0,
                    //     lineTension: .5,
                    //     backgroundColor: "rgba(235, 239, 242, 0.2)",
                    //     borderColor: "#ebeff2",
                    //     borderCapStyle: "butt",
                    //     borderDash: [],
                    //     borderDashOffset: 0,
                    //     borderJoinStyle: "miter",
                    //     pointBorderColor: "#ebeff2",
                    //     pointBackgroundColor: "#fff",
                    //     pointBorderWidth: 1,
                    //     pointHoverRadius: 5,
                    //     pointHoverBackgroundColor: "#ebeff2",
                    //     pointHoverBorderColor: "#eef0f2",
                    //     pointHoverBorderWidth: 2,
                    //     pointRadius: 1,
                    //     pointHitRadius: 10,
                    //     data: [80, 23, 56, 65, 23, 35, 85, 25, 92, 36]
                    // }
                    ]
                },
                    // {scales: {yAxes: [{ticks: {max: 100, min: 20, stepSize: 10}}]}}
                );
                // this.respChart(d("#doughnut"), "Doughnut", {
                //     labels: ["Desktops", "Tablets"],
                //     datasets: [{
                //         data: [300, 210],
                //         backgroundColor: ["#3c4ccf", "#ebeff2"],
                //         hoverBackgroundColor: ["#3c4ccf", "#ebeff2"],
                //         hoverBorderColor: "#fff"
                //     }]
                // });
                // this.respChart(d("#pie"), "Pie", {
                //     labels: ["Desktops", "Tablets"],
                //     datasets: [{
                //         data: [300, 180],
                //         backgroundColor: ["#02a499", "#ebeff2"],
                //         hoverBackgroundColor: ["#02a499", "#ebeff2"],
                //         hoverBorderColor: "#fff"
                //     }]
                // });
                this.respChart(d("#bar"), "Bar", {
                    labels: ["January", "February", "March", "April", "May", "June", "July","August", "September", "October", "November", "December"],
                    datasets: [{
                        label: "Patient Created",
                        backgroundColor: "#02a499",
                        // backgroundColor: ["#02a499", "green","blue","orange","brown","purple","pink","yellow","red","black","grey","#52463FFF"],
                        borderColor: "#02a499",
                        borderWidth: 1,
                        hoverBackgroundColor: "#007a72",
                        hoverBorderColor: "#016b65",
                        data: [6500, 5900, 8000, 8100, 5600, 5500, 4000, 6500, 5900, 8000, 8100, 5600]
                    }]
                });
                // this.respChart(d("#radar"), "Radar", {
                //     labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
                //     datasets: [{
                //         label: "Desktops",
                //         backgroundColor: "rgba(2, 164, 153, 0.2)",
                //         borderColor: "#02a499",
                //         pointBackgroundColor: "#02a499",
                //         pointBorderColor: "#fff",
                //         pointHoverBackgroundColor: "#fff",
                //         pointHoverBorderColor: "#02a499",
                //         data: [65, 59, 90, 81, 56, 55, 40]
                //     }, {
                //         label: "Tablets",
                //         backgroundColor: "rgba(60, 76, 207, 0.2)",
                //         borderColor: "#3c4ccf",
                //         pointBackgroundColor: "#3c4ccf",
                //         pointBorderColor: "#fff",
                //         pointHoverBackgroundColor: "#fff",
                //         pointHoverBorderColor: "#3c4ccf",
                //         data: [28, 48, 40, 19, 96, 27, 100]
                //     }]
                // });
                // this.respChart(d("#polarArea"), "PolarArea", {
                //     datasets: [{
                //         data: [11, 16, 7, 18],
                //         backgroundColor: ["#38a4f8", "#02a499", "#ec4561", "#3c4ccf"],
                //         label: "My dataset",
                //         hoverBorderColor: "#fff"
                //     }], labels: ["Series 1", "Series 2", "Series 3", "Series 4"]
                // })
            }, d.ChartJs = new r, d.ChartJs.Constructor = r
        }(window.jQuery), function () {
            "use strict";
            window.jQuery.ChartJs.init()
        }();
    </script>
@endpush
