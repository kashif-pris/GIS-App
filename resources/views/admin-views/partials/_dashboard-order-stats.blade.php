<div class="col-12">
    @php($params=session('dash_params'))
    @if($params['zone_id']!='all')
        @php($zone_name=\App\Models\Zone::where('id',$params['zone_id'])->first()->name)
    @else
        @php($zone_name='All')
    @endif
    <label class="badge badge-soft-info">( Zone : {{$zone_name}} )</label>
</div>

<div class="col-sm-6 col-lg-6 mb-3 mb-lg-5">
    <!-- Card -->
    <a class="card card-hover-shadow h-100" href="#0"
       style="background: #402218">
        <div class="card-body">
            <h6 class="card-subtitle"
                style="color: white!important;">{{__('messages.present')}}</h6>

            <div class="row align-items-center gx-2 mb-1">
                <div class="col-6">
                        <span class="card-title h2" style="color: white!important;">
                            {{$total_sell}}
                        </span>
                </div>

                <div class="col-6 mt-2">
                    <i class="tio-man" style="font-size: 30px;color: white"></i>
                    <i class="tio-checkmark-circle-outlined"
                       style="font-size: 22px;margin-left:-10px;color: white"></i>
                </div>
            </div>
            <!-- End Row -->
        </div>
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-6 mb-3 mb-lg-5">
    <!-- Card -->
    <a class="card card-hover-shadow h-100" href="#0"
       style="background: #54436B">
        <div class="card-body">
            <h6 class="card-subtitle"
                style="color: white!important;">{{__('messages.absent')}}</h6>
            <div class="row align-items-center gx-2 mb-1">
                <div class="col-6">
                                        <span class="card-title h2" style="color: white!important;">
                                            {{$commission - $total_sell}}
                                        </span>
                </div>
                <div class="col-6 mt-2">
                    <i class="tio-man" style="font-size: 30px;color: white"></i>
                    <i class="tio-search"
                       style="font-size: 22px;margin-left:-10px;color: white"></i>
                </div>
            </div>
            <!-- End Row -->
        </div>
    </a>
    <!-- End Card -->
</div>





