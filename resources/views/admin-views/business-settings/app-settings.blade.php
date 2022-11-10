@extends('layouts.admin.app')

@section('title',__('messages.app_settings'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title text-capitalize">{{__('messages.app_settings')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        
        @php($app_url_android=\App\Models\BusinessSetting::where(['key'=>'app_url_android'])->first())
        @php($app_url_android=$app_url_android?$app_url_android->value:null)

        @php($app_url_ios=\App\Models\BusinessSetting::where(['key'=>'app_url_ios'])->first())
        @php($app_url_ios=$app_url_ios?$app_url_ios->value:null)

        @php($auto_checkout=\App\Models\BusinessSetting::where(['key'=>'auto_checkout'])->first())
        @php($auto_checkout=$auto_checkout?$auto_checkout->value:null)

        @php($employee_zone_satus=\App\Models\BusinessSetting::where(['key'=>'employee_zone_satus'])->first())
        @php($employee_zone_satus=$employee_zone_satus?$employee_zone_satus->value:null)


        <div class="row">
            <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="auto_checkout">
                        <span class="pr-2">{{__('messages.auto_checkout')}}:</span> 
                        <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.business-settings.toggle-settings',['auto_checkout',$auto_checkout?0:1, 'auto_checkout'])}}'" id="auto_checkout" {{$auto_checkout?'checked':''}}>
                        <span class="toggle-switch-label">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>
            </div>
            
            <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control" for="employee_zone_satus">
                        <span class="pr-2 text-capitalize">{{__('messages.show_employee_zone_satus')}}:</span> 
                        <input type="checkbox" class="toggle-switch-input" onclick="location.href='{{route('admin.business-settings.toggle-settings',['employee_zone_satus',$employee_zone_satus?0:1, 'employee_zone_satus'])}}'" id="employee_zone_satus" {{$employee_zone_satus?'checked':''}}>
                        <span class="toggle-switch-label">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gx-2 gx-lg-3">
                    <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                        <form action="{{route('admin.business-settings.app-settings')}}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                   
                                    <div class="form-group">
                                        <label class="input-label d-inline text-capitalize">{{__('messages.app_url')}} ({{__('messages.android')}})</label>
                                        <input type="text" placeholder="{{__('messages.app_url')}}" class="form-control" name="app_url_android"
                                            value="{{env('APP_MODE')!='demo'?$app_url_android??'':''}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                   
                                    <div class="form-group">
                                        <label class="input-label d-inline text-capitalize">{{__('messages.app_url')}} ({{__('messages.ios')}})</label>
                                        <input type="text" placeholder="{{__('messages.app_url')}}" class="form-control" name="app_url_ios"
                                            value="{{env('APP_MODE')!='demo'?$app_url_ios??'':''}}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2">{{trans('messages.submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('script_2')

@endpush
