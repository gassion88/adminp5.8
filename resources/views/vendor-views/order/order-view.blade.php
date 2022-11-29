@php
$max_processing_time = explode('-', $order['restaurant']['delivery_time'])[0];
@endphp
@extends('layouts.vendor.app')

@section('title', translate('messages.Order Details'))
@php($add = json_decode($order->delivery_address, true))

@section('content')
    <?php $campaign_order = isset($order->details[0]->campaign) ? true : false; ?>
    <div class="content container-fluid item-box-page">

    <div class="page-header d-print-none">

            <h1 class="page-header-title text-capitalize">
                <div class="card-header-icon d-inline-flex mr-2 img">
                    <img src="{{asset('public/assets/admin/img/orders.png')}}" alt="public">
                </div>
                <span>
                    {{ translate('messages.Order Details') }}
                </span>
                <div class="d-flex ml-auto">
                    <a class="btn btn-icon btn-sm btn-soft-primary rounded-circle mr-1"
                        href="{{ route('vendor.order.details', [$order['id'] - 1]) }}" data-toggle="tooltip"
                        data-placement="top" title="Предыдущий заказ">
                        <i class="tio-chevron-left m-0"></i>
                    </a>
                    <a class="btn btn-icon btn-sm btn-soft-primary rounded-circle"
                        href="{{ route('vendor.order.details', [$order['id'] + 1]) }}" data-toggle="tooltip"
                        data-placement="top" title="Следующий заказ">
                        <i class="tio-chevron-right m-0"></i>
                    </a>
                </div>
            </h1>
        </div>


        <div class="row g-1" id="printableArea">
            <div class="col-lg-8 order-print-area-left">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header border-0 align-items-start flex-wrap">
                        <div class="order-invoice-left">
                            <h1 class="page-header-title mt-2">
                                <span>
                                    {{ translate('messages.order') }} #{{ $order['id'] }}
                                </span>

                                {{-- <span class="badge badge-soft-success text-capitalize my-2 ml-2">
                                    POS
                                </span> --}}
                                @if ($order->edited)
                                    <span class="badge badge-soft-danger text-capitalize px-2 ml-2">
                                        {{ translate('messages.edited') }}
                                    </span>
                                @endif
                               <!-- <a class="btn btn--primary m-2 print--btn d-sm-none ml-auto" href="{{ route('vendor.order.generate-invoice', [$order['id']]) }}">
                                    <i class="tio-print mr-1"></i>
                                </a>-->
                            </h1>
                            <span class="mt-2 d-block">
                                <i class="tio-date-range"></i>
                                {{ date('d n Y ' . config('timeformat'), strtotime($order['created_at'])) }}
                            </span>
                            @if ($order->schedule_at && $order->scheduled)
                                <span class="text-capitalize d-block mt-1">
                                    {{ translate('messages.scheduled_at') }}
                                    : <label  class="fz-10px badge badge-soft-primary">{{ date('d n Y ' . config('timeformat'), strtotime($order['schedule_at'])) }}</label>
                                </span>
                            @endif
                            @if ($campaign_order)
                            <span class="badge mt-2 badge-soft-primary">
                                {{ translate('messages.campaign_order') }}
                            </span>
                            @endif
                            @if($order['order_note'])
                            <h6>
                                {{ translate('messages.order') }} {{ translate('messages.note') }} :
                                {{ $order['order_note'] }}
                            </h6>
                            @endif
                        </div>
                        <div class="order-invoice-right">
                           <!-- <div class="d-none d-sm-flex flex-wrap ml-auto align-items-center justify-content-end m-n-5rem">
                                <a class="btn btn--primary m-2 print--btn" href="{{ route('vendor.order.generate-invoice', [$order['id']]) }}">
                                    <i class="tio-print mr-1"></i> {{ translate('messages.print') }} {{ translate('messages.invoice') }}
                                </a>
                            </div>-->
                            <div class="text-right mt-3 order-invoice-right-contents text-capitalize">
                                <h6>
                                    <span>Статус :</span>
                                    @if ($order['order_status'] == 'pending')
                                        <span class="badge badge-soft-info ml-2 ml-sm-3">
                                            {{ translate('messages.pending') }}
                                        </span>
                                    @elseif($order['order_status'] == 'confirmed')
                                        <span class="badge badge-soft-info ml-2 ml-sm-3">
                                            {{ translate('messages.confirmed') }}
                                        </span>
                                    @elseif($order['order_status'] == 'processing')
                                        <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                            {{ translate('messages.cooking') }}
                                        </span>
                                    @elseif($order['order_status'] == 'picked_up')
                                        <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                            {{ translate('messages.out_for_delivery') }}
                                        </span>
                                    @elseif($order['order_status'] == 'delivered')
                                        <span class="badge badge-soft-success ml-2 ml-sm-3">
                                            {{ translate('messages.delivered') }}
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger ml-2 ml-sm-3">
                                            {{ translate(str_replace('_', ' ', $order['order_status'])) }}
                                        </span>
                                    @endif
                                </h6>
                                @if ( !isset($add['number']) )
                               <!-- <h6>
                                    <span>
                                    {{ translate('messages.payment') }} {{ translate('messages.method') }} :</span>
                                    <strong>
                                    {{ translate(str_replace('_', ' ', $order['payment_method'])) }}</strong>
                                </h6>-->
                                <h6>
                                    <span>Тип :</span>
                                    <strong class="text--title">{{ translate(str_replace('_', ' ', $order['order_type'])) }}</strong>
                                </h6>
                                <!--<h6>
                                    <span>{{ translate('Payment Status') }} :</span>
                                    @if ($order['payment_status'] == 'paid')
                                        <strong class="text-success">
                                            {{ translate('messages.paid') }}
                                        </strong>
                                    @else
                                        <strong class="text-danger">
                                            {{ translate('messages.unpaid') }}
                                        </strong>
                                    @endif
                                </h6>-->
                                @endif
                                @if ( isset($add['number']) )
                                <h6>
                                    <span>Номер клиента :</span>
                                        <strong class="text-success">
                                            {{ $add['number'] }}
                                        </strong>
                                </h6>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    
                    @if ( !isset($add['number']) )
                    
                    <div class="card-body p-0">
                        <?php
                        $total_addon_price = 0;
                        $product_price = 0;
                        $restaurant_discount_amount = 0;
                        $product_price = 0;
                        $total_addon_price = 0;
                        ?>
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-nowrap card-table dataTable no-footer mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Детали</th>
                                        <th>Аддоны</th>
                                        <th class="text-right">Цена</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($order->details as $key => $detail)
                                    @if (isset($detail->food_id))
                                        @php($detail->food = json_decode($detail->food_details, true))
                                                <tr>
                                                    <td>
                                                        <div class="media">
                                                            <a class="avatar mr-3 cursor-pointer initial-80"
                                                                href="{{ route('vendor.food.view', $detail->food['id']) }}">
                                                                <img class="img-fluid rounded initial-80" src="{{ asset('storage/app/public/product') }}/{{ $detail->food['image'] }}" onerror="this.src='{{ asset('public/assets/admin/img/100x100/1.png') }}'"
                                                                    alt="Image Description">
                                                            </a>
                                                            <div class="media-body">
                                                                <div>
                                                                    <strong> {{ Str::limit($detail->food['name'], 25, '...') }}</strong><br>

                                                                    @if (count(json_decode($detail['variation'], true)) > 0)
                                                                        @foreach (json_decode($detail['variation'], true)[0] as $key1 => $variation)
                                                                            <span class="font-size-sm text-body text-capitalize">
                                                                                <span>{{ $key1 }} : </span>
                                                                                <span
                                                                                    class="font-weight-bold">{{ Str::limit($variation, 20, '...') }}</span>
                                                                            </span>
                                                                        @endforeach
                                                                    @endif

                                                                    <div>
                                                                        <strong>{{ translate('messages.Price') }} :</strong>
                                                                        {{ \App\CentralLogics\Helpers::format_currency($detail['price']) }}
                                                                    </div>
                                                                    <div>
                                                                        <strong>{{ translate('messages.Qty') }} :</strong> {{ $detail['quantity'] }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @foreach (json_decode($detail['add_ons'], true) as $key2 => $addon)
                                                            <div class="font-size-sm text-body">
                                                                <span>{{ Str::limit($addon['name'], 25, '...') }} : </span>
                                                                <span class="font-weight-bold">
                                                                    {{ $addon['quantity'] }} x
                                                                    {{ \App\CentralLogics\Helpers::format_currency($addon['price']) }}
                                                                </span>
                                                            </div>
                                                            @php($total_addon_price += $addon['price'] * $addon['quantity'])
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="text-right">
                                                            @php($amount = $detail['price'] * $detail['quantity'])
                                                            <h5>
                                                                {{ \App\CentralLogics\Helpers::format_currency($amount) }}
                                                            </h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                        @php($product_price += $amount)
                                        @php($restaurant_discount_amount += $detail['discount_on_food'] * $detail['quantity'])
                                    @elseif(isset($detail->item_campaign_id))
                                        @php($detail->campaign = json_decode($detail->food_details, true))
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <div class="avatar avatar-xl mr-3">
                                                        <img class="img-fluid rounded initial-80"
                                                            src="{{ asset('storage/app/public/campaign') }}/{{ $detail->campaign['image'] }}"
                                                            onerror="this.src='{{ asset('public/assets/admin/img/100x100/1.png') }}'"
                                                            alt="Image Description">
                                                    </div>
                                                    <div class="media-body">
                                                        <div>
                                                            <strong>
                                                                {{ Str::limit($detail->campaign['name'], 25, '...') }}</strong><br>
                                                            @if (count(json_decode($detail['variation'], true)) > 0)
                                                                @foreach (json_decode($detail['variation'], true)[0] as $key1 => $variation)
                                                                    <div class="font-size-sm text-body">
                                                                        <span>{{ $key1 }} : </span>
                                                                        <span
                                                                            class="font-weight-bold">{{ Str::limit($variation, 25, '...') }}</span>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                            <div>
                                                                <strong>{{ translate('messages.Price') }} : </strong>
                                                                <span>{{ \App\CentralLogics\Helpers::format_currency($detail['price']) }}</span>
                                                            </div>
                                                            <div>
                                                                <strong>{{ translate('messages.Qty') }} : </strong>
                                                                <span>
                                                                    {{ $detail['quantity'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach (json_decode($detail['add_ons'], true) as $key2 => $addon)
                                                    <div class="font-size-sm text-body">
                                                        <span>{{ Str::limit($addon['name'], 20, '...') }} : </span>
                                                        <span class="font-weight-bold">
                                                            {{ $addon['quantity'] }} x
                                                            {{ \App\CentralLogics\Helpers::format_currency($addon['price']) }}
                                                        </span>
                                                    </div>
                                                    @php($total_addon_price += $addon['price'] * $addon['quantity'])
                                                @endforeach
                                            </td>
                                            <td>
                                                @php($amount = $detail['price'] * $detail['quantity'])
                                                <h5 class="text-right">{{ \App\CentralLogics\Helpers::format_currency($amount) }}</h5>
                                            </td>
                                        </tr>
                                        @php($product_price += $amount)
                                        @php($restaurant_discount_amount += $detail['discount_on_food'] * $detail['quantity'])
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <?php

                        $coupon_discount_amount = $order['coupon_discount_amount'];

                        $total_price = $product_price + $total_addon_price - $restaurant_discount_amount - $coupon_discount_amount;

                        $total_tax_amount = $order['total_tax_amount'];

                        $restaurant_discount_amount = $order['restaurant_discount_amount'];

                        ?>
                        <div class="px-4">
                            <div class="row justify-content-md-end mb-3">
                                <div class="col-md-9 col-lg-8">
                                    <dl class="row text-sm-right">
                                        <dt class="col-sm-6">{{ translate('messages.price') }} блюд:
                                        </dt>
                                        <dd class="col-sm-6">
                                            {{ \App\CentralLogics\Helpers::format_currency($product_price) }}</dd>
                                        <dt class="col-sm-6">Цена аддонов:
                                        </dt>
                                        <dd class="col-sm-6">
                                            {{ \App\CentralLogics\Helpers::format_currency($total_addon_price) }}
                                            <hr>
                                        </dd>

                                        <dt class="col-sm-6">{{ translate('messages.subtotal') }}:</dt>
                                        <dd class="col-sm-6">
                                            {{ \App\CentralLogics\Helpers::format_currency($product_price + $total_addon_price) }}
                                        </dd>
                                        <dt class="col-sm-6">{{ translate('messages.discount') }}:</dt>
                                        <dd class="col-sm-6">
                                            - {{ \App\CentralLogics\Helpers::format_currency($restaurant_discount_amount) }}
                                        </dd>
                                        <!--<dt class="col-sm-6">{{ translate('messages.coupon') }}
                                            {{ translate('messages.discount') }}:
                                        </dt>
                                        <dd class="col-sm-6">
                                            - {{ \App\CentralLogics\Helpers::format_currency($coupon_discount_amount) }}</dd>
                                        <dt class="col-sm-6">{{ translate('messages.vat/tax') }}:</dt>
                                        <dd class="col-sm-6">
                                            + {{ \App\CentralLogics\Helpers::format_currency($total_tax_amount) }}</dd>
                                        <dt class="col-sm-6">{{ translate('messages.delivery_man_tips') }}

                                        </dt>
                                        <dd class="col-sm-6">
                                            @php($dm_tips = $order['dm_tips'])
                                            + {{ \App\CentralLogics\Helpers::format_currency($dm_tips) }}

                                        </dd>-->
                                        <dt class="col-sm-6">{{ translate('messages.delivery') }}
                                        :
                                        </dt>
                                        <dd class="col-sm-6">
                                            @php($del_c = $order['delivery_charge'])
                                            + {{ \App\CentralLogics\Helpers::format_currency($del_c) }}
                                            <hr>
                                        </dd>

                                        <dt class="col-sm-6">{{ translate('messages.total') }}:</dt>
                                        <dd class="col-sm-6">
                                            {{ \App\CentralLogics\Helpers::format_currency($product_price + $del_c + $total_tax_amount + $total_addon_price + $dm_tips - $coupon_discount_amount - $restaurant_discount_amount) }}
                                        </dd>
                                    </dl>
                                    <!-- End Row -->
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                    @endif
                </div>
                <!-- End Card -->
            </div>


            <div class="col-lg-4 order-print-area-right">
                <!-- Card -->
                @if ($order['order_status'] != 'delivered')
                <div class="card mb-2">
                    <!-- Header -->
                    <div class="card-header border-0 py-0">
                        <h4 class="card-header-title border-bottom py-3 m-0  w-100 text-center">Изменить статус заказа</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->

                    <div class="card-body">
                        <!-- Unfold -->
                        @php($order_delivery_verification = (bool) \App\Models\BusinessSetting::where(['key' => 'order_delivery_verification'])->first()->value)
                        @if ($order['order_type'] == 'take_away')
                        <div class="order-btn-wraper">
                            @if ($order['order_status'] == 'pending')
                                <a class="btn w-100 mb-3 btn-sm btn--primary"
                                    onclick="order_status_change_alert('{{ route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'confirmed']) }}','{{ translate('Изменить статус на подтверждено?') }}')"
                                    href="javascript:">
                                    {{ translate('Confirm Order') }}
                                </a>
                                @if (config('canceled_by_restaurant'))
                                    <a class="btn w-100 mb-3 btn-sm btn-outline-danger btn--danger mt-3"
                                        onclick="order_status_change_alert('{{ route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'canceled']) }}', '{{ translate('messages.order_canceled_confirmation') }}')"
                                        href="javascript:">{{ translate('Cancel Order') }}</a>
                                @endif
                            @elseif ($order['order_status'] == 'confirmed' || $order['order_status'] == 'accepted')
                                <a class="btn btn-sm btn--primary w-100 mb-3"
                                    onclick="order_status_change_alert('{{ route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'processing']) }}','{{ translate('Изменить статус на готовку?') }}', verification = false, {{ $max_processing_time }})"
                                    href="javascript:">{{ translate('messages.Proceed_for_cooking') }}</a>
                            @elseif ($order['order_status'] == 'processing')
                                <a class="btn btn-sm btn--primary w-100 mb-3"
                                    onclick="order_status_change_alert('{{ route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'handover']) }}','{{ translate('Изменить статус на ждёт курьера ?') }}')"
                                    href="javascript:">{{ translate('messages.make_ready_for_handover') }}</a>
                            @elseif ($order['order_status'] == 'handover' && ($order['order_type'] == 'take_away' || \App\CentralLogics\Helpers::get_restaurant_data()->self_delivery_system))
                                <a class="btn btn-sm btn--primary w-100 mb-3"
                                    onclick="order_status_change_alert('{{ route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'delivered']) }}','{{ translate('Изменить статус на доставлено ?') }}', {{ $order_delivery_verification ? 'true' : 'false' }})"
                                    href="javascript:">{{ translate('messages.maek_delivered') }}</a>
                            @endif
                        </div>
                        @endif
                        @if ($order->order_status != 'refunded')
                        @if ($order['order_type'] != 'take_away')
                                        <div>
                                            <div class="dropdown">
                                                @if (isset($order->restaurant))
                                                    <button class="form-control h--45px dropdown-toggle d-flex justify-content-between align-items-center" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        {{ __('messages.status') }}
                                                    </button>
                                                @endif
                                                @php($order_delivery_verification = (bool) \App\Models\BusinessSetting::where(['key' => 'order_delivery_verification'])->first()->value)
                                                <div class="dropdown-menu text-capitalize" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item {{ $order['order_status'] == 'pending' ? 'active' : '' }}"
                                                        onclick="route_alert('{{ route('vendor.order.statuss', ['id' => $order['id'], 'order_status' => 'pending']) }}','Изменить статус на ожидание?')"
                                                        href="javascript:">{{ __('messages.pending') }}</a>
                                                    <a class="dropdown-item {{ $order['order_status'] == 'confirmed' ? 'active' : '' }}"
                                                        onclick="route_alert('{{ route('vendor.order.statuss', ['id' => $order['id'], 'order_status' => 'confirmed']) }}','Изменить статус на подтверждено?')"
                                                        href="javascript:">{{ __('messages.confirmed') }}</a>

                                                    <a class="dropdown-item {{ $order['order_status'] == 'processing' ? 'active' : '' }}"
                                                        onclick="route_alert('{{ route('vendor.order.statuss', ['id' => $order['id'], 'order_status' => 'processing']) }}', 'Изменить статус на готовка?','Вы уверены?', '{{ $max_processing_time }}')"
                                                        href="javascript:">
                                                        {{ __('messages.processing') }}</a>

                                                    <a class="dropdown-item {{ $order['order_status'] == 'handover' ? 'active' : '' }}"
                                                        onclick="route_alert('{{ route('vendor.order.statuss', ['id' => $order['id'], 'order_status' => 'handover']) }}','Изменить статус на ждёт курьера?')"
                                                        href="javascript:">{{ __('messages.handover') }}</a>
                                                    <a class="dropdown-item {{ $order['order_status'] == 'picked_up' ? 'active' : '' }}"
                                                        onclick="route_alert('{{ route('vendor.order.statuss', ['id' => $order['id'], 'order_status' => 'picked_up']) }}','Изменить статус на «На доставке»?')"
                                                        href="javascript:">{{ __('messages.out_for_delivery') }}</a>
                                                    <a class="dropdown-item {{ $order['order_status'] == 'delivered' ? 'active' : '' }}"
                                                        onclick="route_alert('{{ route('vendor.order.statuss', ['id' => $order['id'], 'order_status' => 'delivered']) }}','Изменить статус на доставлено ?')"
                                                        href="javascript:">{{ __('messages.delivered') }}</a>
                                                    <a class="dropdown-item {{ $order['order_status'] == 'canceled' ? 'active' : '' }}"
                                                        onclick="route_alert('{{ route('vendor.order.statuss', ['id' => $order['id'], 'order_status' => 'canceled']) }}','Изменить статус на отменено?')"
                                                        href="javascript:">{{ __('messages.canceled') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endif 
                                    @endif
                        <!-- End Unfold -->
                        @if ($order['order_type'] != 'take_away')
                            @if ($order->delivery_man)
                            </br>
                                <h5 class="card-title mb-3">
                                    <span class="card-header-icon">
                                        <i class="tio-user"></i>
                                    </span>
                                    <span>
                                        Курьер назначен
                                    </span>
                                </h5>
                                <div class="media align-items-center deco-none customer--information-single" href="javascript:">
                                    <div class="avatar avatar-circle">
                                        <img class="avatar-img  initial-81" onerror="this.src='{{ asset('public/assets/admin/img/160x160/img3.png') }}'"
                                            src="{{ asset('storage/app/public/delivery-man/' . $order->delivery_man->image) }}"
                                            alt="Image Description">
                                    </div>
                                    <div class="media-body">
                                        <span class="fz--14px text--title font-semibold text-hover-primary d-block">
                                            {{ $order->delivery_man['f_name'] . ' ' . $order->delivery_man['l_name'] }}
                                        </span>
                                        <span class="d-block">
                                            <strong class="text--title font-semibold">
                                                {{ $order->delivery_man->orders_count }}
                                            </strong>
                                            {{ translate('messages.orders') }}
                                        </span>
                                        <span class="d-block">
                                            <a class="text--title font-semibold" href="tel:{{ $order->delivery_man['phone'] }}">
                                                <strong>
                                                    {{ $order->delivery_man['email'] }}
                                                </strong>
                                            </a>
                                        </span>
                                        <span class="d-block">
                                            <strong class="text--title font-semibold">
                                            </strong>
                                            {{ $order->delivery_man['phone'] }}
                                        </span>
                                    </div>
                                </div>

                                @if ($order['order_type'] != 'take_away')
                                    <hr>
                                    @php($address = $order->dm_last_location)
                                @endif
                            @else
                                <div class="py-3 w-100 text-center mt-3">
                                    <span class="d-block text-capitalize qcont">
                                        <i class="tio-security-warning"></i> Курьер пока не назначен
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                @endif
                @if ( !isset($add['number']) )     
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <span class="card-header-icon">
                                <i class="tio-user"></i>
                            </span>
                            <span>
                                {{ translate('messages.customer') }}
                            </span>
                        </h5>
                        @if ($order->customer)
                            <div class="media align-items-center deco-none customer--information-single" href="javascript:">
                                <div class="avatar avatar-circle">
                                    <img class="avatar-img  initial-81"
                                        onerror="this.src='{{ asset('public/assets/admin/img/resturant-panel/customer.png') }}'"
                                        src="{{ asset('storage/app/public/profile/' . $order->customer->image) }}"
                                        alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <span class="fz--14px text--title font-semibold text-hover-primary d-block">
                                        {{ $order->customer['f_name'] . ' ' . $order->customer['l_name'] }}
                                    </span>
                                    <span class="d-block">
                                        <strong class="text--title font-semibold">
                                        {{ $order->customer->orders_count }}
                                        </strong>
                                        Заказов
                                    </span>
                                    <span class="d-block">
                                        <a class="text--title font-semibold" href="tel:{{ $order->customer['phone'] }}">
                                            <strong>
                                                {{ $order->customer['phone'] }}
                                            </strong>
                                        </a>
                                    </span>
                                    <span class="d-block">
                                        <strong class="text--title font-semibold">
                                        </strong>
                                        {{ $order->customer['email'] }}
                                    </span>
                                </div>
                            </div>
                        @else
                        {{translate('messages.customer_not_found')}}
                        @endif
                    </div>
                </div>
                @if ($order->delivery_address)
                    <div class="card mt-2">
                        <div class="card-body">
                            @php($address = json_decode($order->delivery_address, true))
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    <span class="card-header-icon">
                                        <i class="tio-user"></i>
                                    </span>
                                    <span>
                                        Информация о доставке
                                    </span>
                                </h5>
                                {{-- @if (isset($address))
                                    <a class="link" data-toggle="modal" data-target="#shipping-address-modal"
                                        href="javascript:"><i class="tio-edit"></i></a>
                                @endif --}}
                            </div>
                            @if (isset($address))
                            <span class="delivery--information-single mt-3">
                                <span class="name">Имя:</span>
                                <span class="info">{{ $address['contact_person_name'] }}</span>
                                <span class="name">Телефон:</span>
                                <a class="info" href="tel:{{ $address['contact_person_number'] }}">
                                    {{ $address['contact_person_number'] }}
                                </a>
                                <span class="name">Улица:</span>
                                <span class="info">{{ isset($address['road']) ? $address['road'] : '' }}</span>
                                <span class="name">Дом:</span>
                                <span class="info">{{ isset($address['house']) ? $address['house'] : '' }}</span>
                                <span class="name">Квартира:</span>
                                <span class="info">{{ isset($address['floor']) ? $address['floor'] : '' }}</span>
                            </span>
                            @endif
                        </div>
                    </div>
                @endif
                @endif
            </div>
        </div>

        <!-- End Row -->
    </div>

    <!-- Modal -->
    <div id="shipping-address-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalTopCoverTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-top-cover bg-dark text-center">
                    <figure class="position-absolute right-0 bottom-0 left-0 mb-n-1">
                        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                            viewBox="0 0 1920 100.1">
                            <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z" />
                        </svg>
                    </figure>

                    <div class="modal-close">
                        <button type="button" class="btn btn-icon btn-sm btn-ghost-light" data-dismiss="modal"
                            aria-label="Close">
                            <svg width="16" height="16" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor"
                                    d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- End Header -->

                <div class="modal-top-cover-icon">
                    <span class="icon icon-lg icon-light icon-circle icon-centered shadow-soft">
                        <i class="tio-location-search"></i>
                    </span>
                </div>

                @php($address = \App\Models\CustomerAddress::find($order['delivery_address_id']))
                @if (isset($address))
                    <form action="{{ route('vendor.order.update-shipping', [$order['delivery_address_id']]) }}"
                        method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{ translate('messages.type') }}
                                </label>
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control h--45px" name="address_type"
                                        value="{{ $address['address_type'] }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{ translate('messages.contact') }}
                                </label>
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control h--45px" name="contact_person_number"
                                        value="{{ $address['contact_person_number'] }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{ translate('messages.name') }}
                                </label>
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control h--45px" name="contact_person_name"
                                        value="{{ $address['contact_person_name'] }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{ translate('messages.address') }}
                                </label>
                                <div class="col-md-10 js-form-message">
                                    <input type="text" class="form-control h--45px" name="address"
                                        value="{{ $address['address'] }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{ translate('messages.latitude') }}
                                </label>
                                <div class="col-md-4 js-form-message">
                                    <input type="text" class="form-control h--45px" name="latitude"
                                        value="{{ $address['latitude'] }}" required>
                                </div>
                                <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                    {{ translate('messages.longitude') }}
                                </label>
                                <div class="col-md-4 js-form-message">
                                    <input type="text" class="form-control h--45px" name="longitude"
                                        value="{{ $address['longitude'] }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--reset"
                                data-dismiss="modal">{{ translate('messages.close') }}</button>
                            <button type="submit" class="btn btn--primary">{{ translate('messages.save') }}
                                {{ translate('messages.changes') }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- End Content -->


@endsection
@push('script_2')
    <script>
        function order_status_change_alert(route, message, verification, processing = false) {
            if (verification) {
                Swal.fire({
                    title: '{{ translate('Enter order verification code') }}',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    confirmButtonText: '{{ translate('messages.submit') }}',
                    showLoaderOnConfirm: true,
                    preConfirm: (otp) => {
                        location.href = route + '&otp=' + otp;
                        // .then(response => {
                        //     if (!response.ok) {
                        //     throw new Error(response.statusText)
                        //     }
                        //     return response.json()
                        // })
                        // .catch(error => {
                        //     Swal.showValidationMessage(
                        //     `Request failed: ${error}`
                        //     )
                        // })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
                // .then((result) => {
                // if (result.isConfirmed) {
                //     Swal.fire({
                //     title: `${result.value.login}'s avatar`,
                //     imageUrl: result.value.avatar_url
                //     })
                // }
                // })
            } else if (processing) {
                Swal.fire({
                    //text: message,
                    title: '{{ translate('messages.Are you sure ?') }}',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '{{ translate('messages.Cancel') }}',
                    confirmButtonText: '{{ translate('messages.submit') }}',
                    inputPlaceholder: "{{ translate('Enter processing time') }}",
                    input: 'text',
                    html: message + '<br/>'+'<label>{{ translate('Enter Processing time in minutes') }}</label>',
                    inputValue: processing,
                    preConfirm: (processing_time) => {
                        location.href = route + '&processing_time=' + processing_time;
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            } else {
                Swal.fire({
                    title: '{{ translate('messages.Are you sure ?') }}',
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '{{ translate('messages.No') }}',
                    confirmButtonText: '{{ translate('messages.Yes') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        location.href = route;
                    }
                })
            }
        }

        function last_location_view() {
            toastr.warning('{{ translate('Only available when order is out for delivery!') }}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush
