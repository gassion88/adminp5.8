@extends('layouts.admin.app')

@section('title',$restaurant->name)

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
    <style>
        .flex-item{
            padding: 10px;
            flex: 20%;
        }

        /* Responsive layout - makes a one column-layout instead of a two-column layout */
        @media (max-width: 768px) {
            .flex-item{
                flex: 50%;
            }
        }

        @media (max-width: 480px) {
            .flex-item{
                flex: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <h1 class="page-header-title text-break">
                <i class="tio-museum"></i> <span>{{$restaurant->name}}</span>
            </h1>
        </div>
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-left"></i>
                </a>
            </span>

            <span class="hs-nav-scroller-arrow-next" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-right"></i>
                </a>
            </span>

            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', $restaurant->id)}}">{{__('messages.overview')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'order'])}}"  aria-disabled="true">{{__('messages.orders')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'product'])}}"  aria-disabled="true">{{__('messages.foods')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'reviews'])}}"  aria-disabled="true">{{__('messages.reviews')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'discount'])}}"  aria-disabled="true">{{__('discounts')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'transaction'])}}"  aria-disabled="true">{{__('messages.transactions')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'settings'])}}"  aria-disabled="true">{{__('messages.settings')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'conversations'])}}"  aria-disabled="true">{{__('messages.conversations')}}</a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
    </div>
    <!-- End Page Header -->
    <div class="card">
        <!-- Nav -->
        <div class="card-header border-0 py-2">
            <div class="search--button-wrapper">
                <ul class="nav nav-tabs mr-auto transaction--table-nav">
                    <li class="nav-item">
                        @php($account_transaction = \App\Models\AccountTransaction::where('from_type', 'restaurant')->where('from_id', $restaurant->id)->count())
                        @php($account_transaction = isset($account_transaction) ? $account_transaction : 0)
                        <a class="nav-link text-capitalize {{$sub_tab=='cash'?'active':''}}" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'transaction', 'sub_tab'=>'cash'])}}"  aria-disabled="true">
                            {{translate('messages.cash_collected_by_admin')}} ({{$account_transaction}})
                        </a>
                    </li>
                    <li class="nav-item">
                        @php($digital_transaction = \App\Models\OrderTransaction::where('vendor_id', $restaurant->id)->count())
                        @php($digital_transaction = isset($digital_transaction) ? $digital_transaction : 0)
                        <a class="nav-link text-capitalize {{$sub_tab=='digital'?'active':''}}" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'transaction', 'sub_tab'=>'digital'])}}"  aria-disabled="true">
                            {{translate('messages.order_collected_by_admin')}} ({{$digital_transaction}})
                        </a>
                    </li>
                    <li class="nav-item">
                        @php($withdraw_transaction = \App\Models\WithdrawRequest::where('vendor_id',$restaurant->id)->count())
                        @php($withdraw_transaction = isset($withdraw_transaction) ? $withdraw_transaction : 0)
                        <a class="nav-link text-capitalize {{$sub_tab=='withdraw'?'active':''}}" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'transaction', 'sub_tab'=>'withdraw'])}}"  aria-disabled="true">
                            {{translate('messages.withdraws')}} ({{$withdraw_transaction}})
                        </a>
                    </li>
                </ul>
                <!-- Export Button Static -->
                <div class="hs-unfold ml-3 mr-3">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn btn-outline-primary btn--primary font--sm" href="javascript:;"
                    data-hs-unfold-options='{
                        "target": "#usersExportDropdown",
                        "type": "css-animation"
                    }'>
                    <i class="tio-download-to mr-1"></i> {{__('messages.export')}}
                </a>
                    @if($sub_tab=='cash')
                    <div id="usersExportDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header">{{__('messages.download')}} {{__('messages.options')}}</span>
                        <a id="export-excel" class="dropdown-item" href="{{route('admin.vendor.cash-transaction-export', ['restaurant'=>$restaurant->id,'type'=>'excel'])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/excel.svg"
                                    alt="Image Description">
                            {{__('messages.excel')}}
                        </a>
                        <a id="export-csv" class="dropdown-item" href="{{route('admin.vendor.cash-transaction-export', ['restaurant'=>$restaurant->id,'type'=>'csv'])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                            .{{__('messages.csv')}}
                        </a>
                    </div>
                    @elseif ($sub_tab=='digital')
                    <div id="usersExportDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header">{{__('messages.download')}} {{__('messages.options')}}</span>
                        <a id="export-excel" class="dropdown-item" href="{{route('admin.vendor.digital-transaction-export', ['restaurant'=>$restaurant->vendor->id,'type'=>'excel'])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/excel.svg"
                                    alt="Image Description">
                            {{__('messages.excel')}}
                        </a>
                        <a id="export-csv" class="dropdown-item" href="{{route('admin.vendor.digital-transaction-export', ['restaurant'=>$restaurant->vendor->id,'type'=>'csv'])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                            .{{__('messages.csv')}}
                        </a>
                    </div>
                    @elseif ($sub_tab=='withdraw')
                    <div id="usersExportDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header">{{__('messages.download')}} {{__('messages.options')}}</span>
                        <a id="export-excel" class="dropdown-item" href="{{route('admin.vendor.withdraw-transaction-export', ['restaurant'=>$restaurant->vendor->id,'type'=>'excel'])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/excel.svg"
                                    alt="Image Description">
                            {{__('messages.excel')}}
                        </a>
                        <a id="export-csv" class="dropdown-item" href="{{route('admin.vendor.withdraw-transaction-export', ['restaurant'=>$restaurant->vendor->id,'type'=>'csv'])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                            .{{__('messages.csv')}}
                        </a>
                    </div>
                    @endif
                </div>
                <!-- Export Button Static -->
            </div>
        </div>
        <!-- End Nav -->

        <div class="card-body" style="padding: 0">
        @if($sub_tab=='cash')
            @include('admin-views.vendor.view.partials.cash_transaction')
        @elseif ($sub_tab=='digital')
            @include('admin-views.vendor.view.partials.digital_transaction')
        @elseif ($sub_tab=='withdraw')
            @include('admin-views.vendor.view.partials.withdraw_transaction')
        @endif

    </div>
</div>
@endsection

@push('script_2')
    <!-- Page level plugins -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&callback=initMap&v=3.45.8" ></script>
    <script>
        const myLatLng = { lat: {{$restaurant->latitude}}, lng: {{$restaurant->longitude}} };
        let map;
        initMap();
        function initMap() {
                 map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: myLatLng,
            });
            new google.maps.Marker({
                position: myLatLng,
                map,
                title: "{{$restaurant->name}}",
            });
        }
    </script>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
@endpush
