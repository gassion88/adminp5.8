@extends('layouts.admin.app')
@section('title', __('messages.landing_page_settings'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/admin/css/croppie.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
        <!-- Page Header -->
        <h1 class="page-header-title text-capitalize">
            <div class="card-header-icon d-inline-flex mr-2 img">
                <img src="{{asset('/public/assets/admin/img/landing-page.png')}}" class="mw-26px" alt="public">
            </div>
            <span>
                {{ __('messages.landing_page_settings') }}
            </span>
        </h1>
        <!-- End Page Header -->
            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('admin.business-settings.landing-page-settings', 'index') }}">{{ __('messages.text') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('admin.business-settings.landing-page-settings', 'links') }}"
                            aria-disabled="true">{{ __('messages.button_links') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "
                            href="{{ route('admin.business-settings.landing-page-settings', 'speciality') }}"
                            aria-disabled="true">{{ __('messages.speciality') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('admin.business-settings.landing-page-settings', 'testimonial') }}"
                            aria-disabled="true">{{ __('messages.testimonial') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('admin.business-settings.landing-page-settings', 'feature') }}"
                            aria-disabled="true">{{ __('messages.feature') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('admin.business-settings.landing-page-settings', 'image') }}"
                            aria-disabled="true">{{ __('messages.image') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
                            href="{{ route('admin.business-settings.landing-page-settings', 'backgroundChange') }}"
                            aria-disabled="true">{{ __('messages.header_footer_bg') }}</a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->
        <!-- Page Heading -->
        <div class="card my-2">
            <div class="card-body">
                <form action="{{ route('admin.business-settings.landing-page-settings', 'backgroundChange') }}"
                    method="POST">
                    @php($backgroundChange = \App\Models\BusinessSetting::where(['key' => 'backgroundChange'])->first())
                    @php($backgroundChange = isset($backgroundChange->value) ? json_decode($backgroundChange->value, true) : null)
                    @csrf
                    <div class="row text-center gy-3">
                        <div class="col-sm-4">
                            <label class="form-label">{{ __('messages.change_header_bg') }}</label>
                            <input name="header-bg" type="color" class="form-control form-control-color" value="{{ isset($backgroundChange['header-bg']) ? $backgroundChange['header-bg'] : '#EF7822' }}">
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">{{ __('messages.change_footer_bg') }}</label>
                            <input name="footer-bg" type="color" class="form-control form-control-color" value="{{ isset($backgroundChange['footer-bg']) ? $backgroundChange['footer-bg'] :'#333E4F'}}">
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">{{ __('messages.landing_page_bg') }}</label>
                            <input name="landing-page-bg" type="color" class="form-control form-control-color"
                                value="{{ isset($backgroundChange['landing-page-bg']) ? $backgroundChange['landing-page-bg'] : '#ffffff' }}">
                        </div>
                    </div>
                    <div class="form-group text-right mt-3 mb-0">
                        <button type="submit" class="btn btn--primary">{{ __('messages.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script_2')
@endpush
