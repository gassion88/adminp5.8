@extends('layouts.admin.app')

@section('title', 'Add new food')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-add-circle-outlined"></i> {{ __('messages.add') }}
                        {{ __('messages.new') }} {{ __('messages.food') }}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="javascript:" method="post" id="food_form" enctype="multipart/form-data">
                    @csrf
                    @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
                    @php($language = $language->value ?? null)
                    @php($default_lang = 'bn')
                    <div class="row g-2">
                        @if($language)
                            @php($default_lang = json_decode($language)[0])
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs mb-4">
                                    @foreach (json_decode($language) as $lang)
                                        <li class="nav-item">
                                            <a class="nav-link lang_link {{ $lang == $default_lang ? 'active' : '' }}" href="#"
                                                id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
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
                                @if ($language)
                                    <div class="card-body">
                                    @foreach (json_decode($language) as $lang)
                                        <div class="{{ $lang != $default_lang ? 'd-none' : '' }} lang_form"
                                            id="{{ $lang }}-form">
                                            <div class="form-group">
                                                <label class="input-label" for="{{ $lang }}_name">{{ __('messages.name') }}
                                                    ({{ strtoupper($lang) }})</label>
                                                <input type="text" name="name[]" id="{{ $lang }}_name" class="form-control"
                                                    placeholder="{{ __('messages.new_food') }}"
                                                    {{ $lang == $default_lang ? 'required' : '' }}
                                                    oninvalid="document.getElementById('en-link').click()">
                                            </div>
                                            <input type="hidden" name="lang[]" value="{{ $lang }}">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1">{{ __('messages.short') }}
                                                    {{ __('messages.description') }} ({{ strtoupper($lang) }})</label>
                                                <textarea type="text" name="description[]" class="form-control ckeditor min-height-154px"></textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                @else
                                    <div class="card-body">
                                        <div id="{{ $default_lang }}-form">
                                            <div class="form-group">
                                                <label class="input-label" for="exampleFormControlInput1">{{ __('messages.name') }}
                                                    (EN)</label>
                                                <input type="text" name="name[]" class="form-control"
                                                    placeholder="{{ __('messages.new_food') }}" required>
                                            </div>
                                            <input type="hidden" name="lang[]" value="en">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1">{{ __('messages.short') }}
                                                    {{ __('messages.description') }}</label>
                                                <textarea type="text" name="description[]" class="form-control ckeditor min-height-154px"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <span class="card-header-icon"><i class="tio-image"></i></span>
                                        <span>Food Image <small class="text-danger">(Ratio 200x200)</small></span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0 h-100 d-flex flex-column">
                                        <center id="image-viewer-section" class="my-auto">
                                            <img class="initial-52" id="viewer"
                                                src="{{ asset('/public/assets/admin/img/100x100/food-default-image.png') }}" alt="banner image" />
                                        </center>
                                        <div class="custom-file mt-3">
                                            <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="customFileEg1">{{ __('messages.choose') }}
                                                {{ __('messages.file') }}</label>
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
                                            <i class="tio-dashboard-outlined"></i>
                                        </span>
                                        <span> {{ translate('Food Details') }}</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlSelect1">{{ __('messages.restaurant') }}<span
                                                        class="input-label-secondary"></span></label>
                                                <select name="restaurant_id" id="restaurant_id"
                                                    data-placeholder="{{ __('messages.select') }} {{ __('messages.restaurant') }}"
                                                    class="js-data-example-ajax form-control"
                                                    onchange="getRestaurantData('{{ url('/') }}/admin/vendor/get-addons?data[]=0&restaurant_id=',this.value,'add_on')"
                                                    oninvalid="this.setCustomValidity('{{ __('messages.please_select_restaurant') }}')">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlSelect1">{{ __('messages.category') }}<span
                                                        class="input-label-secondary">*</span></label>
                                                <select name="category_id" id="category_id" class="form-control js-select2-custom"
                                                    onchange="getRequest('{{ url('/') }}/admin/food/get-categories?parent_id='+this.value,'sub-categories')" oninvalid="this.setCustomValidity('Select Category')">
                                                    <option value="" selected disabled>{{ translate('Select Category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlSelect1">{{ __('messages.sub_category') }}<span
                                                        class="input-label-secondary"
                                                        data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.category_required_warning') }}"><img
                                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                            alt="{{ __('messages.category_required_warning') }}"></span></label>
                                                <select name="sub_category_id" id="sub-categories" class="form-control js-select2-custom">
                                                    <option value="" selected disabled>{{ translate('Select Sub Category') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1">{{ __('messages.item_type') }}</label>
                                                <select name="veg" id="veg" class="form-control js-select2-custom">
                                                    <option value="" selected disabled>Select Preferences</option>
                                                    <option value="0">{{ __('messages.non_veg') }}</option>
                                                    <option value="1">{{ __('messages.veg') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlSelect1">{{ __('messages.addon') }}<span
                                                        class="input-label-secondary"
                                                        data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.restaurant_required_warning') }}"><img
                                                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                            alt="{{ __('messages.restaurant_required_warning') }}"></span></label>
                                                <select name="addon_ids[]" class="form-control border js-select2-custom" multiple="multiple"
                                                    id="add_on">

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
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1">{{ __('messages.price') }}</label>
                                                <input type="number" min="0" max="999999999999.99" step="0.01" value="1" name="price"
                                                    class="form-control" placeholder="Ex : 100" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1">{{ __('messages.discount') }}
                                                    {{ __('messages.type') }}</label>
                                                <select name="discount_type" class="form-control js-select2-custom">
                                                    <option value="percent">{{ __('messages.percent') }}</option>
                                                    <option value="amount">{{ __('messages.amount') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1">{{ __('messages.discount') }}</label>
                                                <input type="number" min="0" max="9999999999999999999999" value="0" name="discount"
                                                    class="form-control" placeholder="Ex : 100">
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
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlSelect1">{{ __('messages.attribute') }}<span
                                                        class="input-label-secondary"></span></label>
                                                <select name="attribute_id[]" id="choice_attributes" class="form-control border js-select2-custom"
                                                    multiple="multiple">
                                                    @foreach (\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                                        <option value="{{ $attribute['id'] }}">{{ $attribute['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="customer_choice_options" id="customer_choice_options">

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="variant_combination" id="variant_combination">

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
                                        <span class="card-header-icon"><i class="tio-date-range"></i></span>
                                        <span>{{ translate('Time Schedule') }}</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1">{{ __('messages.available') }}
                                                    {{ __('messages.time') }} {{ __('messages.starts') }}</label>
                                                <input type="time" name="available_time_starts" class="form-control"
                                                    id="available_time_starts" placeholder="Ex : 10:30 am" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1">{{ __('messages.available') }}
                                                    {{ __('messages.time') }} {{ __('messages.ends') }}</label>
                                                <input type="time" name="available_time_ends" class="form-control"
                                                    id="available_time_ends" placeholder="5:45 pm" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="btn--container justify-content-end">
                                <button type="reset" id="reset_btn" class="btn btn--reset">{{ __('messages.reset') }}</button>
                                <button type="submit" class="btn btn--primary">{{ __('messages.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('script_2')
    <script>
        function getRestaurantData(route, restaurant_id, id) {
            $.get({
                url: route + restaurant_id,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
            $('#image-viewer-section').show(1000);
        });
    </script>

    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ url('/') }}/admin/vendor/get-restaurants',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });
    </script>


    <script src="{{ asset('public/assets/admin') }}/js/tags-input.min.js"></script>

    <script>
        $('#choice_attributes').on('change', function() {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function() {
                if ($(this).val().length > 50) {
                    toastr.error(
                        '{{ __('validation.max.string', ['attribute' => __('messages.variation'), 'max' => '50']) }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    return false;
                }
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name;
            $('#customer_choice_options').append(
                '<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i +
                '"><input type="text" class="form-control" name="choice[]" value="' + n +
                '" placeholder="{{ __('messages.choice_title') }}" readonly></div><div class="col-md-9"><input type="text" class="form-control" name="choice_options_' +
                i +
                '[]" placeholder="{{ __('messages.enter_choice_values') }}" data-role="tagsinput" onchange="combination_update()"></div></div>'
                );
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
                url: '{{ route('admin.food.variant-combination') }}',
                data: $('#food_form').serialize(),
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
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
        $('#food_form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.food.store') }}',
                data: $('#food_form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{ __('messages.product_added_successfully') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href =
                                '{{ \Request::server('HTTP_REFERER') ?? route('admin.food.list') }}';
                        }, 2000);
                    }
                }
            });
        });
    </script>
    <script>
        $(".lang_link").click(function(e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{ $default_lang }}') {
                $("#from_part_2").removeClass('d-none');
            } else {
                $("#from_part_2").addClass('d-none');
            }
        })
    </script>
            <script>
                $('#reset_btn').click(function(){
                    $('#restaurant_id').val(null).trigger('change');
                    $('#category_id').val(null).trigger('change');
                    $('#categories').val(null).trigger('change');
                    $('#sub-veg').val(0).trigger('change');
                    $('#add_on').val(null).trigger('change');
                    $('#choice_attributes').val(null).trigger('change');
                    $('#customer_choice_options').val(null).trigger('change');
                    $('#variant_combination').empty().trigger('change');
                    $('#viewer').attr('src','{{asset('public/assets/admin/img/900x400/img1.jpg')}}');
                })
            </script>
@endpush
