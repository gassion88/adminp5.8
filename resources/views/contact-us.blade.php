@extends('layouts.landing.app')

@section('title',translate('messages.contact_us'))

@section('content')
    <main>
        <div class="main-body-div">
            <!-- Top Start -->
            <section class="top-start min-h-100px">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mt-2 text-center">
                            <h1 class="mb-0">{{translate('messages.contact_us')}}</h1>
                        </div>
                        <div class="col-12">
                           <center>
                               <img class="w-100px" src="{{asset('/public/assets/landing/image/contact.png')}}" alt="landing">
                           </center>
                        </div>
                    </div>
                    <div class="d-flex important flex-wrap justify-content-around mt-4">
                        <div class="c-item">
                            <h5 class="text-capitalize">{{translate('messages.call_us')}}</h5>
                            <a href="tel:{{\App\CentralLogics\Helpers::get_settings('phone')}}" class="card m-0 ">
                                <div class="card-body py-2 d-flex">
                                    <span><i class="fa-solid fa-phone fa-1x"></i></span>
                                    <span>{{\App\CentralLogics\Helpers::get_settings('phone')}}</span>
                                    <span class="ms-auto">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="c-item">
                            <h5 class="text-capitalize">{{translate('messages.mail_us')}}</h5>
                            <a href="mailto:{{\App\CentralLogics\Helpers::get_settings('email_address')}}"  class="card m-0 ">
                                <div class="card-body py-2 d-flex">
                                    <span><i class="fa-solid fa-envelope fa-1x"></i></span>
                                    <span>{{\App\CentralLogics\Helpers::get_settings('email_address')}}</span>
                                    <span class="ms-auto">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="c-item">
                            <h5 class="text-capitalize">{{translate('messages.find_us')}}</h5>
                            @php
                                $default_location = \App\CentralLogics\Helpers::get_business_settings('default_location');
                            @endphp
                            <a href="http://maps.google.com/maps?z=12&t=m&q=loc:{{ isset($default_location['lat']) ? $default_location['lat'] : '0' }}+{{ isset($default_location['lng']) ? $default_location['lng'] : '0' }}" target="_blank" class="card m-0 ">
                                <div class="card-body py-2 d-flex">
                                    <span><i class="fa-solid fa-location-dot fa-1x"></i></span>
                                    <span>{{\App\CentralLogics\Helpers::get_settings('address')}}</span>
                                    <span class="ms-auto">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Top End -->
        </div>
    </main>
@endsection
