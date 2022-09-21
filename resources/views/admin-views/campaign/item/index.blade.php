@extends('layouts.admin.app')

@section('title','Add new campaign')

@push('css_or_js')
    <link href="{{asset('public/assets/admin/css/tags-input.min.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="tio-add-circle-outlined"></i>
                        </div>
                        {{__('messages.add')}} {{__('messages.new')}} {{__('messages.food')}} {{__('messages.campaign')}}
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <form action="javascript:" method="post" id="campaign_form"
                enctype="multipart/form-data">
            @csrf
            @php($language=\App\Models\BusinessSetting::where('key','language')->first())
            @php($language = $language->value ?? null)
            @php($default_lang = 'bn')
            <div class="row g-2">
                    @if($language)
                    <div class="col-12">
                        @php($default_lang = json_decode($language)[0])
                            <ul class="nav nav-tabs mb-4">
                                @foreach(json_decode($language) as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#" id="{{$lang}}-link">{{\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <div class="col-md-6">
                    @if($language)
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <span class="card-header-icon">
                                        <i class="tio-fastfood"></i>
                                    </span>
                                    <span>{{ translate('Food Info') }}</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach(json_decode($language) as $lang)
                                    <div class="mb-1 {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                        <div class="form-group">
                                            <label class="input-label" for="{{$lang}}_title">{{__('messages.title')}} ({{strtoupper($lang)}})</label>
                                            <input type="text" {{$lang == $default_lang? 'required':''}} name="title[]" id="{{$lang}}_title" class="form-control" placeholder="{{__('messages.new_campaign')}}" oninvalid="document.getElementById('en-link').click()">
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                        <div class="form-group mb-0">
                                            <label class="input-label" for="exampleFormControlInput1">{{__('messages.short')}} {{__('messages.description')}} ({{strtoupper($lang)}})</label>
                                            <textarea type="text" name="description[]" class="form-control ckeditor"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon">
                                    <i class="tio-fastfood"></i>
                                </span>
                                <span>{{translate('food_info')}}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-1" id="{{$default_lang}}-form">
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1">{{__('messages.title')}} ({{translate('en')}})</label>
                                    <input type="text" name="title[]" class="form-control" placeholder="{{__('messages.new_food')}}" required>
                                </div>
                                <input type="hidden" name="lang[]" value="en">
                                <div class="form-group mb-0">
                                    <label class="input-label" for="exampleFormControlInput1">{{__('messages.short')}} {{__('messages.description')}}</label>
                                    <textarea type="text" name="description[]" class="form-control ckeditor"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-image"></i></span>
                                <span>{{translate('food_image')}} <small class="text-danger">({{ translate('Ratio 200x200') }})</small></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0 h-100 d-flex flex-column">
                                <center id="image-viewer-section" class="mt-auto mb-auto">
                                    <img class="initial-15" id="viewer"
                                            src="{{asset('/public/assets/admin/img/100x100/food-default-image.png')}}" alt="banner image"/>
                                </center>
                                <div class="form-group mt-3 mb-0">
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                        <label class="custom-file-label" for="customFileEg1">{{__('messages.choose')}} {{__('messages.file')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-dashboard-outlined"></i></span>
                                <span>{{translate('food_details')}}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="title">{{__('messages.zone')}}</label>
                                        <select name="zone_id" id="zone" class="form-control js-select2-custom">
                                            <option disabled selected value="">---{{__('messages.select')}}---</option>
                                            @php($zones=\App\Models\Zone::all())
                                            @foreach($zones as $zone)
                                                @if(isset(auth('admin')->user()->zone_id))
                                                    @if(auth('admin')->user()->zone_id == $zone->id)
                                                        <option value="{{$zone->id}}" selected>{{$zone->name}}</option>
                                                    @endif
                                                @else
                                                <option value="{{$zone['id']}}">{{$zone['name']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlSelect1">{{__('messages.restaurant')}}<span
                                                class="input-label-secondary">*</span></label>
                                        <select name="restaurant_id" id="restaurant_id" class="js-data-example-ajax form-control" onchange="getRestaurantData('{{url('/')}}/admin/vendor/get-addons?data[]=0&restaurant_id='+this.value,'add_on')"  title="Select Restaurant" required>
                                        <option selected value="">{{translate('select_restaurant')}}</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlSelect1">{{__('messages.category')}}<span
                                                class="input-label-secondary">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control js-select2-custom"
                                                onchange="getRequest('{{url('/')}}/admin/food/get-categories?parent_id='+this.value,'sub-categories')">
                                            <option value="">---{{__('messages.select')}}---</option>
                                            @php($categories=\App\Models\Category::where(['position' => 0])->get())
                                            @foreach($categories as $category)
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlSelect1">{{__('messages.sub_category')}}<span
                                                class="input-label-secondary" title="{{__('messages.category_required_warning')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('messages.category_required_warning')}}"></span></label>
                                        <select name="sub_category_id" id="sub-categories"
                                                class="form-control js-select2-custom"
                                                onchange="getRequest('{{url('/')}}/admin/food/get-categories?parent_id='+this.value,'sub-sub-categories')">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{__('messages.item_type')}}</label>
                                        <select name="veg" id="item_type" class="form-control js-select2-custom">
                                            <option value="0" selected>{{__('messages.non_veg')}}</option>
                                            <option value="1">{{__('messages.veg')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlSelect1">{{__('messages.addon')}}<span
                                                class="input-label-secondary" title="{{__('messages.restaurant_required_warning')}}"><img src="{{asset('/public/assets/admin/img/info-circle.svg')}}" alt="{{__('messages.restaurant_required_warning')}}"></span></label>
                                        <select name="addon_ids[]" id="add_on" class="form-control js-select2-custom" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-dollar-outlined"></i></span>
                                <span>{{translate('amount')}}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{__('messages.price')}}</label>
                                        <input type="number" min=".01" max="100000" step="0.01" value="1" name="price" class="form-control"
                                                placeholder="Ex : 100" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{__('messages.discount')}}</label>
                                        <input type="number" min="0" max="100000" value="0" name="discount" class="form-control"
                                                placeholder="Ex : 100" >
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1">{{__('messages.discount')}} {{__('messages.type')}}</label>
                                        <select name="discount_type" class="form-control js-select2-custom">
                                            <option value="percent">{{__('messages.percent')}}</option>
                                            <option value="amount">{{__('messages.amount')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon">
                                    <i class="tio-canvas-text"></i>
                                </span>
                                <span>{{translate('add_attribute')}}</span>
                            </h5>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlSelect1">{{__('messages.attribute')}}<span
                                                class="input-label-secondary"></span></label>
                                        <select name="attribute_id[]" id="choice_attributes"
                                                class="form-control js-select2-custom"
                                                multiple="multiple">
                                            @foreach(\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                                <option value="{{$attribute['id']}}">{{$attribute['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 customer_choice_options" id="customer_choice_options">
                                </div>
                                <div class="col-md-12 variant_combination" id="variant_combination">
                                    <div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-date-range"></i></span>
                                <span>{{translate('time_schedule')}}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="title">{{__('messages.start')}} {{__('messages.date')}}</label>
                                        <input type="date" id="date_from" class="form-control" required="" name="start_date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="title">{{__('messages.end')}} {{__('messages.date')}}</label>
                                        <input type="date" id="date_to" class="form-control" required="" name="end_date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="title">{{__('messages.start')}} {{__('messages.time')}}</label>
                                        <input type="time" id="start_time" class="form-control" name="start_time">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="title">{{__('messages.end')}} {{__('messages.time')}}</label>
                                        <input type="time" id="end_time" class="form-control" name="end_time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn--container justify-content-end mt-3">
                <button type="reset" id="reset_btn" class="btn btn--reset">{{__('messages.reset')}}</button>
                <button type="submit" class="btn btn--primary">{{__('messages.submit')}}</button>
            </div>
        </form>
    </div>

@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin')}}/js/tags-input.min.js"></script>
    <script>
        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function getRestaurantData(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    $('#' + id).empty().append(data.options);
                },
            });
            $.get({
                url:route,
                dataType: 'json',
                success: function(data) {
                    if(data.available_time_starts != null && data.available_time_ends != null){
                        var opening_time = data.available_time_starts;
                        var closeing_time = data.available_time_ends;
                        $('#available_time_ends').attr('min', opening_time);
                        $('#available_time_starts').attr('min', opening_time);
                        $('#available_time_ends').attr('max', closeing_time);
                        $('#available_time_starts').attr('max', closeing_time);
                        $('#available_time_starts').val(opening_time);
                        $('#available_time_ends').val(closeing_time);
                    }
                },
            });
        }


        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{__('messages.choice_title')}}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{__('messages.enter_choice_values')}}" data-role="tagsinput" onchange="combination_update()"></div></div>');
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{route('admin.food.variant-combination')}}',
                data: $('#campaign_form').serialize(),
                success: function (data) {
                    $('#variant_combination').html(data.view);
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }
        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }
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


        function show_item(type) {
            if (type === 'product') {
                $("#type-product").show();
                $("#type-category").hide();
            } else {
                $("#type-product").hide();
                $("#type-category").show();
            }
        }
        $("#date_from").on("change", function () {
            $('#date_to').attr('min',$(this).val());
        });

        $("#date_to").on("change", function () {
            $('#date_from').attr('max',$(this).val());
        });


        $(document).ready(function(){
            $('#date_from').attr('min',(new Date()).toISOString().split('T')[0]);
            $('#date_to').attr('min',(new Date()).toISOString().split('T')[0]);
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
            var zone_id = [];
            $('#zone').on('change', function(){
                if($(this).val())
                {
                    zone_id = [$(this).val()];
                }
                else
                {
                    zone_id = [];
                }
            });


            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '{{url('/')}}/admin/vendor/get-restaurants',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            zone_ids: zone_id,
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                        results: data
                        };
                    },
                    __port: function (params, success, failure) {
                        var $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });
        });

        $('#campaign_form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.campaign.store-item')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('Campaign uploaded successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '{{route('admin.campaign.list', 'item')}}';
                        }, 2000);
                    }
                }
            });
        });
    </script>
    <script>
        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == '{{$default_lang}}')
            {
                $("#from_part_2").removeClass('d-none');
            }
            else
            {
                $("#from_part_2").addClass('d-none');
            }
        })
    </script>
        <script>
            $('#reset_btn').click(function(){
                // $('#zone').val(null).trigger('change');
                // $('#restaurant_id').val(null).trigger('change');
                // $('#category_id').val(null).trigger('change');
                // $('#sub-categories').val(null).trigger('change');
                // $('#item_type').val(0).trigger('change');
                // $('#add_on').val(null).trigger('change');
                // $('#choice_attributes').val(null).trigger('change');
                // $('#customer_choice_options').val(null).trigger('change');
                // $('#variant_combination').val(null).trigger('change');
                // $('#viewer').attr('src','{{asset('public/assets/admin/img/900x400/img1.jpg')}}');
                location.reload(true);
            })
        </script>
@endpush
