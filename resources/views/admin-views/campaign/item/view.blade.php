@extends('layouts.admin.app')

@section('title','Item Campaign Preview')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="page-header-title text-break">{{$campaign['title']}}</h1>
                <a href="{{route('admin.campaign.edit',['item',$campaign['id']])}}" class="btn btn--primary float-right">
                    <i class="tio-edit"></i> {{__('messages.edit')}}
                </a>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card mb-3">
            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-md-center">
                    <div class="col-md-6 col-lg-4 mb-3 mb-md-0">
                            <img class="rounded initial-16" src="{{asset('storage/app/public/campaign')}}/{{$campaign['image']}}" onerror="this.src='{{asset('/public/assets/admin/img/900x400/img1.png')}}'" alt="Image Description">
                    </div>
                    <div class="col-md-6">
                        <span class="d-block mb-1">
                            {{__('messages.campaign')}} {{__('messages.starts')}} {{__('messages.from')}} :
                            <strong class="text--title">{{$campaign->start_date->format('Y-M-d')}}</strong>
                        </span>
                        <span class="d-block mb-1">
                            {{__('messages.campaign')}} {{__('messages.ends')}} {{__('messages.at')}} :
                            <strong class="text--title">{{$campaign->end_date->format('Y-M-d')}}</strong>
                        </span>
                        <span class="d-block mb-1">
                            {{__('messages.available')}} {{__('messages.time')}} {{__('messages.starts')}} :
                            <strong class="text--title">{{$campaign->start_time->format(config('timeformat'))}}</strong>
                        </span>
                        <span class="d-block">
                            {{__('messages.available')}} {{__('messages.time')}} {{__('messages.ends')}} :
                            <strong class="text--title">{{$campaign->end_time->format(config('timeformat'))}}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <!-- End Body -->
        </div>
        <div class="row g-2">
            <div class="col-lg-4 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="text-center">
                            <span class="mb-3">{{translate('restaurant_info')}}</span>
                            @if($campaign->restaurant)
                            <a href="{{route('admin.vendor.view', $campaign->restaurant_id)}}" class="d-block">
                                <img
                                    class="avatar-img avatar-circle initial-17"
                                    onerror="this.src='{{asset('/public/assets/admin/img/100x100/restaurant-default-image.png')}}'"
                                    src="{{asset('storage/app/public/restaurant/'.$campaign->restaurant->logo)}}"
                                    alt="Image Description">
                                <h2 class="m-0">{{$campaign->restaurant['name']}}</h2>
                            </a>
                            @else
                            <span class="badge-info">{{__('messages.restaurant')}} {{__('messages.deleted')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-fastfood"></i>
                            </span>
                            <span>
                                {{translate('food_information')}}
                            </span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="px-4 w-120px"><h4 class="m-0">{{translate('short_description')}}</h4></th>
                                        <th class="px-4 w-120px"><h4 class="m-0">{{__('messages.price')}}</h4></th>
                                        <th class="px-4 w-120px"><h4 class="m-0">{{__('messages.variations')}}</h4></th>
                                        <th class="px-4 w-120px"><h4 class="m-0">{{translate('addons')}}</h4></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4">
                                            <p class="fz-13px">{{$campaign['description']}}</p>
                                        </td>
                                        <td class="px-4">
                                            <div>

                                                <span class="d-block text-dark">{{__('messages.price')}} : <strong>{{\App\CentralLogics\Helpers::format_currency($campaign['price'])}}</strong>
                                                </span class="d-block text-dark">
                                                <span class="d-block text-dark">{{__('messages.tax')}} :
                                                    <strong>{{\App\CentralLogics\Helpers::format_currency(\App\CentralLogics\Helpers::tax_calculate($campaign,$campaign['price']))}}</strong>
                                                </span class="d-block text-dark">
                                                <span class="d-block text-dark">{{__('messages.discount')}} :
                                                    <strong>{{\App\CentralLogics\Helpers::format_currency(\App\CentralLogics\Helpers::discount_calculate($campaign,$campaign['price']))}}</strong>
                                                </span class="text-dark">
                                            </div>
                                        </td>
                                        <td class="px-4">
                                            @foreach(json_decode($campaign['variations'],true) as $variation)
                                                <small class="d-block text-capitalize">
                                                {{$variation['type']}} :
                                                <strong>{{\App\CentralLogics\Helpers::format_currency($variation['price'])}}</strong>
                                                </small>
                                            @endforeach
                                        </td>
                                        <td class="px-4">
                                            @foreach(\App\Models\AddOn::whereIn('id',json_decode($campaign['add_ons'],true))->get() as $addon)
                                                <small class="text-capitalize d-block">
                                                {{$addon['name']}} : {{\App\CentralLogics\Helpers::format_currency($addon['price'])}}
                                                </small>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
        @php($orders = $campaign->orderdetails()->paginate(config('default_pagination')))
        <!-- Card -->
        <div class="card mt-3">
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <span class="card-title-icon">
                            <i class="tio-fastfood"></i>
                        </span>
                        <span>{{translate('campaign_restaurant_list')}}</span>
                        <span class="badge badge-pill badge-soft-secondary">{{ count($orders) }}</span>
                    </h5>
                    <form>
                        <div class="input--group input-group">
                            <input type="text" class="form-control" placeholder="Search here by restaurants">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                    </form>
                    <!-- Unfold -->
                    <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn export--btn btn-outline-primary btn--primary font--sm" href="javascript:;"
                            data-hs-unfold-options='{
                                "target": "#usersExportDropdown",
                                "type": "css-animation"
                            }'>
                            <i class="tio-download-to mr-1"></i> {{__('messages.export')}}
                        </a>

                        <div id="usersExportDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header">{{__('messages.download')}} {{__('messages.options')}}</span>
                            <a id="export-excel" class="dropdown-item" href="javascript:;">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="{{asset('public/assets/admin')}}/svg/components/excel.svg"
                                        alt="Image Description">
                                {{__('messages.excel')}}
                            </a>
                            <a id="export-csv" class="dropdown-item" href="javascript:;">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="{{asset('public/assets/admin')}}/svg/components/placeholder-csv-format.svg"
                                        alt="Image Description">
                                .{{__('messages.csv')}}
                            </a>
                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                        "columnDefs": [{
                            "targets": [0],
                            "orderable": false
                        }],
                        "order": [],
                        "info": {
                        "totalQty": "#datatableWithPaginationInfoTotalQty"
                        },
                        "search": "#datatableSearch",
                        "entries": "#datatableEntries",
                        "pageLength": 25,
                        "isResponsive": false,
                        "isShowPaging": false,
                        "pagination": "datatablePagination"
                    }'>
                        <thead class="thead-light">
                        <tr>
                            <th>
                                SL
                            </th>
                            <th class="table-column-pl-0">{{__('messages.order')}}</th>
                            <th>{{__('messages.date')}}</th>
                            <th>{{__('messages.customer')}}</th>
                            <th>{{__('messages.vendor')}}</th>
                            <th>{{__('messages.payment')}} {{__('messages.status')}}</th>
                            <th>{{__('messages.total')}}</th>
                            <th>{{__('messages.order')}} {{__('messages.status')}}</th>
                        </tr>
                        </thead>

                        <tbody id="set-rows">
                        @foreach($orders as $key=>$order)

                            <tr class="status-{{$order['order_status']}} class-all">
                                <td class="">
                                    {{$key+1}}
                                </td>
                                <td class="table-column-pl-0">
                                    <a href="{{route('admin.order.details',['id'=>$order['order_id']])}}">{{$order->order['id']}}</a>
                                </td>
                                <td>{{date('d M Y',strtotime($order->order['created_at']))}}</td>
                                <td>
                                    @if($order->order->customer)
                                        <a class="text-body text-capitalize" href="{{route('admin.customer.view',[$order->order['user_id']])}}">{{$order->order->customer['f_name'].' '.$order->order->customer['l_name']}}</a>
                                    @else
                                        <label class="badge badge-danger">{{__('messages.invalid')}} {{__('messages.customer')}} {{__('messages.data')}}</label>
                                    @endif
                                </td>
                                <td>
                                    <label class="badge badge-soft-primary">{{Str::limit($order->order->restaurant?$order->order->restaurant->name:__('messages.Restaurant deleted!'),20,'...')}}</label>
                                </td>
                                <td>
                                    @if($order->order->payment_status=='paid')
                                        <span class="badge badge-soft-success">
                                        {{__('messages.paid')}}
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger">
                                        {{__('messages.unpaid')}}
                                        </span>
                                    @endif
                                </td>
                                <td>{{\App\CentralLogics\Helpers::format_currency($order->order['order_amount'])}}</td>
                                <td class="text-capitalize">
                                    @if($order->order['order_status']=='pending')
                                        <span class="badge badge-soft-info ml-2 ml-sm-3">
                                        {{__('messages.pending')}}
                                        </span>
                                    @elseif($order->order['order_status']=='confirmed')
                                        <span class="badge badge-soft-info ml-2 ml-sm-3">
                                        {{__('messages.confirmed')}}
                                        </span>
                                    @elseif($order->order['order_status']=='processing')
                                        <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                        {{__('messages.processing')}}
                                        </span>
                                    @elseif($order->order['order_status']=='out_for_delivery')
                                        <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                        {{__('messages.out_for_delivery')}}
                                        </span>
                                    @elseif($order->order['order_status']=='delivered')
                                        <span class="badge badge-soft-success ml-2 ml-sm-3">
                                        {{__('messages.delivered')}}
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger ml-2 ml-sm-3">
                                        {{str_replace('_',' ',$order->order['order_status'])}}
                                        </span>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Footer -->
            <div class="page-area px-4 pb-3">
                <div class="d-flex align-items-center justify-content-end">
                    <div>
                        {!! $orders->links() !!}
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')

@endpush
