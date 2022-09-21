@extends('layouts.admin.app')

@section('title',$restaurant->name."'s Foods")

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">

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
                    <a class="nav-link active" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'product'])}}"  aria-disabled="true">{{__('messages.foods')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'reviews'])}}"  aria-disabled="true">{{__('messages.reviews')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'discount'])}}"  aria-disabled="true">{{__('discounts')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'transaction'])}}"  aria-disabled="true">{{__('messages.transactions')}}</a>
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

    <!-- End Page Header -->

    <div class="resturant-card-navbar px-xl-4 justify-content-evenly">
        <div class="order-info-item">
            <div class="order-info-icon icon-sm">
                <img src="{{asset('/public/assets/admin/img/resturant/foods/all.png')}}" alt="public">
            </div>
                @php($food = \App\Models\Food::where(['restaurant_id'=>$restaurant->id])->count())
                @php($food = ($food == null) ? 0 : $food)
                <h6 class="card-subtitle">{{__('messages.all')}}<span class="amount text--primary">{{$food}}</span></h6>
        </div>
        <span class="order-info-seperator"></span>
        <div class="order-info-item">
            <div class="order-info-icon icon-sm">
                <img src="{{asset('/public/assets/admin/img/resturant/foods/active.png')}}" alt="public">
            </div>
                @php($food = \App\Models\Food::where(['restaurant_id'=>$restaurant->id, 'status'=>1])->count())
                @php($food = ($food == null) ? 0 : $food)
                <h6 class="card-subtitle">{{translate('Active Food')}}<span class="amount text--primary">{{$food}}</span></h6>
        </div>
        <span class="order-info-seperator"></span>
        <div class="order-info-item">
            <div class="order-info-icon icon-sm">
                <img src="{{asset('/public/assets/admin/img/resturant/foods/inactive.png')}}" alt="public">
            </div>
                @php($food = \App\Models\Food::where(['restaurant_id'=>$restaurant->id, 'status'=>0])->count())
                @php($food = ($food == null) ? 0 : $food)
                <h6 class="card-subtitle">{{translate('Inactive Food')}}<span class="amount text--primary">{{$food}}</span></h6>
        </div>
    </div>
    <!-- End Page Header -->
    <!-- Page Heading -->
    @php($foods = \App\Models\Food::withoutGlobalScope(\App\Scopes\RestaurantScope::class)->where('restaurant_id', $restaurant->id)->latest()->paginate(25))
    <div class="card h-100">
        <div class="card-header flex-wrap border-0 py-2">
            <div class="search--button-wrapper">
                <h3 class="card-title d-flex align-items-center"> <span class="card-header-icon mr-1"><i class="tio-restaurant"></i></span> {{__('messages.foods')}} <span class="badge badge-soft-dark ml-2 badge-circle">{{$foods->total()}}</span></h3>
                <form action="javascript:" id="search-form" class="my-2 ml-auto mr-sm-2 mr-xl-4 ml-sm-auto flex-grow-1 flex-grow-sm-0">
                    <!-- Search -->
                    <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}">
                    <div class="input--group input-group input-group-merge input-group-flush">
                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                placeholder="Search by name... " aria-label="{{__('messages.search')}}" required>
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>
                <!-- Static Export Button -->
                <div class="hs-unfold ml-3 mr-3">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn btn-outline-primary btn--primary font--sm" href="javascript:;"
                        data-hs-unfold-options='{
                            "target": "#usersExportDropdown",
                            "type": "css-animation"
                        }'>
                        <i class="tio-download-to mr-1"></i> {{__('messages.export')}}
                    </a>

                    <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        {{--<span class="dropdown-header">{{__('messages.options')}}</span>
                        <a id="export-copy" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/illustrations/copy.svg"
                                    alt="Image Description">
                            {{__('messages.copy')}}
                        </a>
                        <a id="export-print" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/illustrations/print.svg"
                                    alt="Image Description">
                            {{__('messages.print')}}
                        </a>
                        <div class="dropdown-divider"></div>--}}
                        <span class="dropdown-header">{{__('messages.download')}} {{__('messages.options')}}</span>

                        <a target="__blank" id="export-excel" class="dropdown-item" href="{{route('admin.food.restaurant-food-export', ['type'=>'excel', 'restaurant_id'=>$restaurant->id])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                            src="{{asset('public/assets/admin')}}/svg/components/excel.svg"
                            alt="Image Description">
                            {{__('messages.excel')}}
                        </a>

                        <a target="__blank" id="export-csv" class="dropdown-item" href="{{route('admin.food.restaurant-food-export', ['type'=>'csv', 'restaurant_id'=>$restaurant->id])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                            .{{__('messages.csv')}}
                        </a>
                    </div>
                </div>
                <!-- Static Export Button -->
                <a href="{{route('admin.food.add-new')}}" class="btn btn--primary pull-right"><i
                            class="tio-add-circle"></i> {{__('messages.add')}} {{__('messages.new')}} {{__('messages.food')}}</a>
            </div>
        </div>
        <div class="table-responsive datatable-custom">
            <table id="columnSearchDatatable"
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                        "order": [],
                        "orderCellsTop": true,
                        "paging": false
                    }'>
                <thead class="thead-light">
                    <tr>
                        <th class="text-center pl-4" style="width: 100px;">SL</th>
                        <th style="width: 120px;">{{__('messages.name')}}</th>
                        <th style="width: 120px;">{{__('messages.category')}}</th>
                        <th class="text-right align-items-center flex-nowrap" style="width:120px;padding-right:80px;">
                            {{__('messages.price')}}
                        </th>
                        <th style="width:100px;">{{__('messages.status')}}</th>
                        <th style="width:60px; text-align:center">{{__('messages.action')}}</th>
                    </tr>
                </thead>

                <tbody id="set-rows">
                @php($foods = \App\Models\Food::withoutGlobalScope(\App\Scopes\RestaurantScope::class)->where('restaurant_id', $restaurant->id)->latest()->paginate(25))
                @foreach($foods as $key=>$food)

                <tr>
                    <td class="text-center">{{$key+1}}</td>
                    <td class="py-2">
                        <a class="media align-items-center" href="{{route('admin.food.view',[$food['id']])}}">
                            <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$food['image']}}"
                                    onerror="this.src='{{asset('public/assets/admin/img/100x100/food-default-image.png')}}'" alt="{{$food->name}} image">
                            <div class="media-body">
                                <h5 class="text-hover-primary mb-0">{{Str::limit($food['name'],20,'...')}}</h5>
                            </div>
                        </a>
                    </td>
                    <td>
                    <div>
                        {{Str::limit($food->category,20,'...')}}
                    </div>
                    </td>
                    <td>
                        <div class="table--food-price text-right">
                            @php($price = \App\CentralLogics\Helpers::format_currency($food['price']))
                            {{$price}}
                        </div>
                    </td>
                    <td>
                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$food->id}}">
                            <input type="checkbox" onclick="location.href='{{route('admin.food.status',[$food['id'],$food->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$food->id}}" {{$food->status?'checked':''}}>
                            <span class="toggle-switch-label">
                                <span class="toggle-switch-indicator"></span>
                            </span>
                        </label>
                    </td>
                    <td>
                        <div class="btn--container justify-content-center">
                            <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                href="{{route('admin.food.edit',[$food['id']])}}" title="{{__('messages.edit')}} {{__('messages.food')}}"><i class="tio-edit"></i>
                            </a>
                            <a class="btn btn-sm btn--danger btn-outline-danger action-btn" href="javascript:"
                                onclick="form_alert('food-{{$food['id']}}','Want to delete this item ?')" title="{{__('messages.delete')}} {{__('messages.food')}}"><i class="tio-delete-outlined"></i>
                            </a>
                            <form action="{{route('admin.food.delete',[$food['id']])}}"
                                    method="post" id="food-{{$food['id']}}">
                                @csrf @method('delete')
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="page-area px-4 pb-3">
                <div class="d-flex align-items-center justify-content-end">
                    <div>
                        {!! $foods->links() !!}
                    </div>
                </div>
            </div>
        </div>
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

        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.food.search-vendor')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
