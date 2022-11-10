@extends('layouts.landing.app')

@section('title','Landing Page | '.\App\Models\BusinessSetting::where(['key'=>'business_name'])->first()->value??'Attendance App')

@section('content')

    <main>
        <div class="main-body-div">
            <!-- Top Start -->
            <section class="top-start">
                <div class="container ">
                    <div class="row">
                        <div class="row col-lg-7 top-content">
                            <div>
                                <h3 class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                  
                                    {{__('messages.header_title_1')}}
                                </h3>
                                <span
                                    class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                     {{__('messages.header_title_2')}}
                                </span>
                                <h4 class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    {{__('messages.header_title_3')}}
                                </h4>
                            </div>

                            <div class="download-buttons">
                                <div class="play-store">
                                    <a href="#0">
                                        <img src="{{asset('public/assets/landing')}}/image/play_store.png">
                                    </a>
                                </div>

                                <div class="apple-store">
                                    <a href="#0">
                                        <img src="{{asset('public/assets/landing')}}/image/apple_store.png">
                                    </a>
                                </div>

                              
                            </div>
                        </div>

                        <div
                            class="col-lg-5 d-flex justify-content-center justify-content-md-end text-center text-md-right top-image">
                            <img src="{{asset('public/assets/landing')}}/image/double_screen_image.jpg" style="border-radius: 10px;">
                        </div>
                    </div>
                </div>
            </section>
            <!-- Top End -->

            <!-- About Us Start -->
            <section class="about-us">
                <div class="container">
                    <div class="row featured-section">
                        <div class="col-12 featured-title-m">
                            <span>About Us</span>
                        </div>
                        <div
                            class="col-lg-6 col-md-6  d-flex justify-content-center justify-content-md-start text-center text-md-left featured-section__image">
                            <img src="{{asset('public/assets/landing')}}/image/about_us_image.jpg" style="border-radius: 10px;"></img>
                        </div>
                        <!-- <div class="col-lg-3 col-md-0"></div> -->
                        <div class="col-lg-6 col-md-6">
                            <div class="featured-section__content"
                                 class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                <span>About Us</span>
                                <h2
                                    class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    {{__('messages.about_title')}}</h2>
                                <p
                                    class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    {!! \Illuminate\Support\Str::limit(\App\CentralLogics\Helpers::get_settings('about_us'),200) !!}
                                </p>
                                <div
                                    class="d-flex justify-content-center justify-content-md-start text-center text-md-left">
                                    <a href="{{route('about-us')}}"
                                       class="btn btn-color-primary text-white rounded align-middle">Read More
                                        ...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- About Us End -->

            <!-- Why Choose Us Start -->
            <section class="why-choose-us">
                <div class="container">
                    <div class="row choosing-section">
                        <div class="choosing-section__title">
                            <div>
                                <h2>{{__('messages.why_choose_us')}}</h2>
                                <span>{{__('messages.why_choose_us_title')}}</span>
                                <hr class="customed-hr-1">
                            </div>
                        </div>
                        <div class="choosing-section__content">
                            <div>
                                <div class="choosing-section__image-card">
                                    <img src="{{asset('public/assets/landing')}}/image/clean_&_cheap_icon.png"></img>
                                </div>
                                <div style="margin: 0px 55px 30px 54px">
                                    <p>Zone Base</p>
                                </div>
                            </div>

                            <div>
                                <div class="choosing-section__image-card">
                                <img src="{{asset('public/assets/landing')}}/image/clean_&_cheap_icon.png"></img>
                                </div>
                                <div style="margin: 0px 54px 30px 55px">
                                    <p> Attendance</p>
                                </div>
                            </div>

                            <div>
                                <div class="choosing-section__image-card">
                                  
                                    <img src="{{asset('public/assets/landing')}}/image/clean_&_cheap_icon.png"></img>
                                </div>
                                <div style="margin: 0px 31px 30px 31px">
                                    <p>Reports & Analytics</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- Why Choose Us End -->

            <!-- Trusted Customers Starts -->

            <!-- Trusted Customers Ends -->
        </div>
    </main>

@endsection
