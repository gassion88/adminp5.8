@extends('layouts.admin.app')

@section('title','Restaurant Bulk Import')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title mb-2 text-capitalize">
                <div class="card-header-icon d-inline-flex mr-2 img">
                    <img src="{{asset('/public/assets/admin/img/export.png')}}" alt="">
                </div>
                    {{translate('messages.Restaurant')}} {{__('messages.bulk_import')}}
            </h1>
        </div>
        <!-- Content Row -->
        <div class="card">
            <div class="card-body p-2">
                <div class="export-steps style-2">
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5>{{translate('messages.step_1')}}</h5>
                            <p>
                                {{translate('messages.download_excel_file')}}
                            </p>
                        </div>
                    </div>
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5>{{translate('messages.step_2')}}</h5>
                            <p>
                                {{translate('messages.match_spread_sheet_data_according_to_instruction')}}
                            </p>
                        </div>
                    </div>
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5>{{translate('messages.step_3')}}</h5>
                            <p>
                                {{translate('messages.validate_data_and_comple_import')}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="jumbotron pt-1 pb-4 mb-0" style="background: white">
                    <h2 class="mb-3 text-primary">Instructions</h2>
                    <p>1. Download the format file and fill it with proper data.</p>

                    <p><p>2. You can download the example file to understand how the data must be filled.</p>

                    <p>3. Once you have downloaded and filled the format file, upload it in the form below and
                        submit.Make sure the phone numbers and email addresses are unique.</p>

                    <p>4. After uploading restaurants you need to edit them and set restaurants's logo and cover.</p>

                    <p>5. You can get category and zone id from their list, please input the right ids.</p>

                    <p>6. You can upload your restaurant images in restaurant folder from gallery, and copy image`s path.</p>

                    <p>7. Default password for restaurant is 12345678.</p>
                </div>
                <div class="text-center pb-4">
                    <h3 class="mb-3 export--template-title">{{ translate('Download Spreadsheet Template') }}</h3>
                    <div class="btn--container justify-content-center export--template-btns">
                        <a href="{{asset('public/assets/restaurants_bulk_format.xlsx')}}" download=""
                            class="btn btn-dark">{{ translate('Template with Existing Data') }}</a>
                        <a href="{{asset('public/assets/restaurants_bulk_format_nodata.xlsx')}}" download=""
                            class="btn btn-dark">{{ translate('Template without Data') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <form class="product-form" action="{{route('admin.vendor.bulk-import')}}" method="POST"
                enctype="multipart/form-data">
            @csrf
            <div class="card mt-2 rest-part">
                <div class="card-body">
                    <h4 class="mb-3">{{translate('messages.import_restaurants')}}</h4>
                    <div class="custom-file custom--file">
                        <input type="file" name="products_file" class="form-control" id="bulk__import">
                        <label class="custom-file-label" for="bulk__import">{{translate('messages.choose_file')}}</label>
                    </div>
                </div>
                <div class="card-footer border-0">
                    <div class="btn--container justify-content-end">
                        <button id="reset_btn" type="reset" class="btn btn--reset">{{translate('messages.Clear')}}</button>
                        <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection

@push('script')
    <script>
        $('#reset_btn').click(function(){
            $('#bulk__import').val(null);
        })
    </script>
@endpush
