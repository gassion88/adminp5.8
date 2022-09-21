@extends('layouts.vendor.app')

@section('title','Campaign List')

@push('css_or_js')

@endpush

@section('content')
@php($restaurant_id = \App\CentralLogics\Helpers::get_restaurant_id())
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h2 class="page-header-title text-capitalize">
                        <div class="card-header-icon d-inline-flex mr-2 img">
                            <img src="{{asset('/public/assets/admin/img/resturant-panel/page-title/campaign.png')}}" alt="public">
                        </div>
                        <span>
                            {{__('messages.campaign')}}
                        </span>
                        <span class="badge badge-soft-dark ml-2">{{$campaigns->total()}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <div class="card-header py-2">
                        <div class="search--button-wrapper justify-content-end">
                            <form action="javascript:" id="search-form">
                                @csrf
                                <div class="input-group input--group">
                                    <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="Ex : Search by Title name" aria-label="{{__('messages.search')}}">
                                    <button type="submit" class="btn btn--secondary">
                                        <i class="tio-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th style="width:20%">SL</th>
                                <th style="width:20%">{{__('messages.title')}}</th>
                                <th style="width:20%">{{__('messages.image')}}</th>
                                                                <th >{{__('messages.date')}} {{__('messages.duration')}}</th>
                                <th >{{__('messages.time')}} {{__('messages.duration')}}</th>
                                <th style="width:20%">{{__('messages.status')}}</th>
                            </tr>
                            <!-- <tr>
                                <th>

                                </th>
                                <th>
                                    <input type="text" id="column1_search" class="form-control form-control-sm"
                                           placeholder="Search...">
                                </th>
                                <th>
                                </th>
                                <th>
                                <select id="column3_search" class="js-select2-custom"
                                            data-hs-select2-options='{
                                              "minimumResultsForSearch": "Infinity",
                                              "customClass": "custom-select custom-select-sm text-capitalize"
                                            }'>
                                        <option value="">{{__('messages.any')}}</option>
                                        <option value="Joined">Joined</option>
                                    </select>
                                </th>
                            </tr> -->
                            </thead>

                            <tbody id="set-rows">
                            @foreach($campaigns as $key=>$campaign)
                                <tr>
                                    <td>{{$key+$campaigns->firstItem()}}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{Str::limit($campaign['title'],25,'...')}}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="overflow-x: hidden;overflow-y: hidden;">
                                            <img src="{{asset('storage/app/public/campaign')}}/{{$campaign['image']}}" style="width: 100%;aspect-ratio:2.53; max-width:124px;object-fit:cover"
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark">{{$campaign->start_date?$campaign->start_date->format('d M, Y'). ' - ' .$campaign->end_date->format('d M, Y'): 'N/A'}}</span>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark">{{$campaign->start_time?date(config('timeformat'),strtotime($campaign->start_time)). ' - ' .date(config('timeformat'),strtotime($campaign->end_time)): 'N/A'}}</span>
                                    </td>
                                    <td>
                                    <?php
                                        $restaurant_ids = [];
                                        foreach($campaign->restaurants as $restaurant)
                                        {
                                            $restaurant_ids[] = $restaurant->id;
                                        }
                                    ?>
                                        @if(in_array($restaurant_id,$restaurant_ids))
                                        <!-- <button type="button" onclick="location.href='{{route('vendor.campaign.remove-restaurant',[$campaign['id'],$restaurant_id])}}'" title="You are already joined. Click to out from the campaign." class="join--btn btn-outline-danger">Out</button> -->
                                        <button type="button" onclick="form_alert('campaign-{{$campaign['id']}}','{{__('messages.alert_restaurant_out_from_campaign')}}')" title="You are already joined. Click to out from the campaign." class="join--btn btn--danger text-white">{{  translate('Leave Campaign') }}</button>
                                        <form action="{{route('vendor.campaign.remove-restaurant',[$campaign['id'],$restaurant_id])}}"
                                                method="GET" id="campaign-{{$campaign['id']}}">
                                            @csrf
                                        </form>
                                        @else
                                        <button type="button" class="join--btn btn--primary text-white" onclick="form_alert('campaign-{{$campaign['id']}}','{{__('messages.alert_restaurant_join_campaign')}}')" title="Click to join the campaign">{{  translate('Join Campaign') }}</button>
                                        <form action="{{route('vendor.campaign.addrestaurant',[$campaign['id'],$restaurant_id])}}"
                                                method="GET" id="campaign-{{$campaign['id']}}">
                                            @csrf
                                        </form>
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($campaigns) === 0)
                        <div class="empty--data">
                            <img src="{{asset('/public/assets/admin/img/empty.png')}}" alt="public">
                            <h5>
                                {{translate('no_data_found')}}
                            </h5>
                        </div>
                        @endif
                        <table class="page-area">
                            <tfoot>
                            {!! $campaigns->links() !!}
                            </tfoot>
                        </table>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
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
    <script>
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('vendor.campaign.search')}}',
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
