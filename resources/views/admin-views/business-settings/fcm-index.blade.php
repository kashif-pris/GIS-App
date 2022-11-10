@extends('layouts.admin.app')

@section('title','FCM Settings')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{__('messages.firebase')}} {{__('messages.push')}} {{__('messages.notification')}} {{__('messages.setup')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.update-fcm'):'javascript:'}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @php($key=\App\Models\BusinessSetting::where('key','push_notification_key')->first())
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{__('messages.server')}} {{__('messages.key')}}</label>
                                <textarea name="push_notification_key" class="form-control"
                                          required>{{env('APP_MODE')!='demo'?$key->value??'':''}}</textarea>
                            </div>
                            @php($project_id=\App\Models\BusinessSetting::where('key','fcm_project_id')->first())
                            <div class="row" style="{{$project_id?($project_id->value?'display: none;':''):''}}">
                                
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">FCM Project ID</label>
                                        <input type="text" value="{{$project_id->value??''}}"
                                               name="fcm_project_id" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary">{{__('messages.submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>

           
            
        </div>
    </div>
@endsection

@push('script_2')

@endpush
