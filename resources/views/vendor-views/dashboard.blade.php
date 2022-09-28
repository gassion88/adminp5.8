@extends('layouts.vendor.app')

@section('title',__('messages.dashboard'))


@section('content')
    <div class="content container-fluid">
        @if(auth('vendor')->check())
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="page-header-title my-1">
                    <div class="card-header-icon d-inline-flex mr-2 img">
                        <img src="{{asset('/public/assets/admin/img/resturant-panel/page-title/dashboard.png')}}" alt="public">
                    </div>
                    <span>
                        {{__('messages.dashboard')}}
                    </span>
                </h1>
                <span class="my-2 text--title d-block">
                    {{__('messages.followup')}}
                    <i class="tio-restaurant fz-30px"></i>
                </span>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-header-title">
                    <span class="card-header-icon">
                        <i class="tio-chart-bar-4"></i>
                    </span>
                    {{__('messages.dashboard_order_statistics')}}
                </h4>
                <div>
                <a class="btn btn-sm btn--primary w-100 mb-3" onclick="get_delivery_man('https://hvarna.ru/vendor-panel/?&number=')"
                 href="javascript:">Вызвать курьера</a>
                    <select class="custom-select my-1" name="statistics_type" onchange="order_stats_update(this.value)">
                        <option
                            value="overall" {{$params['statistics_type'] == 'overall'?'selected':''}}>
                            {{__('messages.Overall Statistics')}}
                        </option>
                        <option
                            value="today" {{$params['statistics_type'] == 'today'?'selected':''}}>
                            {{__("messages.Today's Statistics")}}
                        </option>
                        <option
                            value="this_month" {{$params['statistics_type'] == 'this_month'?'selected':''}}>
                            {{__("messages.This Month's Statistics")}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2" id="order_stats">
                    @include('vendor-views.partials._dashboard-order-stats',['data'=>$data])
                </div>
            </div>
        </div>

        <div class="row gx-2 gx-lg-3">
            <div class="col-lg-12 mb-3 mb-lg-12">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-header flex-wrap justify-content-evenly justify-content-lg-between border-0">
                        <h4 class="card-title my-2 my-md-0">
                            <i class="tio-chart-bar-4"></i>
                            {{__('messages.yearly_statistics')}}
                        </h4>
                        <div class="d-flex flex-wrap my-2 my-md-0 justify-content-center align-items-center">
                            @php($amount=array_sum($earning))
                            <span class="h5 m-0 mr-3 fz--11 d-flex align-items-center mb-2 mb-md-0">
                                <span class="legend-indicator bg-primary" style="background-color: #7ECAFF!important;"></span>
                                {{__('messages.commission_given')}} : {{\App\CentralLogics\Helpers::format_currency(array_sum($commission))}}
                            </span>
                            <span class="h5 m-0 fz--11 d-flex align-items-center mb-2 mb-md-0">
                                <span class="legend-indicator bg-primary" style="background-color: #0661CB!important;"></span>
                                {{__('messages.total_earning')}} : {{\App\CentralLogics\Helpers::format_currency(array_sum($earning))}}
                            </span>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="card-body">

                        <!-- Bar Chart -->
                        <div class="d-flex align-items-center">
                            <div class="chart--extension">
                              {{ \App\CentralLogics\Helpers::currency_symbol() }}({{translate('messages.currency')}})
                            </div>
                            <div class="chartjs-custom w-75 flex-grow-1">
                                <canvas id="updatingData" style="height: 20rem;"
                                            data-hs-chartjs-options='{
                                    "type": "bar",
                                    "data": {
                                    "labels": ["Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                                    "datasets": [{
                                        "data": [{{$earning[1]}},{{$earning[2]}},{{$earning[3]}},{{$earning[4]}},{{$earning[5]}},{{$earning[6]}},{{$earning[7]}},{{$earning[8]}},{{$earning[9]}},{{$earning[10]}},{{$earning[11]}},{{$earning[12]}}],
                                        "backgroundColor": "#7ECAFF",
                                        "hoverBackgroundColor": "#7ECAFF",
                                        "borderColor": "#7ECAFF"
                                    },
                                    {
                                        "data": [{{$commission[1]}},{{$commission[2]}},{{$commission[3]}},{{$commission[4]}},{{$commission[5]}},{{$commission[6]}},{{$commission[7]}},{{$commission[8]}},{{$commission[9]}},{{$commission[10]}},{{$commission[11]}},{{$commission[12]}}],
                                        "backgroundColor": "#0661CB",
                                        "borderColor": "#0661CB"
                                    }]
                                    },
                                    "options": {
                                    "scales": {
                                        "yAxes": [{
                                        "gridLines": {
                                            "color": "#e7eaf3",
                                            "drawBorder": false,
                                            "zeroLineColor": "#e7eaf3"
                                        },
                                        "ticks": {
                                            "beginAtZero": true,
                                            "stepSize": {{ceil($amount/10000)*2000}},
                                            "fontSize": 12,
                                            "fontColor": "#97a4af",
                                            "fontFamily": "Open Sans, sans-serif",
                                            "padding": 10
                                        }
                                        }],
                                        "xAxes": [{
                                        "gridLines": {
                                            "display": false,
                                            "drawBorder": false
                                        },
                                        "ticks": {
                                            "fontSize": 12,
                                            "fontColor": "#97a4af",
                                            "fontFamily": "Open Sans, sans-serif",
                                            "padding": 5
                                        },
                                        "categoryPercentage": 0.3,
                                        "maxBarThickness": "10"
                                        }]
                                    },
                                    "cornerRadius": 5,
                                    "tooltips": {
                                        "prefix": " ",
                                        "hasIndicator": true,
                                        "mode": "index",
                                        "intersect": false
                                    },
                                    "hover": {
                                        "mode": "nearest",
                                        "intersect": true
                                    }
                                    }
                                }'></canvas>
                            </div>
                        </div>
                        <!-- End Bar Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6 mt-3">
                <!-- Card -->
                <div class="card h-100" id="top-selling-foods-view">
                    @include('vendor-views.partials._top-selling-foods',['top_sell'=>$data['top_sell']])
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6 mt-3">
                <!-- Card -->
                <div class="card h-100" id="top-rated-foods-view">
                    @include('vendor-views.partials._most-rated-foods',['most_rated_foods'=>$data['most_rated_foods']])
                </div>
                <!-- End Card -->
            </div>


        </div>
        <!-- End Row -->
        @else
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{__('messages.welcome')}}, {{auth('vendor_employee')->user()->f_name}}.</h1>
                    <p class="page-header-text">{{__('messages.employee_welcome_message')}}</p>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        @endif
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/admin')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{asset('public/assets/admin')}}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script
        src="{{asset('public/assets/admin')}}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
