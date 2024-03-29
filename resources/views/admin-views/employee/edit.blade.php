@extends('layouts.admin.app')
@section('title','Employee Edit')
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
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('messages.Employee')}} {{__('messages.update')}} </li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{__('messages.Employee')}} {{__('messages.update')}} </h1>
    </div>
    @php

        $zones = DB::table('zones')->get();
        @endphp
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <form action="{{route('admin.employee.update',[$e['id']])}}" method="post" enctype="multipart/form-data">
                        @csrf
                <div class="card-header">
                    {{__('messages.Employee')}} {{__('messages.update')}} {{__('messages.form')}}
                </div>
                @php
                    $zone_user = DB::table('zones')->where('id' , $user->zone_id)->first();
                @endphp
                <div class="col-md-6">
                    <label class="input-label qcont" for="zone_id">Zone</label>
                    <select class="form-control custom-select2" name="zone_id"
                            style="width: 100%" required>
                            @if($user->role_id == '1' && $user->id == '1')
                        <option value="" selected disabled>{{__('messages.select')}} Zone</option>
                        @foreach($zones as $r)
                            <option value="{{$r->id}}" @if($r->id == $e['zone_id']) {{'selected'}} @endif>{{$r->name}}</option>
                        @endforeach
                        @else
                        <option value="{{$zone_user->id}}" selected>{{$zone_user->name}}</option>
                        @endif
                    </select>
                </div>
                <div class="card-body">
                   
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="input-label qcont" for="name">{{__('messages.first')}} {{__('messages.name')}}</label>
                                    <input type="text" name="f_name" value="{{$e['f_name']}}" class="form-control" id="f_name"
                                           placeholder="Ex : Sakeef Ameer" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="input-label qcont" for="name">{{__('messages.last')}} {{__('messages.name')}}</label>
                                    <input type="text" name="l_name" value="{{$e['l_name']}}" class="form-control" id="l_name"
                                           placeholder="Ex : Prodhan">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="input-label qcont" for="name">{{__('messages.phone')}}</label>
                                    <input type="text" value="{{$e['phone']}}" required name="phone" class="form-control" id="phone"
                                           placeholder="Ex : +88017********">
                                </div>
   
                                <div class="col-md-6">
                                    <label class="input-label qcont" for="name">{{__('messages.Role')}}</label>
                                    <select class="form-control" name="role_id"
                                            style="width: 100%" >
                                            <option value="" selected disabled>{{__('messages.select')}} {{__('messages.Role')}}</option>
                                            @foreach($rls as $r)
                                                <option
                                                    value="{{$r->id}}" {{$r['id']==$e['role_id']?'selected':''}}>{{$r->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                             
                            </div>
                        </div>

                        <small class="nav-subtitle border-bottom">{{__('messages.login')}} {{__('messages.info')}}</small>
                        <br>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="input-label qcont" for="name">{{__('messages.email')}}</label>
                                    <input type="email" value="{{$e['email']}}" name="email" class="form-control" id="email"
                                           placeholder="Ex : ex@gmail.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="input-label qcont" for="name">{{__('messages.password')}}<small> ( {{__('messages.enter_if_you_want_to_change')}} )</small></label>
                                    <input type="text" name="password" class="form-control" id="password"
                                           placeholder="Password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="input-label qcont" for="name">{{__('messages.employee_image')}}</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="customFileUpload">{{__('messages.choose')}} {{__('messages.file')}}</label>
                                        </div>
                                    </div> 
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewer"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{asset('storage/app/public/admin')}}/{{$e['image']}}" alt="Employee thumbnail"/>
                                    </center>  
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer pl-0">
                            <button type="submit" class="btn btn-primary">{{__('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

        
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>
@endpush
