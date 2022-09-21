@extends('layouts.vendor.app')
@section('title','Employee List')
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
                        {{trans('messages.Employee')}} {{trans('messages.list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$em->total()}}</span>
                    </span>
                </h2>
            </div>
            <div class="col-sm">
                <a href="{{route('vendor.employee.add-new')}}" class="btn btn--primary  float-right">
                    <i class="tio-add-circle"></i>
                    <span class="text">
                        {{trans('Add New Employee')}}
                    </span>
                </a>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <div class="card">
        <div class="card-header py-2">
            <div class="search--button-wrapper">
                <span class="card-title"></span>
                <form action="javascript:" id="search-form">
                    @csrf
                    <!-- Search -->
                    <div class="input-group input--group">
                        <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="Ex : Search by Employee Name, Email or Phone No" aria-label="Search">
                        <button type="submit" class="btn btn--secondary">
                            <i class="tio-search"></i>
                        </button>
                    </div>
                    <!-- End Search -->
                </form>

                <!-- Export Button -->
                <div class="hs-unfold ml-3">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn btn-outline-primary btn--primary font--sm" href="javascript:;"
                        data-hs-unfold-options='{
                            "target": "#usersExportDropdown",
                            "type": "css-animation"
                        }'>
                        <i class="tio-download-to mr-1"></i> {{__('messages.export')}}
                    </a>

                    <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        {{--<span class="dropdown-header">{{__('messages.options')}}</span>
                        <a id="export-copy" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/illustrations/copy.svg"
                                    alt="Image Description">
                            {{__('messages.copy')}}
                        </a>
                        <a id="export-print" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/illustrations/print.svg"
                                    alt="Image Description">
                            {{__('messages.print')}}
                        </a>
                        <div class="dropdown-divider"></div>--}}
                        <span class="dropdown-header">{{__('messages.download')}} {{__('messages.options')}}</span>
                        <a id="export-excel" class="dropdown-item" href="{{route('vendor.employee.export-employee', ['type'=>'excel'])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/excel.svg"
                                    alt="Image Description">
                            {{__('messages.excel')}}
                        </a>
                        <a id="export-csv" class="dropdown-item" href="{{route('vendor.employee.export-employee', ['type'=>'csv'])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                            .{{__('messages.csv')}}
                        </a>
                        {{--<a id="export-pdf" class="dropdown-item" href="javascript:;">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('public/assets/admin')}}/svg/components/pdf.svg"
                                    alt="Image Description">
                            {{__('messages.pdf')}}
                        </a>--}}
                    </div>
                </div>
                <!-- Export Button -->

            </div>
        </div>
        <div class="card-body" style="padding: 0">
            <div class="table-responsive">
                <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        style="width: 100%" data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th>SL</th>
                        <th>{{trans('messages.name')}}</th>
                        <th>{{trans('messages.email')}}</th>
                        <th>{{trans('messages.phone')}}</th>
                        <th>{{trans('messages.Role')}}</th>
                        <th style="width: 100px;text-align:center">{{trans('messages.action')}}</th>
                    </tr>
                    </thead>
                    <tbody id="set-rows">
                    @foreach($em as $k=>$e)
                        <tr>
                            <th scope="row">{{$k+$em->firstItem()}}</th>
                            <td class="text-capitalize text-break text-hover-primary">{{$e['f_name']}} {{$e['l_name']}}</td>
                            <td >
                                {{$e['email']}}
                            </td>
                            <td>{{$e['phone']}}</td>
                            <td>{{$e->role?$e->role['name']:__('messages.role_deleted')}}</td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="{{route('vendor.employee.edit',[$e['id']])}}" title="{{__('messages.edit')}} {{__('messages.Employee')}}"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                        onclick="form_alert('employee-{{$e['id']}}','{{__('messages.Want_to_delete_this_role')}}')" title="{{__('messages.delete')}} {{__('messages.Employee')}}"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="{{route('vendor.employee.delete',[$e['id']])}}"
                                            method="post" id="employee-{{$e['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(count($em) === 0)
                <div class="empty--data">
                    <img src="{{asset('/public/assets/admin/img/empty.png')}}" alt="public">
                    <h5>
                        {{translate('no_data_found')}}
                    </h5>
                </div>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <div class="page-area">
                <table>
                    <tfoot>
                    {!! $em->links() !!}
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- Card -->
</div>
@endsection

@push('script_2')
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('vendor.employee.search')}}',
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
