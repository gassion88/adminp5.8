@extends('layouts.admin.app')

@section('title', 'Food List')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-auto mb-md-0 mb-3 mr-auto">
                    <h1 class="page-header-title"> {{ __('messages.food') }} {{ __('messages.list') }}<span
                            class="badge badge-soft-dark ml-2" id="foodCount">{{ $foods->total() }}</span></h1>
                </div>
                @if ($toggle_veg_non_veg)
                    <!-- Veg/NonVeg filter -->
                    <div class="col-md-auto mb-3 mb-md-0">
                        <select name="category_id" onchange="set_filter('{{ url()->full() }}',this.value, 'type')"
                            data-placeholder="{{ __('messages.all') }}" class="form-control">
                            <option value="all" {{ $type == 'all' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                            <option value="veg" {{ $type == 'veg' ? 'selected' : '' }}>{{ __('messages.veg') }}</option>
                            <option value="non_veg" {{ $type == 'non_veg' ? 'selected' : '' }}>{{ __('messages.non_veg') }}
                            </option>
                        </select>
                    </div>
                    <!-- End Veg/NonVeg filter -->
                @endif
                <div class="col-md-auto mb-3 mb-md-0 min-240">
                    <select name="restaurant_id" id="restaurant"
                        onchange="set_restaurant_filter('{{ url()->full() }}',this.value)"
                        data-placeholder="{{ __('messages.select') }} {{ __('messages.restaurant') }}"
                        class="js-data-example-ajax form-control"
                        onchange="getRestaurantData('{{ url('/') }}/admin/vendor/get-addons?data[]=0&restaurant_id=',this.value,'add_on')"
                        required title="Select Restaurant"
                        oninvalid="this.setCustomValidity('{{ __('messages.please_select_restaurant') }}')">
                        @if ($restaurant)
                            <option value="{{ $restaurant->id }}" selected>{{ $restaurant->name }}</option>
                        @else
                            <option value="all" selected>{{ __('messages.all_restaurants') }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-auto mb-3 mb-md-0 min-240">
                    <!-- Unfold -->
                    <div class="hs-unfold w-100">
                        <select name="category_id" id="category"
                            onchange="set_filter('{{ url()->full() }}',this.value, 'category_id')"
                            data-placeholder="{{ __('messages.select_category') }}"
                            class="js-data-example-ajax form-control">
                            @if ($category)
                                <option value="{{ $category->id }}" selected>{{ $category->name }}
                                    ({{ $category->position == 0 ? __('messages.main') : __('messages.sub') }})
                                </option>
                            @else
                                <option value="all" selected>{{ __('messages.all_categories') }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <!-- End Unfold -->
            </div>

        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header border-0 py-2">
                        <div class="search--button-wrapper">
                            <h5 class="card-title d-none d-xl-block"></h5>
                            <form id="search-form">
                                @csrf
                                <!-- Search -->
                                <div class="input--group input-group input-group-merge input-group-flush">
                                    <input id="datatableSearch" name="search" type="search" class="form-control"
                                        placeholder="{{translate('Search_by_name')}}"
                                        aria-label="{{ __('messages.search_here') }}">
                                    <button type="submit" class="btn btn--secondary">
                                        <i class="tio-search"></i>
                                    </button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <!-- Unfold -->
                            <div class="hs-unfold m-2 ml-lg-3">
                                <a class="js-hs-unfold-invoker btn btn-white" href="javascript:;"
                                    data-hs-unfold-options='{
                                        "target": "#showHideDropdown",
                                        "type": "css-animation"
                                        }'>
                                    <i class="tio-table mr-1"></i> {{ __('messages.columns') }} <span
                                        class="badge badge-soft-dark rounded-circle ml-1">7</span>
                                </a>

                                <div id="showHideDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right dropdown-card">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            {{--<div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">#</span>
                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_index">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_index" checked>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>--}}
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">{{ __('messages.name') }}</span>
                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_name">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_name" checked>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">{{ __('messages.category') }}</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_type">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_type" checked>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">{{ __('messages.restaurant') }}</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_vendor">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_vendor" checked>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>


                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">{{ __('messages.status') }}</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_status">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_status" checked>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">{{ __('messages.price') }}</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_price">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_price" checked>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="mr-2">{{ __('messages.action') }}</span>

                                                <!-- Checkbox Switch -->
                                                <label class="toggle-switch toggle-switch-sm" for="toggleColumn_action">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_action" checked>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                                <!-- End Checkbox Switch -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Unfold -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom" id="table-div">
                        <table id="datatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                                    "columnDefs": [{
                                        "targets": [],
                                        "width": "5%",
                                        "orderable": false
                                    }],
                                    "order": [],
                                    "info": {
                                    "totalQty": "#datatableWithPaginationInfoTotalQty"
                                    },

                                    "entries": "#datatableEntries",

                                    "isResponsive": false,
                                    "isShowPaging": false,
                                    "paging":false
                                }'>
                            <thead class="thead-light">
                                <tr>
                                    <th class="w-60px">SL</th>
                                    <th class="w-100px">{{ __('messages.name') }}</th>
                                    <th class="w-120px">{{ __('messages.category') }}</th>
                                    <th class="w-120px">{{ __('messages.restaurant') }}</th>
                                    <th class="w-100px">{{ __('messages.price') }}</th>
                                    <th class="w-100px">{{ __('messages.status') }}</th>
                                    <th class="w-120px" class="text-center">
                                        {{ __('messages.action') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="set-rows">
                                @foreach ($foods as $key => $food)
                                    <tr>
                                        <td>{{ $key + $foods->firstItem() }}</td>
                                        <td>
                                            <a class="media align-items-center"
                                                href="{{ route('admin.food.view', [$food['id']]) }}">
                                                <img class="avatar avatar-lg mr-3"
                                                    src="{{ asset('storage/app/public/product') }}/{{ $food['image'] }}"
                                                    onerror="this.src='{{ asset('public/assets/admin/img/100x100/food-default-image.png') }}'"
                                                    alt="{{ $food->name }} image">
                                                <div class="media-body">
                                                    <h5 class="text-hover-primary mb-0">
                                                        {{ Str::limit($food['name'], 20, '...') }}</h5>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            {{ Str::limit($food->category, 20, '...') }}
                                        </td>
                                        <td>
                                            @if ($food->restaurant)
                                                <a class="text--title" href="{{route('admin.vendor.view',['restaurant'=>$food->restaurant_id])}}" title="{{translate('view_restaurant')}}">
                                                    {{ Str::limit($food->restaurant->name, 20, '...') }}
                                                </a>
                                            @else
                                                <span class="text--danger text-capitalize">{{ Str::limit( __('messages.Restaurant deleted!'), 20, '...') }}<span>
                                            @endif
                                        </td>
                                        <td>{{ \App\CentralLogics\Helpers::format_currency($food['price']) }}</td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm"
                                                for="stocksCheckbox{{ $food->id }}">
                                                <input type="checkbox"
                                                    onclick="location.href='{{ route('admin.food.status', [$food['id'], $food->status ? 0 : 1]) }}'"
                                                    class="toggle-switch-input" id="stocksCheckbox{{ $food->id }}"
                                                    {{ $food->status ? 'checked' : '' }}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                                    href="{{ route('admin.food.edit', [$food['id']]) }}"
                                                    title="{{ __('messages.edit') }} {{ __('messages.food') }}"><i
                                                        class="tio-edit"></i>
                                                </a>
                                                <a class="btn btn-sm btn--warning btn-outline-warning action-btn" href="javascript:"
                                                    onclick="form_alert('food-{{ $food['id'] }}','{{ __('messages.Want_to_delete_this_item') }}')"
                                                    title="{{ __('messages.delete') }} {{ __('messages.food') }}"><i
                                                        class="tio-delete-outlined"></i>
                                                </a>
                                            </div>
                                            <form action="{{ route('admin.food.delete', [$food['id']]) }}" method="post"
                                                id="food-{{ $food['id'] }}">
                                                @csrf @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(count($foods) === 0)
                    <div class="empty--data">
                        <img src="{{asset('/public/assets/admin/img/empty.png')}}" alt="public">
                        <h5>
                            {{translate('no_data_found')}}
                        </h5>
                    </div>
                    @endif
                    <div class="page-area px-4 pb-3">
                        <div class="d-flex align-items-center justify-content-end">
                                                {{-- <div>
                        1-15 of 380
                    </div> --}}
                            <div>
                                {!! $foods->withQueryString()->links() !!}
                            </div>
                        </div>
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
        $(document).on('ready', function() {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
                select: {
                    style: 'multi',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                language: {
                    zeroRecords: '<div class="text-center p-4">' +
                        '<img class="mb-3" src="{{ asset('public/assets/admin/svg/illustrations/sorry.svg') }}" alt="Image Description" style="width: 7rem;">' +
                        '<p class="mb-0">No data to show</p>' +
                        '</div>'
                }
            });

            $('#datatableSearch').on('mouseup', function(e) {
                var $input = $(this),
                    oldValue = $input.val();

                if (oldValue == "") return;

                setTimeout(function() {
                    var newValue = $input.val();

                    if (newValue == "") {
                        // Gotcha
                        datatable.search('').draw();
                    }
                }, 1);
            });

            $('#toggleColumn_index').change(function(e) {
                datatable.columns(0).visible(e.target.checked)
            })
            $('#toggleColumn_name').change(function(e) {
                datatable.columns(1).visible(e.target.checked)
            })

            $('#toggleColumn_type').change(function(e) {
                datatable.columns(2).visible(e.target.checked)
            })

            $('#toggleColumn_vendor').change(function(e) {
                datatable.columns(3).visible(e.target.checked)
            })

            $('#toggleColumn_status').change(function(e) {
                datatable.columns(5).visible(e.target.checked)
            })
            $('#toggleColumn_price').change(function(e) {
                datatable.columns(4).visible(e.target.checked)
            })
            $('#toggleColumn_action').change(function(e) {
                datatable.columns(6).visible(e.target.checked)
            })

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#restaurant').select2({
            ajax: {
                url: '{{ url('/') }}/admin/vendor/get-restaurants',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        all: true,
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

        $('#category').select2({
            ajax: {
                url: '{{ route('admin.category.get-all') }}',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        all: true,
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

        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.food.search') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                    $('#foodCount').html(data.count);
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
