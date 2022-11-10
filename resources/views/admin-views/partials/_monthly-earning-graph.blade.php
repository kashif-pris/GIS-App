<div class="card-body">
    <div class="row mb-4">
        <div class="col-sm mb-2 mb-sm-0">
            @php($params=session('dash_params'))
            @if($params['zone_id']!='all')
                @php($zone_name=\App\Models\Zone::where('id',$params['zone_id'])->first()->name)
            @else
                @php($zone_name='All')
            @endif
            <div class="d-flex align-items-center">
                <span class="h3 mb-0">
                    <span class="legend-indicator bg-primary" style="background-color: #511281!important;"></span>
                    {{__('messages.total_present')}} : {{$total_sell}}
                      <label style="font-size: 10px" class="badge badge-soft-info">( Zone : {{$zone_name}} )</label>
                </span>
            </div>
            <div class="d-flex align-items-center mt-2 mb-2">
                <span class="h5 mb-0">
                    <span class="legend-indicator bg-primary" style="background-color: #4CA1A3!important;"></span>
                    {{__('messages.total_absent')}} : {{$commission - $total_sell}}
                </span>
            </div>
        </div>

        <div class="col-sm-auto align-self-sm-end">
            <!-- Legend Indicators -->
            <div class="row font-size-sm">
                <div class="col-auto">
                    <h5 class="card-header-title"><i class="tio-chart-bar-4" style="font-size: 50px"></i></h5>
                </div>
            </div>
            <!-- End Legend Indicators -->
        </div>
    </div>
    <!-- End Row -->

    <!-- Bar Chart -->
   
    <!-- End Bar Chart -->
</div>

<script>
    // INITIALIZATION OF CHARTJS
    // =======================================================
    Chart.plugins.unregister(ChartDataLabels);

    $('.js-chart').each(function () {
        $.HSCore.components.HSChartJS.init($(this));
    });

    var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));
</script>
