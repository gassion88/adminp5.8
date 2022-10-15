<?php
use App\Models\DeliveryMan;
use App\Models\Order;

 $deliveryMen = DeliveryMan::where('status', 1)->available()->active()->orderBy('updated_at','asc')->get();
 $deliveryAllMen = DeliveryMan::where('status', 1)->active()->get();
 $deliver = array();
//return count(Order::where('delivery_man_id', 1)->whereDate('delivered', \Carbon\Carbon::today())->get());
 for ($i = 0; $i <= count($deliveryAllMen)-1; $i++) {
     array_push($deliver, Order::where('delivery_man_id', $deliveryAllMen[$i]['id'])->latest()->first());
     $deliver[$i]['day_count'] = count(Order::where('delivery_man_id', $deliveryAllMen[$i]['id'])->whereDate('delivered', \Carbon\Carbon::today())->get());


 }



?>
<div id="headerMain" class="d-none">
    <header id="header"
            class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered">
        <div class="navbar-nav-wrap">
            <div class="navbar-brand-wrapper">
                <!-- Logo -->
                @php($restaurant_logo=\App\Models\BusinessSetting::where(['key'=>'logo'])->first()->value)
                <a class="navbar-brand d-block" href="{{route('admin.dashboard')}}" aria-label="">
                    <img class="navbar-brand-logo" style="max-height: 48px; border-radius: 8px"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                         src="{{asset('storage/app/public/business/'.$restaurant_logo)}}" alt="Logo">
                    <img class="navbar-brand-logo-mini" style="max-height: 48px; border-radius: 8px"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                         src="{{asset('storage/app/public/business/'.$restaurant_logo)}}" alt="Logo">
                </a>
                <!-- End Logo -->
            </div>

            <div class="navbar-nav-wrap-content-left d--xl-none">
                <!-- Navbar Vertical Toggle -->
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
                    <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                       data-placement="right" title="Collapse"></i>
                    <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                       data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                       data-toggle="tooltip" data-placement="right" title="Expand"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->
            </div>

            <!-- Secondary Content -->
                                            
            <div class="navbar-nav-wrap-content-right">
                <!-- Navbar -->
                <ul class="navbar-nav align-items-center flex-row">
                <li class="nav-item d-none d-sm-inline-block mr-4">
                    <button type="button" class="btn btn--primary font-regular" data-toggle="modal"
                                                data-target="#myModall" data-lat='21.03' data-lng='105.85'>
                                                <i class="tio-bike"> </i>Доставщики
                                            </button>
                                            </li>
                    <li class="nav-item d-none d-sm-inline-block mr-4">
                        <!-- Notification -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-soft-secondary rounded-circle"
                               href="{{route('admin.message.list')}}">
                                <i class="tio-messages-outlined"></i>
                                @php($message=\App\Models\Conversation::whereUserType('admin')->where('unread_message_count','>','0')->count())
                                @if($message!=0)
                                    <span class="btn-status btn-sm-status btn-status-danger"></span>
                                @endif
                            </a>
                        </div>
                        <!-- End Notification -->
                    </li>
                    <li class="nav-item d-none d-sm-inline-block mr-5">
                        <!-- Notification -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-icon btn-soft-secondary rounded-circle"
                               href="{{route('admin.order.list',['status'=>'pending'])}}">
                                <i class="tio-shopping-cart-outlined"></i>
                                <span id="danger-not" class="btn-status btn-sm-status"></span>
                            </a>
                        </div>
                        <!-- End Notification -->
                    </li>


                    <li class="nav-item ml-3">
                        <!-- Account -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                               data-hs-unfold-options='{
                                     "target": "#accountNavbarDropdown",
                                     "type": "css-animation"
                                   }'>
                                <div class="cmn--media right-dropdown-icon d-flex align-items-center">
                                    <div class="media-body pl-0 pr-2">
                                        <span class="card-title h5 text-right">
                                            {{auth('admin')->user()->f_name}}
                                            {{auth('admin')->user()->l_name}}
                                        </span>
                                        <span class="card-text">{{auth('admin')->user()->email}}</span>
                                    </div>
                                    <div class="avatar avatar-sm avatar-circle">
                                        <img class="avatar-img"
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                            src="{{asset('storage/app/public/admin')}}/{{auth('admin')->user()->image}}"
                                            alt="Image Description">
                                        <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                    </div>
                                </div>
                            </a>

                            <div id="accountNavbarDropdown"
                                 class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account"
                                 style="width: 16rem;">
                                <div class="dropdown-item-text">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-sm avatar-circle mr-2">
                                            <img class="avatar-img"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                                 src="{{asset('storage/app/public/admin')}}/{{auth('admin')->user()->image}}"
                                                 alt="Image Description">
                                        </div>
                                        <div class="media-body">
                                            <span class="card-title h5">{{auth('admin')->user()->f_name}}
                                            {{auth('admin')->user()->l_name}}</span>
                                            <span class="card-text">{{auth('admin')->user()->email}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{route('admin.settings')}}">
                                    <span class="text-truncate pr-2" title="Settings">{{__('messages.settings')}}</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="javascript:" onclick="Swal.fire({
                                    title: 'Do you want to logout?',
                                    showDenyButton: true,
                                    showCancelButton: true,
                                    confirmButtonColor: '#FC6A57',
                                    cancelButtonColor: '#363636',
                                    confirmButtonText: `Yes`,
                                    denyButtonText: `Don't Logout`,
                                    }).then((result) => {
                                    if (result.value) {
                                    location.href='{{route('admin.auth.logout')}}';
                                    } else{
                                    Swal.fire('Canceled', '', 'info')
                                    }
                                    })">
                                    <span class="text-truncate pr-2" title="Sign out">{{__('messages.sign_out')}}</span>
                                </a>
                            </div>
                        </div>
                        <!-- End Account -->
                    </li>
                </ul>
                <!-- End Navbar -->
            </div>
            <!-- End Secondary Content -->
        </div>
    </header>
    <div class="modal fade" id="myModall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{ __('messages.assign') }}
                        {{ __('messages.deliveryman') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 my-2">
                        <h3 class="modal-title" id="myModalLabel">Доступные доставщики: {{count($deliveryMen)}}</h3>
                            <ul class="list-group overflow-auto max-height-400">
                                @foreach ($deliveryMen as $dm)
                                    <li class="list-group-item">
                                        <span class="dm_list" role='button' data-id="{{ $dm['id'] }}">
                                            <img class="avatar avatar-sm avatar-circle mr-1"
                                                onerror="this.src='{{ asset('public/assets/admin/img/160x160/img1.jpg') }}'"
                                                src="{{ asset('storage/app/public/delivery-man') }}/{{ $dm['image'] }}"
                                                alt="{{ $dm['name'] }}">
                                                {{ $dm['f_name'].' '. $dm['l_name']}}
                                        </span>
                                           
                                            
                                           <?php
                                           //dd($deliveryAllMen);
                                                $dat = "";
                                                for ($i = 0; $i <= count($deliver)-1; $i++){
                                                    if(isset($deliver[$i]['id'])){
                                                        if( $deliver[$i]['delivery_man_id'] == $dm['id']){
                                                            $dat = $deliver[$i]["accepted"];
                                                            break;                                                           
                                                        }
                                                    }
                                                    
                                                }
                                                
                                            ?>
                                             @if ( $dat!= "" )
                                             <br>последний заказ {{\Carbon\Carbon::parse($dat)->format('H:i d.m.Y') }}
                                             @else
                                             <br>пока заказов нет
                                             @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-7 modal_body_map">
                        <h3 class="modal-title" id="myModalLabel">Активные сегодня: {{count($deliveryAllMen)}}</h3>
                        @foreach ($deliveryAllMen as $dm)

                                    <?php
                                        
                                        $dat = "";
                                        for ($i = 0; $i <= count($deliver)-1; $i++){
                                            if( isset($deliver[$i]['id']) ){
                                                if( $deliver[$i]['delivery_man_id'] == $dm['id']){
                                                    $dat = $deliver[$i]["accepted"];
                                                    $dc = $deliver[$i]['day_count'];
                                                    $activ_order = $deliver[$i]["id"];
                                                    break;                                                           
                                                }
                                            }
                                            
                                        }
                                        
                                    ?>
                                    <li class="list-group-item">
                                        <span class="dm_list" role='button' data-id="{{ $dm['id'] }}">
                                            <img class="avatar avatar-sm avatar-circle mr-1"
                                                onerror="this.src='{{ asset('public/assets/admin/img/160x160/img1.jpg') }}'"
                                                src="{{ asset('storage/app/public/delivery-man') }}/{{ $dm['image'] }}"
                                                alt="{{ $dm['name'] }}">
                                            {{ $dm['f_name'].' '. $dm['l_name']}}
                                        </span>
                                            @if ( $dm["current_orders"] != 0 )
                                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong style="color: #ec9a3c !important;">На доставке</strong> <a href="{{route('admin.order.details',['id'=>$activ_order])}}">{{$activ_order}}</a>
                                            @endif  
                                            
                                            
                                            
                                             @if ( $dat!= "" )
                                             <br>Принял заказ в {{\Carbon\Carbon::parse($dat)->format('H:i d.m.Y') }}
                                             <br>Заказов за сегодня {{$dc}}
                                             @else
                                             <br>пока заказов нет                                            
                                             @endif
                                        
                                    </li>
                                @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="headerFluid" class="d-none"></div>
<div id="headerDouble" class="d-none"></div>