@endpush


@push('script_2')
    <script>
        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));
    </script>

    <script>
        function get_delivery_man(route){
            Swal.fire({
                    //text: message,
                    title: 'Введите номер телефона клиента',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: 'Отмена',
                    confirmButtonText: 'Вызвать курьера',
                    inputPlaceholder: "Номер мобильного телефона",
                    input: 'text',
                    inputValidator: (value) => {
                    if (!value) {
                    return 'Вы не указали номер мобильного телефона клиента!'
                    }
                },
                    preConfirm: (number) => {
                        location.href = route + number;
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
        }

        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('vendor.dashboard.order-stats')}}',
                data: {
                    statistics_type: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('statistics_type',type);
                    $('#order_stats').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }
    </script>

    <script>
        function insert_param(key, value) {
            key = encodeURIComponent(key);
            value = encodeURIComponent(value);
            // kvp looks like ['key1=value1', 'key2=value2', ...]
            var kvp = document.location.search.substr(1).split('&');
            let i = 0;

            for (; i < kvp.length; i++) {
                if (kvp[i].startsWith(key + '=')) {
                    let pair = kvp[i].split('=');
                    pair[1] = value;
                    kvp[i] = pair.join('=');
                    break;
                }
            }
            if (i >= kvp.length) {
                kvp[kvp.length] = [key, value].join('=');
            }
            // can return this or...
            let params = kvp.join('&');
            // change url page with new params
            window.history.pushState('page2', 'Title', '{{url()->current()}}?' + params);
        }
    </script>
@endpush
