@extends('layouts.vendor.app')

@section('title','Update Food')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('public/assets/admin/css/tags-input.min.css')}}" rel="stylesheet">
@endpush

@section('content')

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title"><i class="tio-edit"></i> {{__('messages.food')}} {{__('messages.update')}}</h1>
        </div>
        <!-- End Page Header -->
        <form action="javascript:" method="post" id="product_form"
                enctype="multipart/form-data">
            @csrf
            @php($language=\App\Models\BusinessSetting::where('key','language')->first())
            @php($language = $language->value ?? null)
            @php($default_lang = 'bn')
            <div class="row g-2">
            @if($language)
                @php($default_lang = json_decode($language)[0])
                <div class="col-lg-12">
                    <ul class="nav nav-tabs mb-4">
                        @foreach(json_decode($language) as $lang)
                            <li class="nav-item">
                                <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#" id="{{$lang}}-link">{{\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-fastfood"></i>
                            </span>
                            <span>{{ translate('Food Info') }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                    @if($language)
                        @foreach(json_decode($language) as $lang)
                            <?php
                                if(count($product['translations'])){
                                    $translate = [];
                                    foreach($product['translations'] as $t)
                                    {
                                        if($t->locale == $lang && $t->key=="name"){
                                            $translate[$lang]['name'] = $t->value;
                                        }
                                        if($t->locale == $lang && $t->key=="description"){
                                            $translate[$lang]['description'] = $t->value;
                                        }
                                    }
                                }
                            ?>
                            <div class="{{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="{{$lang}}_name">{{__('messages.name')}} ({{strtoupper($lang)}})</label>
                                    <input type="text" {{$lang == $default_lang? 'required':''}} name="name[]" id="{{$lang}}_name" class="form-control h--45px" placeholder="{{__('messages.new_food')}}" value="{{$translate[$lang]['name']??$product['name']}}" oninvalid="document.getElementById('en-link').click()">
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}">
                                <div class="form-group pt-4 mb-0">
                                    <label class="form-label" for="exampleFormControlInput1">{{__('messages.short')}} {{__('messages.description')}} ({{strtoupper($lang)}})</label>
                                    <textarea type="text" name="description[]" class="form-control h--45px ckeditor" style="min-height:214px">{!! $translate[$lang]['description']??$product['description'] !!}</textarea>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div id="{{$default_lang}}-form">
                        <div class="form-group mb-0">
                            <label class="form-label" for="exampleFormControlInput1">{{__('messages.name')}} (EN)</label>
                            <input type="text" name="name[]" class="form-control h--45px" placeholder="{{__('messages.new_food')}}" value="{{$product['name']}}" required>
                        </div>
                        <input type="hidden" name="lang[]" value="en">
                        <div class="form-group pt-4 mb-0">
                            <label class="form-label" for="exampleFormControlInput1">{{__('messages.short')}} {{__('messages.description')}}</label>
                            <textarea type="text" name="description[]" class="form-control h--45px ckeditor" style="min-height:214px">{!! $product['description'] !!}</textarea>
                        </div>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="form-label">
                            {{ __('messages.food') }} {{ __('messages.image') }}
                            <small class="text-danger">({{ __('messages.ratio') }} 1:1 )</small>
                        </h5>

                        @if (isset($product['image']))
                            <center id="image-viewer-section" class="py-3 my-auto">
                                <img style="height: 200px;width:200px;object-fit: cover; border-radius: 10px;" id="viewer"
                                    src="{{ asset('storage/app/public/product') }}/{{ $product['image'] }}"
                                    onerror="this.src='{{ asset('/public/assets/admin/img/100x100/food-default-image.png') }}'"
                                    alt="product image" />
                            </center>
                        @else
                            <center id="image-viewer-section" class="py-3 my-auto">
                                <img style="height: 200px;width:200px;object-fit: cover; border-radius: 10px;" id="viewer"
                                    src="{{ asset('public/assets/admin/img/400x400/img2.jpg') }}" alt="banner image" />
                            </center>
                        @endif
                        <div class="custom-file">
                            <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                            <label class="custom-file-label" for="customFileEg1">{{ __('messages.choose') }}
                                {{ __('messages.file') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-dashboard-outlined"></i>
                            </span>
                            <span> {{ translate('Food Details') }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="exampleFormControlSelect1">{{__('messages.category')}}<span
                                            class="form-label-secondary">*</span></label>
                                    <select name="category_id" id="category-id" class="form-control h--45px js-select2-custom"
                                            onchange="getRequest('{{url('/')}}/vendor-panel/food/get-categories?parent_id='+this.value,'sub-categories')">
                                        @foreach($categories as $category)
                                            <option
                                                value="{{$category['id']}}" {{ $category->id==$product_category[0]->id ? 'selected' : ''}} >{{$category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="exampleFormControlSelect1">{{__('messages.sub_category')}}<span
                                            class="form-label-secondary"></span></label>
                                    <select name="sub_category_id" id="sub-categories"
                                            data-id="{{count($product_category)>=2?$product_category[1]->id:''}}"
                                            class="form-control h--45px js-select2-custom"
                                            onchange="getRequest('{{url('/')}}/vendor-panel/food/get-categories?parent_id='+this.value,'sub-sub-categories')">

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="exampleFormControlInput1">{{__('messages.item_type')}}</label>
                                    <select name="veg" class="form-control h--45px js-select2-custom">
                                        <option value="0" {{$product['veg']==0?'selected':''}}>{{__('messages.non_veg')}}</option>
                                        <option value="1" {{$product['veg']==1?'selected':''}}>{{__('messages.veg')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon"><i class="tio-dollar-outlined"></i></span>
                            <span>{{ translate('Amount') }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="exampleFormControlInput1">{{__('messages.price')}}</label>
                                    <input type="number" value="{{$product['price']}}" min="0" max="100000" name="price"
                                        class="form-control h--45px" step="0.01"
                                        placeholder="Ex : 100" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="exampleFormControlInput1">{{__('messages.discount')}} {{__('messages.type')}}</label>
                                    <select name="discount_type" class="form-control h--45px js-select2-custom">
                                        <option value="percent" {{$product['discount_type']=='percent'?'selected':''}}>
                                            {{__('messages.percent')}}
                                        </option>
                                        <option value="amount" {{$product['discount_type']=='amount'?'selected':''}}>
                                            {{__('messages.amount')}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="exampleFormControlInput1">{{__('messages.discount')}}</label>
                                    <input type="number" min="0" value="{{$product['discount']}}" max="100000"
                                        name="discount" class="form-control h--45px"
                                        placeholder="Ex : 100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-canvas-text"></i>
                            </span>
                            <span>{{ translate('Add Attribute') }}</span>
                        </h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <select name="attribute_id[]" id="choice_attributes"
                                            class="form-control h--45px js-select2-custom"
                                            multiple="multiple">
                                        @foreach(\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                            <option
                                                value="{{$attribute['id']}}" {{in_array($attribute->id,json_decode($product['attributes'],true))?'selected':''}}>{{$attribute['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="customer_choice_options row" id="customer_choice_options">
                                    @include('vendor-views.product.partials._choices',['choice_no'=>json_decode($product['attributes']),'choice_options'=>json_decode($product['choice_options'],true)])
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="variant_combination" id="variant_combination">
                                    @include('vendor-views.product.partials._edit-combinations',['combinations'=>json_decode($product['variations'],true)])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-canvas-text"></i>
                            </span>
                            <span>Addon</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <select name="addon_ids[]" class="form-control h--45px js-select2-custom" multiple="multiple">
                                @foreach(\App\Models\AddOn::where('restaurant_id', \App\CentralLogics\Helpers::get_restaurant_id())->orderBy('name')->get() as $addon)
                                    <option
                                        value="{{$addon['id']}}" {{in_array($addon->id,json_decode($product['add_ons'],true))?'selected':''}}>{{$addon['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="exampleFormControlInput1">{{__('messages.available')}} {{__('messages.time')}} {{__('messages.starts')}}</label>
                                    <input type="time" value="{{$product['available_time_starts']}}"
                                        name="available_time_starts" class="form-control h--45px"
                                        placeholder="Ex : 10:30 am" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <label class="form-label" for="exampleFormControlInput1">{{__('messages.available')}} {{__('messages.time')}} {{__('messages.ends')}}</label>
                                    <input type="time" value="{{$product['available_time_ends']}}"
                                        name="available_time_ends" class="form-control h--45px" placeholder="5:45 pm"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="btn--container justify-content-end mt-2">
                    <button type="reset" id="reset_btn" class="btn btn--reset">{{__('messages.reset')}}</button>
                    <button type="submit" class="btn btn--primary">{{__('messages.update')}}</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('script')

@endpush

@push('script_2')
    <script>
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
            $('#image-viewer-section').show(1000)
        });

        $(document).ready(function () {
            setTimeout(function () {
                let category = $("#category-id").val();
                let sub_category = '{{count($product_category)>=2?$product_category[1]->id:''}}';
                let sub_sub_category ='{{count($product_category)>=3?$product_category[2]->id:''}}';
                getRequest('{{url('/')}}/vendor-panel/food/get-categories?parent_id=' + category + '&&sub_category=' + sub_category, 'sub-categories');
                getRequest('{{url('/')}}/vendor-panel/food/get-categories?parent_id=' + sub_category + '&&sub_category=' + sub_sub_category, 'sub-sub-categories');
            }, 1000)
        });
    </script>

    <script>
        $(document).on('ready', function () {
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>


    <script src="{{asset('public/assets/admin')}}/js/tags-input.min.js"></script>

    <script>
        $('#choice_attributes').on('change', function () {
            combination_update();
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name;
            $('#customer_choice_options').append('<div class="col-lg-6 attr--item-added"><div class="left"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control h--45px" name="choice[]" value="' + n + '" placeholder="{{__('messages.choice_title')}}" readonly></div><div class="right"><input type="text" class="form-control h--45px" name="choice_options_' + i + '[]" placeholder="{{__('messages.enter_choice_values')}}" data-role="tagsinput" onchange="combination_update()"></div></div>');
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        setTimeout(function () {
            $('.call-update-sku').on('change', function () {
                combination_update();
            });
        }, 2000)

        $('#colors-selector').on('change', function () {
            combination_update();
        });

        $('input[name="unit_price"]').on('keyup', function () {
            combination_update();
        });

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{route('vendor.food.variant-combination')}}',
                data: $('#product_form').serialize(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#loading').hide();
                    $('#variant_combination').html(data.view);
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }
    </script>

    <script>
        $('#product_form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('vendor.food.update',[$product['id']])}}',
                data: $('#product_form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#loading').hide();
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{__('messages.product_updated_successfully')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '{{route('vendor.food.list')}}';
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
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == 'en')
            {
                $("#from_part_2").removeClass('d-none');
            }
            else
            {
                $("#from_part_2").addClass('d-none');
            }
        })
        $('#reset_btn').click(function(){
            location.reload(true);
        })
    </script>
@endpush


