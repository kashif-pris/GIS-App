@extends('layouts.admin.app')

@section('title','Update Branch')

@push('css_or_js')

@endpush

@section('content')

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title text-capitalize"><i class="tio-edit"></i> {{__('messages.zone')}} {{__('messages.update')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <form action="{{route('admin.zone.update', $zone->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{__('messages.name')}}</label>
                                <input type="text" name="name" class="form-control" placeholder="New zone" value="{{$zone->name}}" required>
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
                                <input type="time" name="attendance_time" class="form-control" placeholder="New zone" value="{{$zone->attendance_time}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Attendance Time Out</label>
                                <input type="time" name="attendance_time_out" class="form-control" placeholder="New zone" value="{{$zone->attendance_time_out}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Break From</label>
                                <input type="time" name="break_from" class="form-control" placeholder="New zone" value="{{$zone->break_from}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Break To</label>
                                <input type="time" name="break_to" class="form-control" placeholder="New zone" value="{{$zone->break_to}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">Business Logo</label>
                                <input type="file" name="business_logo" class="form-control" placeholder="New zone" value="{{$zone->business_logo}}" required>
                            </div>
                            <div class="form-group">
                                
                                <label class="input-label"
                                       for="exampleFormControlInput1">Coordinates<span
                                        class="input-label-secondary" title="{{__('messages.draw_your_zone_on_the_map')}}">{{__('messages.draw_your_zone_on_the_map')}}</span></label>
                                       <textarea readonly type="text" name="coordinates"  id="coordinates" class="form-control">@foreach($zone->coordinates[0] as $key=>$coords)<?php if(count($zone->coordinates[0]) != $key+1) {if($key != 0) echo(','); ?>({{$coords->getLat()}}, {{$coords->getLng()}})<?php } ?>@endforeach
                                </textarea>
                            </div>
                        </div>
                        @if($user->role_id == '1' && $user->id == '1')
                        <div class="col-6" style="height: 300px;">
                            <div id="map-canvas" style="height: 100%; margin:0px; padding: 0px;"></div>
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('messages.update')}}</button>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
<script src="https://maps.googleapis.com/maps/api/js?v=3&key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&libraries=drawing"></script>
<script>
    auto_grow();
    function auto_grow() {
        let element = document.getElementById("coordinates");
        element.style.height = "5px";
        element.style.height = (element.scrollHeight)+"px";
    }

</script>
<script>
    var map; // Global declaration of the map
    var lat_longs = new Array();
    var drawingManager;
    var lastpolygon = null;
    var bounds = new google.maps.LatLngBounds();
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
        var myLatlng = new google.maps.LatLng({{trim(explode(' ',$zone->center)[1], 'POINT()')}}, {{trim(explode(' ',$zone->center)[0], 'POINT()')}});
        var myOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

        const polygonCoords = [

            @foreach($zone->coordinates[0] as $coords)
            { lat: {{$coords->getLat()}}, lng: {{$coords->getLng()}} },
            @endforeach
        ];

        var zonePolygon = new google.maps.Polygon({
            paths: polygonCoords,
            strokeColor: "#050df2",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillOpacity: 0,
        });

        zonePolygon.setMap(map);

        zonePolygon.getPaths().forEach(function(path) {
            path.forEach(function(latlng) {
                bounds.extend(latlng);
                map.fitBounds(bounds);
            });
        });

        
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

        google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
            var newShape = event.overlay;
            newShape.type = event.type;
        });

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
            url: '{{route('admin.zone.zoneCoordinates')}}/{{$zone->id}}',
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
@endpush
