@extends('layouts.admin.app')
@section('title','Withdraw information View')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="content container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header p-3">
                    <h3 class="text-center text-capitalize">
                        {{trans('messages.vendor')}} {{trans('messages.withdraw')}} {{trans('messages.information')}}
                    </h3>

                    <i class="tio-wallet-outlined" style="font-size: 30px"></i>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <h5 class="text-capitalize">{{trans('messages.amount')}}
                                : {{$wr->amount}}</h5>
                            <h5 class="font-regular">{{trans('messages.request_time')}} : {{$wr->created_at}}</h5>
                        </div>
                        <div class="col-4">
                            {{ translate('Note') }} : {{$wr->transaction_note}}
                        </div>
                        <div class="col-4">
                            @if ($wr->approved== 0)
                                <button type="button" class="btn btn--primary float-right" data-toggle="modal"
                                        data-target="#exampleModal">{{trans('messages.proceed')}}
                                    <i class="tio-arrow-forward"></i>
                                </button>
                            @else
                                <div class="text-center float-right text-capitalize">
                                    @if($wr->approved==1)
                                        <label class="badge badge-success p-2 rounded-bottom">
                                            {{trans('messages.approved')}}
                                        </label>
                                    @else
                                        <label class="badge badge-danger p-2 rounded-bottom">
                                            {{trans('messages.denied')}}
                                        </label>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="min-height: 260px;">
                <div class="card-header">
                    <h3 class="h3 mb-0 text-capitalize">{{trans('messages.bank_info')}} </h3>
                    <i class="tio tio-dollar-outlined"></i>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-2">
                        <h4>{{trans('messages.bank_name')}}
                            : {{$wr->vendor->bank_name ? $wr->vendor->bank_name : 'No Data found'}}</h4>
                        <h5 class="text-capitalize">{{trans('messages.branch')}}
                            : {{$wr->vendor->branch ? $wr->vendor->branch : 'No Data found'}}</h5>
                        <h5 class="text-capitalize font-regular">{{trans('messages.holder_name')}}
                            : {{$wr->vendor->holder_name ? $wr->vendor->holder_name : 'No Data found'}}</h5>
                        <h5 class="text-capitalize font-regular">{{trans('messages.account_no')}}
                            : {{$wr->vendor->account_no ? $wr->vendor->account_no : 'No Data found'}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="min-height: 260px;">
                <div class="card-header">
                    <h3 class="h3 mb-0">{{trans('messages.restaurant')}} {{trans('messages.info')}}</h3>
                    <i class="tio tio-shop-outlined"></i>
                </div>
                <div class="card-body">
                    @if(isset($wr->vendor->restaurants[0]))
                    <h5>{{trans('messages.restaurant')}} : {{$wr->vendor->restaurants[0]->name}}</h5>
                    <h5 class="text-capitalize font-regular">{{trans('messages.phone')}} : {{$wr->vendor->restaurants[0]->contact}}</h5>
                    <h5 class="text-capitalize font-regular">{{trans('messages.address')}} : {{$wr->vendor->restaurants[0]->address}}</h5>
                    <h5 class="text-capitalize badge badge-primary">{{trans('messages.balance')}}
                        : {{$wr->vendor->wallet->balance}}
                    </h5>
                    @else
                    <center>{{__('messages.Restaurant deleted!')}}</center>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="min-height: 260px;">
                <div class="card-header">
                    <h3 class="h3 mb-0 "> {{trans('messages.owner')}} {{trans('messages.info')}}</h3>
                    <i class="tio tio-user-big-outlined"></i>
                </div>
                <div class="card-body">
                    <h5>{{trans('messages.name')}} : {{$wr->vendor->f_name}} {{$wr->vendor->l_name}}</h5>
                    <h5 class="font-regular">{{trans('messages.email')}} : {{$wr->vendor->email}}</h5>
                    <h5 class="font-regular">{{trans('messages.phone')}} : {{$wr->vendor->phone}}</h5>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ translate('Withdraw request process') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('admin.vendor.withdraw_status',[$wr->id])}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">{{ translate('Request') }}:</label>
                                <select name="approved" class="custom-select h--45px" id="inputGroupSelect02">
                                    <option value="1">{{ translate('Approve') }}</option>
                                    <option value="2">{{ translate('Deny') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">{{ translate('Note about transaction or
                                    request') }}:</label>
                                <textarea class="form-control" name="note" id="message-text"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--secondary" data-dismiss="modal">{{ translate('Close') }}</button>
                            <button type="submit" class="btn btn--primary">{{ translate('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

@endpush
