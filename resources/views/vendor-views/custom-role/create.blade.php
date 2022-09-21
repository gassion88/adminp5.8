@extends('layouts.vendor.app')
@section('title','Create Role')
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
     <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h2 class="page-header-title text-capitalize">
                    <div class="card-header-icon d-inline-flex mr-2 img">
                        <img src="{{asset('/public/assets/admin/img/resturant-panel/page-title/employee-role.png')}}" alt="public">
                    </div>
                    <span>
                        {{ translate('Employee Role') }}
                    </span>
                </h2>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title my-1">
                        <span class="card-header-icon">
                            <i class="tio-document-text-outlined"></i>
                        </span>
                        <span>
                            {{__('messages.role_form')}}
                        </span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="px-xl-2">
                        <form action="{{route('vendor.custom-role.create')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="name">{{__('messages.role_name')}}</label>
                                <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"
                                    placeholder="Ex : Store" required>
                            </div>

                            <h5 class="form-label">{{__('messages.module_permission')}} : </h5>
                            <div class="check--item-wrapper mx-0">
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="food" class="form-check-input"
                                            id="food">
                                        <label class="form-check-label input-label qcont" for="food">{{__('messages.food')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                            id="order">
                                        <label class="form-check-label input-label qcont" for="order">{{__('messages.order')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="restaurant_setup" class="form-check-input"
                                            id="restaurant_setup">
                                        <label class="form-check-label input-label qcont" for="restaurant_setup">{{__('messages.restaurant')}} {{__('messages.setup')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="addon" class="form-check-input"
                                            id="addon">
                                        <label class="form-check-label input-label qcont" for="addon">{{__('messages.addon')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="wallet" class="form-check-input"
                                            id="wallet">
                                        <label class="form-check-label input-label qcont" for="wallet">{{__('messages.wallet')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="bank_info" class="form-check-input"
                                            id="bank_info">
                                        <label class="form-check-label input-label qcont" for="bank_info">{{__('messages.bank_info')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                            id="employee">
                                        <label class="form-check-label input-label qcont" for="employee">{{__('messages.Employee')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="my_shop" class="form-check-input"
                                            id="my_shop">
                                        <label class="form-check-label input-label qcont" for="my_shop">{{__('messages.my_shop')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="custom_role" class="form-check-input"
                                            id="custom_role">
                                        <label class="form-check-label input-label qcont" for="custom_role">{{__('messages.custom_role')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="campaign" class="form-check-input"
                                            id="campaign">
                                        <label class="form-check-label input-label qcont" for="campaign">{{__('messages.campaign')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="reviews" class="form-check-input"
                                            id="reviews">
                                        <label class="form-check-label input-label qcont" for="reviews">{{__('messages.reviews')}}</label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="pos" class="form-check-input"
                                            id="pos">
                                        <label class="form-check-label input-label qcont" for="pos">{{__('messages.pos')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container mt-4 justify-content-end">
                                <button type="reset" class="btn btn--reset">{{__('messages.reset')}}</button>
                                <button type="submit" class="btn btn--primary">{{__('messages.submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0 py-2">
                    <div class="search--button-wrapper">
                        <h5 class="card-title">{{__('messages.roles_table')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$rl->total()}}</span></h5>
                        <form action="javascript:" id="search-form">
                            @csrf
                            <!-- Search -->
                            <div class="input-group input--group">
                                <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="Ex :  Search by Role Name" aria-label="{{__('messages.search')}}">
                                <button type="submit" class="btn btn--secondary">
                                    <i class="tio-search"></i>
                                </button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 70px">SL</th>
                                    <th scope="col" style="width: 100px">{{__('messages.role_name')}}</th>
                                    <th scope="col" style="width: 200px">{{__('messages.modules')}}</th>
                                    <th scope="col" style="width: 80px">{{__('messages.created_at')}}</th>
                                    {{--<th scope="col" style="width: 80px">{{__('messages.status')}}</th>--}}
                                    <th scope="col" class="text-center" style="width: 80px">{{__('messages.action')}}</th>
                                </tr>
                            </thead>
                            <tbody  id="set-rows">
                            @foreach($rl as $k=>$r)
                                <tr>
                                    <td scope="row">{{$k+$rl->firstItem()}}</td>
                                    <td>{{Str::limit($r['name'],20,'...')}}</td>
                                    <td class="text-capitalize">
                                        @if($r['modules']!=null)
                                            @foreach((array)json_decode($r['modules']) as $key=>$m)
                                               {{str_replace('_',' ',$m)}},
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{date('d-M-y',strtotime($r['created_at']))}}</td>
                                    {{--<td>
                                        {{$r->status?'Active':'Inactive'}}
                                    </td>--}}
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary"
                                                href="{{route('vendor.custom-role.edit',[$r['id']])}}" title="{{__('messages.edit')}} {{__('messages.role')}}"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                                onclick="form_alert('role-{{$r['id']}}','{{__('messages.Want_to_delete_this_role')}}')" title="{{__('messages.delete')}} {{__('messages.role')}}"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="{{route('vendor.custom-role.delete',[$r['id']])}}"
                                                    method="post" id="role-{{$r['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(count($rl) === 0)
                        <div class="empty--data">
                            <img src="{{asset('/public/assets/admin/img/empty.png')}}" alt="public">
                            <h5>
                                {{translate('no_data_found')}}
                            </h5>
                        </div>
                        @endif
                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $rl->links() !!}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
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
                url: '{{route('vendor.custom-role.search')}}',
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
        $(document).ready(function() {
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));
        });
    </script>
@endpush
