@extends('layouts.admin.app')

@section('title','Food Bulk Export')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <h1 class="page-header-title text-capitalize">
                <div class="card-header-icon d-inline-flex mr-2 img">
                    <img src="{{asset('/public/assets/admin/img/export.png')}}" alt="">
                </div>
                {{ translate('Export Foods') }}
            </h1>
        </div>

        <div class="card mt-2 rest-part">
            <div class="card-body">
                <div class="export-steps">
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5>{{ translate('STEP 1') }}</h5>
                            <p>
                                {{ translate('Select Data Type') }}
                            </p>
                        </div>
                    </div>
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5>{{ translate('STEP 2') }}</h5>
                            <p>
                                {{ translate('Select Data Range by Date and Export') }}
                            </p>
                        </div>
                    </div>
                </div>
                <form class="product-form" action="{{route('admin.food.bulk-export')}}" method="POST"
                        enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="exampleFormControlSelect1">{{__('messages.type')}}<span
                                        class="input-label-secondary"></span></label>
                                <select name="type" id="type" data-placeholder="{{__('messages.select')}} {{__('messages.type')}}" class="form-control" required title="Select Type">
                                    <option value="all">{{__('messages.all')}} {{__('messages.data')}}</option>
                                    <option value="date_wise">{{__('messages.date')}} {{__('messages.wise')}}</option>
                                    <option value="id_wise">{{__('messages.id')}} {{__('messages.wise')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group id_wise">
                                <label class="form-label" for="exampleFormControlSelect1">{{__('messages.start')}} {{__('messages.id')}}<span
                                        class="input-label-secondary"></span></label>
                                <input type="number" name="start_id" class="form-control">
                            </div>
                            <div class="form-group date_wise">
                                <label class="form-label" for="exampleFormControlSelect1">{{__('messages.from')}} {{__('messages.date')}}<span
                                        class="input-label-secondary"></span></label>
                                <input type="date" name="from_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group id_wise">
                                <label class="form-label" for="exampleFormControlSelect1">{{__('messages.end')}} {{__('messages.id')}}<span
                                        class="input-label-secondary"></span></label>
                                <input type="number" name="end_id" class="form-control">
                            </div>
                            <div class="form-group date_wise">
                                <label class="input-label text-capitalize" for="exampleFormControlSelect1">{{__('messages.to')}} {{__('messages.date')}}<span
                                        class="input-label-secondary"></span></label>
                                <input type="date" name="to_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end">
                        <button class="btn btn--reset" type="reset">{{__('messages.reset')}}</button>
                        <button class="btn btn--primary" type="submit">{{__('messages.export')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
<script>
    $(document).on('ready', function (){
        $('.id_wise').hide();
        $('.date_wise').hide();
        $('#type').on('change', function()
        {
            $('.id_wise').hide();
            $('.date_wise').hide();
            $('.'+$(this).val()).show();
        })
    });
</script>
@endpush
