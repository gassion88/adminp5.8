@extends('layouts.vendor.app')
@section('title','Employee Add')
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
           @media(max-width:375px){
            #employee-image-modal .modal-content{
              width: 367px !important;
            margin-left: 0 !important;
        }

        }

   @media(max-width:500px){
    #employee-image-modal .modal-content{
              width: 400px !important;
            margin-left: 0 !important;
        }


   }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
     <div class="page-header">
        <h2 class="page-header-title text-capitalize">
            <div class="card-header-icon d-inline-flex mr-2 img">
                <img src="{{asset('/public/assets/admin/img/resturant-panel/page-title/employee-role.png')}}" alt="public">
            </div>
            <span>
                Add New {{__('messages.Employee')}}
            </span>
        </h2>
    </div>
    <!-- End Page Header -->

    <!-- Content Row -->
    <form action="{{route('vendor.employee.add-new')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <span class="card-header-icon">
                        <i class="tio-user"></i>
                    </span>
                    <span>
                        {{ translate('General Information') }}
                    </span>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="fname">{{__('messages.first')}} {{__('messages.name')}}</label>
                            <input type="text" name="f_name" class="form-control h--45px" id="fname"
                                    placeholder="Ex : Sakeef Ameer" value="{{old('f_name')}}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="lname">{{__('messages.last')}} {{__('messages.name')}}</label>
                            <input type="text" name="l_name" class="form-control h--45px" id="lname" value="{{old('l_name')}}"
                                    placeholder="Ex : Prodhan" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phone">{{__('messages.phone')}}</label>
                            <input type="tel" name="phone" value="{{old('phone')}}" class="form-control h--45px" id="phone"
                                    placeholder="Ex : +88017********" required>
                        </div>
                        <div class="form-group mb-md-0">
                            <label class="form-label" for="role_id">{{__('messages.Role')}}</label>
                            <select class="form-control h--45px custom-select2" name="role_id"
                                    style="width: 100%" required>
                                <option value="" selected disabled>{{__('messages.select')}} {{__('messages.Role')}}</option>
                                @foreach($rls as $r)
                                    <option value="{{$r->id}}">{{$r->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 d-flex flex-column">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="form-label text-center mb-3" for="customFileUpload">
                                        {{__('messages.employee_image')}}
                                        <span class="text-danger">Ratio (1:1)</span>
                                    </h5>
                                    <center class="my-auto">
                                        <img style="width:120px;aspect-ratio:1;object-fit:cover" id="viewer"
                                            src="{{asset('public\assets\admin\img\400x400\img2.jpg')}}" alt="Employee thumbnail"/>
                                    </center>
                                    <div class="form-group mb-0 mt-3">
                                        <label class="form-label">{{ translate('Employee image size max 2 MB') }} <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" value="{{old('image')}}" required>
                                            <label class="custom-file-label" for="customFileUpload">{{__('messages.choose')}} {{__('messages.file')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-user"></i>
                            </span>
                            <span>
                                {{__('messages.account')}} {{__('messages.info')}}
                            </span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label" for="email">{{__('messages.email')}}</label>
                                <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email"
                                        placeholder="Ex : ex@gmail.com" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="password">{{__('messages.password')}}</label>
                                <input type="text" name="password" class="form-control" id="password" value="{{old('password')}}"
                                        placeholder="{{__('messages.password_length_placeholder',['length'=>'8+'])}}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="confirm-password">Confirm {{__('messages.password')}}</label>
                                <input type="text" name="confirm-password" class="form-control" id="password" value="{{old('confirm-password')}}"
                                        placeholder="{{__('messages.password_length_placeholder',['length'=>'8+'])}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-3">
                    <button type="reset" id="reset_btn" class="btn btn--reset">{{__('messages.reset')}}</button>
                    <button type="submit" class="btn btn--primary">{{__('messages.submit')}}</button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });
    </script>
            <script>
                $('#reset_btn').click(function(){
                    $('#viewer').attr('src','{{asset('public\assets\admin\img\400x400\img2.jpg')}}');
                })
            </script>
@endpush
