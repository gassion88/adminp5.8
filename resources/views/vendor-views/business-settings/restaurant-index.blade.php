@extends('layouts.vendor.app')

@section('title',__('messages.settings'))

@push('css_or_js')
<link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
<style>
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 15px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #377dff;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #377dff;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h2 class="page-header-title text-capitalize">
                <div class="card-header-icon d-inline-flex mr-2 img">
                    <img src="{{asset('/public/assets/admin/img/resturant-panel/page-title/resturant.png')}}" alt="public">
                </div>
                <span>
                    {{__('messages.restaurant')}} {{__('messages.setup')}}
                </span>
            </h2>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between ">
                    <h4 class="text-capitalize m-0">
                        <span class="card-header-icon">
                            <i class="tio-settings-outlined"></i>
                        </span>
                        {{__('messages.restaurant_temporarily_closed_title')}}
                    </h4>
                    <label class="switch toggle-switch-lg m-0">
                        <input type="checkbox" class="toggle-switch-input" onclick="restaurant_open_status(this)"
                            {{$restaurant->active ?'':'checked'}}>
                        <span class="toggle-switch-label">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="tio-fastfood"></i> General {{__('messages.settings')}}
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group m-0">
                            <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border rounded px-3 form-control" for="schedule_order">
                                <span class="pr-2">{{__('messages.scheduled')}} {{__('messages.order')}}:
                                    <span data-toggle="tooltip" data-placement="right" data-original-title="{{translate('If this status is turned on, the customer is able to place a scheduled order')}}" class="input-label-secondary"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="i"></span>
                                </span>
                                <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('vendor.business-settings.toggle-settings',[$restaurant->id,$restaurant->schedule_order?0:1, 'schedule_order'])}}'" id="schedule_order" {{$restaurant->schedule_order?'checked':''}}>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group m-0">
                            <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border rounded px-3 form-control" for="delivery">
                                <span class="pr-2">
                                    {{__('messages.delivery')}}:
                                    <span data-toggle="tooltip" data-placement="right" data-original-title="{{translate(': If this option is active, customers can place orders for home delivery.')}}" class="input-label-secondary"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="i"></span>
                                </span>
                                <input type="checkbox" name="delivery" class="toggle-switch-input" onclick="location.href='{{route('vendor.business-settings.toggle-settings',[$restaurant->id,$restaurant->delivery?0:1, 'delivery'])}}'" id="delivery" {{$restaurant->delivery?'checked':''}}>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    @if ($restaurant->self_delivery_system == 1)
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group m-0">
                            <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border rounded px-3 form-control" for="free_delivery">
                                <span class="pr-2">
                                    {{__('messages.free_delivery')}}:
                                    <span data-toggle="tooltip" data-placement="right" data-original-title="{{translate('If this option is on, customers will get free delivery')}}" class="input-label-secondary"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="i"></span>
                                </span>
                                <input type="checkbox" name="free_delivery" class="toggle-switch-input" onclick="location.href='{{route('vendor.business-settings.toggle-settings',[$restaurant->id,$restaurant->free_delivery?0:1, 'free_delivery'])}}'" id="free_delivery" {{$restaurant->free_delivery?'checked':''}}>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group m-0">
                            <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border rounded px-3 form-control" for="take_away">
                                <span class="pr-2 text-capitalize">
                                    {{__('messages.take_away')}}:
                                    <span data-toggle="tooltip" data-placement="right" data-original-title="{{translate('By disabling this option, customers cannot place self-pickup / take-away orders')}}" class="input-label-secondary"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="i"></span>
                                </span>
                                <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('vendor.business-settings.toggle-settings',[$restaurant->id,$restaurant->take_away?0:1, 'take_away'])}}'" id="take_away" {{$restaurant->take_away?'checked':''}}>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    @if ($toggle_veg_non_veg)
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group m-0">
                            <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border rounded px-3 form-control" for="veg">
                                <span class="pr-2 text-capitalize">
                                    {{__('messages.veg')}}:
                                    <span data-toggle="tooltip" data-placement="right" data-original-title="{{translate('If this button is on , it will be show in veg restaurant list in user app.')}}" class="input-label-secondary"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="i"></span>
                                </span>
                                <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('vendor.business-settings.toggle-settings',[$restaurant->id,$restaurant->veg?0:1, 'veg'])}}'" id="veg" {{$restaurant->veg?'checked':''}}>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group m-0">
                            <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border rounded px-3 form-control" for="non_veg">
                                <span class="pr-2 text-capitalize">
                                    {{__('messages.non_veg')}}:
                                    <span data-toggle="tooltip" data-placement="right" data-original-title="{{translate('If this button is on , it will be show in non-veg restaurant list in user app.')}}" class="input-label-secondary"><img src="{{asset('public/assets/admin/img/info-circle.svg')}}" alt="i"></span>
                                </span>
                                <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('vendor.business-settings.toggle-settings',[$restaurant->id,$restaurant->non_veg?0:1, 'non_veg'])}}'" id="non_veg" {{$restaurant->non_veg?'checked':''}}>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title">
                    <span class="card-header-icon"><i class="tio-tune"></i></span>
                    {{__('messages.basic')}} {{__('messages.settings')}}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{route('vendor.business-settings.update-setup',[$restaurant['id']])}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-{{$restaurant->self_delivery_system?'4':'6'}} col-12">
                            <div class="form-group m-0">
                                <label class="input-label text-capitalize" for="title">{{__('messages.minimum')}} {{__('messages.order')}} {{__('messages.amount')}}</label>
                                <input type="number" name="minimum_order" step="0.01" min="0" max="100000" class="form-control" placeholder="100" value="{{$restaurant->minimum_order??'0'}}">
                            </div>
                        </div>
                        @if($restaurant->self_delivery_system)
                        <div class="col-sm-{{$restaurant->self_delivery_system?'4':'6'}} col-12">
                            <div class="form-group m-0">
                                <label class="input-label text-capitalize" for="minimum_shipping_charge">{{translate('messages.minimum_shipping_charge')}} ({{\App\CentralLogics\Helpers::currency_symbol()}})
                                </label>
                                <input type="number" id="minimum_shipping_charge" min="0" max="99999999.99" step="0.01" name="minimum_delivery_charge" class="form-control shipping_input" value="{{isset($restaurant->minimum_shipping_charge) ? $restaurant->minimum_shipping_charge : ''}}">
                            </div>
                        </div>

                        <div class="col-sm-{{$restaurant->self_delivery_system?'4':'6'}} col-12">
                            <div class="form-group m-0">
                                <label class="input-label text-capitalize" for="title">{{translate('messages.delivery_charge_per_km')}} ({{\App\CentralLogics\Helpers::currency_symbol()}})</label>
                                <input type="number" name="per_km_delivery_charge" step="0.01" min="0" max="100000" class="form-control" placeholder="100" value="{{$restaurant->per_km_shipping_charge??'0'}}">
                            </div>
                        </div>
                        @endif

                        <div class="col-sm-{{$restaurant->self_delivery_system?'4':'6'}} col-12">
                            <div class="form-group m-0">
                                <label class="toggle-switch toggle-switch-sm d-flex justify-content-between input-label mb-1" for="gst_status">
                                    <span class="form-check-label">{{__('messages.gst')}} <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{__('messages.gst_status_warning')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('messages.gst_status_warning')}}"></span></span>
                                    <input type="checkbox" class="toggle-switch-input" name="gst_status" id="gst_status" value="1" {{$restaurant->gst_status?'checked':''}}>
                                    <span class="toggle-switch-label text">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                                <input type="number" id="gst" name="gst" class="form-control" value="{{$restaurant->gst_code}}" {{isset($restaurant->gst_status)?'':'readonly'}}>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="reset" class="btn btn--reset">{{__('messages.reset')}}</button>
                        <button type="submit" class="btn btn--primary">{{__('messages.update')}}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="tio-date-range"></i>
                    {{ translate('Opening and closing schedules') }}
                </h5>
            </div>
            <div class="card-body" id="schedule">
                @include('vendor-views.business-settings.partials._schedule', $restaurant)
            </div>
        </div>
    </div>

    <!-- Create schedule modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('messages.Create Schedule For ')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="javascript:" method="post" id="add-schedule">
                        @csrf
                        <input type="hidden" name="day" id="day_id_input">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">{{__('messages.Start time')}}:</label>
                            <input type="time" class="form-control" name="start_time" required>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{__('messages.End time')}}:</label>
                            <input type="time" class="form-control" name="end_time" required>
                        </div>
                        <div class="btn--container justify-content-end">
                            <button type="reset" class="btn btn--reset">{{__('messages.reset')}}</button>
                            <button type="submit" class="btn btn--primary">{{__('messages.Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script>
        function restaurant_open_status(e) {
            Swal.fire({
                title: '{{__('messages.are_you_sure')}}',
                text: '{{$restaurant->active ? __('messages.you_want_to_temporarily_close_this_restaurant') : __('messages.you_want_to_open_this_restaurant') }}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: '{{__('messages.no')}}',
                confirmButtonText: '{{__('messages.yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: '{{route('vendor.business-settings.update-active-status')}}',
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            toastr.success(data.message);
                        },
                        complete: function () {
                            $('#loading').hide();
                            location.reload();
                        },
                    });
                } else {
                    e.checked = !e.checked;
                }
            })
        };

        function delete_schedule(route) {
            Swal.fire({
                title: '{{__('messages.are_you_sure')}}',
                text: '{{__('messages.You want to remove this schedule')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: '{{__('messages.no')}}',
                confirmButtonText: '{{__('messages.yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: route,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            if (data.errors) {
                                for (var i = 0; i < data.errors.length; i++) {
                                    toastr.error(data.errors[i].message, {
                                        CloseButton: true,
                                        ProgressBar: true
                                    });
                                }
                            } else {
                                $('#schedule').empty().html(data.view);
                                toastr.success('{{__('messages.Schedule removed successfully')}}', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            toastr.error('{{__('messages.Schedule not found')}}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                }
            })
        };


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });

        $(document).on('ready', function () {
            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });

            $("#gst_status").on('change', function(){
                if($("#gst_status").is(':checked')){
                    $('#gst').removeAttr('readonly');
                } else {
                    $('#gst').attr('readonly', true);
                }
            });
        });

        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var day_name = button.data('day');
            var day_id = button.data('dayid');
            var modal = $(this);
            modal.find('.modal-title').text('{{__('messages.Create Schedule For ')}} ' + day_name);
            modal.find('.modal-body input[name=day]').val(day_id);
        })

        $('#add-schedule').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('vendor.business-settings.add-schedule')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        $('#schedule').empty().html(data.view);
                        $('#exampleModal').modal('hide');
                        toastr.success('{{__('messages.Schedule added successfully')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(XMLHttpRequest.responseText, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
