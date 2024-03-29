@extends('layouts.admin.app')

@section('title','Add new zone')

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i
                            class="tio-add-circle-outlined"></i> {{__('messages.add')}} {{__('messages.new')}} {{__('messages.zone')}}
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            @if($user->role_id == '1' && $user->id == '1')
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.zone.store')}}" method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{__('messages.name')}}</label>
                                <input type="text" name="name" class="form-control" placeholder="New zone" value="{{old('name')}}" required>
                            </div>
                        <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">

                                <div class="form-group">
                                    <label class="input-label d-inline text-capitalize">{{__('messages.time')}} {{__('messages.zone')}}</label>
                                    <select name="timezone" class="form-control">
                                        <option value="UTC" >UTC</option>
                                        <option value="Etc/GMT+12" >(GMT-12:00) International Date Line West</option>
                                        <option value="Pacific/Midway" >(GMT-11:00) Midway Island, Samoa</option>
                                        <option value="Pacific/Honolulu" >(GMT-10:00) Hawaii</option>
                                        <option value="US/Alaska" >(GMT-09:00) Alaska</option>
                                        <option value="America/Los_Angeles" >(GMT-08:00) Pacific Time (US & Canada)</option>
                                        <option value="America/Tijuana"  >(GMT-08:00) Tijuana, Baja California</option>
                                        <option value="US/Arizona" >(GMT-07:00) Arizona</option>
                                        <option value="America/Chihuahua"  >(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                        <option value="US/Mountain"  >(GMT-07:00) Mountain Time (US & Canada)</option>
                                        <option value="America/Managua"  >(GMT-06:00) Central America</option>
                                        <option value="US/Central"  >(GMT-06:00) Central Time (US & Canada)</option>
                                        <option value="America/Mexico_City" >(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                        <option value="Canada/Saskatchewan" >(GMT-06:00) Saskatchewan</option>
                                        <option value="America/Bogota"  >(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                        <option value="US/Eastern" >(GMT-05:00) Eastern Time (US & Canada)</option>
                                        <option value="US/East-Indiana" >(GMT-05:00) Indiana (East)</option>
                                        <option value="Canada/Atlantic"  >(GMT-04:00) Atlantic Time (Canada)</option>
                                        <option value="America/Caracas"  >(GMT-04:00) Caracas, La Paz</option>
                                        <option value="America/Manaus" >(GMT-04:00) Manaus</option>
                                        <option value="America/Santiago" >(GMT-04:00) Santiago</option>
                                        <option value="Canada/Newfoundland"  >(GMT-03:30) Newfoundland</option>
                                        <option value="America/Sao_Paulo" >(GMT-03:00) Brasilia</option>
                                        <option value="America/Argentina/Buenos_Aires"  >(GMT-03:00) Buenos Aires, Georgetown</option>
                                        <option value="America/Godthab"  >(GMT-03:00) Greenland</option>
                                        <option value="America/Montevideo"  >(GMT-03:00) Montevideo</option>
                                        <option value="America/Noronha"  >(GMT-02:00) Mid-Atlantic</option>
                                        <option value="Atlantic/Cape_Verde"  >(GMT-01:00) Cape Verde Is.</option>
                                        <option value="Atlantic/Azores"  >(GMT-01:00) Azores</option>
                                        <option value="Africa/Casablanca"  >(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
                                        <option value="Etc/Greenwich"  >(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                                        <option value="Europe/Amsterdam" >(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                        <option value="Europe/Belgrade"  >(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                        <option value="Europe/Brussels"  >(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                        <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                        <option value="Africa/Lagos" >(GMT+01:00) West Central Africa</option>
                                        <option value="Asia/Amman"  >(GMT+02:00) Amman</option>
                                        <option value="Europe/Athens" >(GMT+02:00) Athens, Bucharest, Istanbul</option>
                                        <option value="Asia/Beirut"  >(GMT+02:00) Beirut</option>
                                        <option value="Africa/Cairo"  >(GMT+02:00) Cairo</option>
                                        <option value="Africa/Harare"  >(GMT+02:00) Harare, Pretoria</option>
                                        <option value="Europe/Helsinki"  >(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                                        <option value="Asia/Jerusalem"  >(GMT+02:00) Jerusalem</option>
                                        <option value="Europe/Minsk"  >(GMT+02:00) Minsk</option>
                                        <option value="Africa/Windhoek"  >(GMT+02:00) Windhoek</option>
                                        <option value="Asia/Kuwait"  >(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
                                        <option value="Europe/Moscow"  >(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                        <option value="Africa/Nairobi"  >(GMT+03:00) Nairobi</option>
                                        <option value="Asia/Tbilisi" >(GMT+03:00) Tbilisi</option>
                                        <option value="Asia/Tehran" >(GMT+03:30) Tehran</option>
                                        <option value="Asia/Muscat"  >(GMT+04:00) Abu Dhabi, Muscat</option>
                                        <option value="Asia/Baku"  >(GMT+04:00) Baku</option>
                                        <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                        <option value="Asia/Kabul"  >(GMT+04:30) Kabul</option>
                                        <option value="Asia/Yekaterinburg"  >(GMT+05:00) Yekaterinburg</option>
                                        <option value="Asia/Karachi"  >(GMT+05:00) Islamabad, Karachi, Tashkent</option>
                                        <option value="Asia/Calcutta" >(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                        <option value="Asia/Katmandu"  >(GMT+05:45) Kathmandu</option>
                                        <option value="Asia/Almaty" >(GMT+06:00) Almaty, Novosibirsk</option>
                                        <option value="Asia/Dhaka"  >(GMT+06:00) Astana, Dhaka</option>
                                        <option value="Asia/Rangoon" >(GMT+06:30) Yangon (Rangoon)</option>
                                        <option value="Asia/Bangkok" >(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                        <option value="Asia/Krasnoyarsk" >(GMT+07:00) Krasnoyarsk</option>
                                        <option value="Asia/Hong_Kong" >(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                        <option value="Asia/Kuala_Lumpur"  >(GMT+08:00) Kuala Lumpur, Singapore</option>
                                        <option value="Asia/Irkutsk"  >(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                        <option value="Australia/Perth"  >(GMT+08:00) Perth</option>
                                        <option value="Asia/Taipei"  >(GMT+08:00) Taipei</option>
                                        <option value="Asia/Tokyo"  >(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                        <option value="Asia/Seoul"  >(GMT+09:00) Seoul</option>
                                        <option value="Asia/Yakutsk"  >(GMT+09:00) Yakutsk</option>
                                        <option value="Australia/Adelaide"  >(GMT+09:30) Adelaide</option>
                                        <option value="Australia/Darwin"  >(GMT+09:30) Darwin</option>
                                        <option value="Australia/Brisbane"  >(GMT+10:00) Brisbane</option>
                                        <option value="Australia/Canberra" >(GMT+10:00) Canberra, Melbourne, Sydney</option>
                                        <option value="Australia/Hobart"  >(GMT+10:00) Hobart</option>
                                        <option value="Pacific/Guam"  >(GMT+10:00) Guam, Port Moresby</option>
                                        <option value="Asia/Vladivostok"  >(GMT+10:00) Vladivostok</option>
                                        <option value="Asia/Magadan"  >(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
                                        <option value="Pacific/Auckland"  >(GMT+12:00) Auckland, Wellington</option>
                                        <option value="Pacific/Fiji"  >(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                        <option value="Pacific/Tongatapu"  >(GMT+13:00) Nuku'alofa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Attendance Time</label>
                                <input type="time" name="attendance_time" class="form-control" placeholder="New zone" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Attendance Time Out</label>
                                <input type="time" name="attendance_time_out" class="form-control" placeholder="New zone" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Break From</label>
                                <input type="time" name="break_from" class="form-control" placeholder="New zone" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Break To</label>
                                <input type="time" name="break_to" class="form-control" placeholder="New zone" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Business Logo</label>
                                <input type="file" name="business_logo" class="form-control" placeholder="New zone" value="{{old('name')}}" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Coordinates<span class="input-label-secondary" title="{{__('messages.draw_your_zone_on_the_map')}}">{{__('messages.draw_your_zone_on_the_map')}}</span></label>
                                       <textarea type="text" rows="8" name="coordinates"  id="coordinates" class="form-control" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 map-warper" style="height: 300px;">
                            <div id="map-canvas" style="height: 100%; margin:0px; padding: 0px;"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('messages.add')}}</button>
                </form>
                @endif
            </div>

            <div class="col-sm-12 col-lg-12 mb-3 my-lg-2">
                <div class="card">
                    <div class="card-header">
                        <h5>{{__('messages.zone')}} {{__('messages.list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$zones->total()}}</span></h5>
                        <form action="javascript:" id="search-form" >
                                        <!-- Search -->
                            @csrf
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="Search" aria-label="Search" required>
                                <button type="submit" class="btn btn-light">{{__('messages.search')}}</button>

                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th>{{__('messages.#')}}</th>
                                <th>{{__('messages.id')}}</th>
                                <th >{{__('messages.name')}}</th>
                                <th>TimeZone</th>
                                <th> Business Logo</th>
                                <th >{{__('messages.employees')}}</th>
                                <th >{{__('messages.status')}}</th>
                                <th >{{__('messages.action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($zones as $key=>$zone)
                            @if($user->role_id == '1' && $user->id == '1')
                                <tr>
                                    <td>{{$key+$zones->firstItem()}}</td>
                                    <td>{{$zone->id}}</td>
                                    <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{$zone['name']}}
                                    </span>
                                    </td>
                                    <td>{{$zone['timezone']}}</td>
                                    <td>
                                        <img src="/Business_Logo/{{$zone->business_logo}}" style ="height:60px;width:60px;border-radius:50px"/>
                                    </td>
                                    <td>
                                        @php
                                            $employee_count = DB::table('users')->where('zone_id' , $zone->id)->count();
                                        @endphp

                                        {{$employee_count}}
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$zone->id}}">
                                            <input type="checkbox" onclick="status_form_alert('status-{{$zone['id']}}','Want to change status for this zone ?', event)" class="toggle-switch-input" id="stocksCheckbox{{$zone->id}}" {{$zone->status?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <form action="{{route('admin.zone.status',[$zone['id'],$zone->status?0:1])}}" method="get" id="status-{{$zone['id']}}">
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.zone.edit',[$zone['id']])}}" title="{{__('messages.edit')}} {{__('messages.zone')}}"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white" href="javascript:"
                                        onclick="form_alert('zone-{{$zone['id']}}','Want to delete this zone ?')" title="{{__('messages.delete')}} {{__('messages.zone')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('admin.zone.delete',[$zone['id']])}}" method="post" id="zone-{{$zone['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    @if($user->zone_id == $zone->id)
                                    <td>{{$key+$zones->firstItem()}}</td>
                                    <td>{{$zone->id}}</td>
                                    <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{$zone['name']}}
                                    </span>
                                    </td>
                                    <td>
                                       
                                        <img src="/Business_Logo/{{$zone->business_logo}}" style ="height:60px;width:60px;border-radius:50px"/>
                                    </td>
                                    <td>
                                        @php
                                            $employee_count = DB::table('users')->where('zone_id' , $zone->id)->count();
                                        @endphp

                                        {{$employee_count}}
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$zone->id}}">
                                            <input type="checkbox" onclick="status_form_alert('status-{{$zone['id']}}','Want to change status for this zone ?', event)" class="toggle-switch-input" id="stocksCheckbox{{$zone->id}}" {{$zone->status?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <form action="{{route('admin.zone.status',[$zone['id'],$zone->status?0:1])}}" method="get" id="status-{{$zone['id']}}">
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.zone.edit',[$zone['id']])}}" title="{{__('messages.edit')}} {{__('messages.zone')}}"><i class="tio-edit"></i>
                                        </a>
                                        {{--<a class="btn btn-sm btn-white" href="javascript:"
                                        onclick="form_alert('zone-{{$zone['id']}}','Want to delete this zone ?')" title="{{__('messages.delete')}} {{__('messages.zone')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('admin.zone.delete',[$zone['id']])}}" method="post" id="zone-{{$zone['id']}}">
                                            @csrf @method('delete')
                                        </form>--}}
                                    </td>
                                    @endif
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $zones->links() !!}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function status_form_alert(id, message, e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $('#'+id).submit()
                }
            })
        }
    auto_grow();
    function auto_grow() {
        let element = document.getElementById("coordinates");
        element.style.height = "5px";
        element.style.height = (element.scrollHeight)+"px";
    }

    </script>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });


            $('#column3_search').on('change', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&libraries=drawing&v=3"></script>

    <script>
        var map; // Global declaration of the map
        var drawingManager;
        var lastpolygon = null;
        var polygons = [];

        function resetMap(controlDiv) {
            // Set CSS for the control border.
            const controlUI = document.createElement("div");
            controlUI.style.backgroundColor = "#fff";
            controlUI.style.border = "2px solid #fff";
            controlUI.style.borderRadius = "3px";
            controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            controlUI.style.cursor = "pointer";
            controlUI.style.marginTop = "8px";
            controlUI.style.marginBottom = "22px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Reset map";
            controlDiv.appendChild(controlUI);
            // Set CSS for the control interior.
            const controlText = document.createElement("div");
            controlText.style.color = "rgb(25,25,25)";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.fontSize = "10px";
            controlText.style.lineHeight = "16px";
            controlText.style.paddingLeft = "2px";
            controlText.style.paddingRight = "2px";
            controlText.innerHTML = "X";
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => {
                lastpolygon.setMap(null);
                $('#coordinates').val('');
                
            });
        }

        function initialize() {
            @php($default_location=\App\Models\BusinessSetting::where('key','default_location')->first())
            @php($default_location=$default_location->value?json_decode($default_location->value, true):0)
            var myLatlng = { lat: {{$default_location?$default_location['lat']:'23.757989'}}, lng: {{$default_location?$default_location['lng']:'90.360587'}} };


            var myOptions = {
                zoom: 13,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                editable: true
                }
            });
            drawingManager.setMap(map);


            //get current location block
            // infoWindow = new google.maps.InfoWindow();
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    map.setCenter(pos);
                });
            }

            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                if(lastpolygon)
                {
                    lastpolygon.setMap(null);
                }
                $('#coordinates').val(event.overlay.getPath().getArray());
                lastpolygon = event.overlay;
                auto_grow();
            });

            const resetDiv = document.createElement("div");
            resetMap(resetDiv, lastpolygon);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);
        }

        google.maps.event.addDomListener(window, 'load', initialize);


        function set_all_zones()
        {
            $.get({
                url: '{{route('admin.zone.zoneCoordinates')}}',
                dataType: 'json',
                success: function (data) {

                    console.log(data);
                    for(var i=0; i<data.length;i++)
                    {
                        polygons.push(new google.maps.Polygon({
                            paths: data[i],
                            strokeColor: "#FF0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: "#FF0000",
                            fillOpacity: 0.1,
                        }));
                        polygons[i].setMap(map);
                    }
  
                },
            });
        }
        $(document).on('ready', function(){
            set_all_zones();
        });
        
    </script>
    <script>
        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.zone.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.total);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
