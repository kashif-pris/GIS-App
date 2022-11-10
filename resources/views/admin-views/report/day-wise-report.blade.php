@extends('layouts.admin.app')

@section('title',__('messages.day_wise_report'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> {{__('messages.day_wise_report')}} <span class="h6 badge badge-soft-success ml-2" id="itemCount">( {{session('from_date')}} - {{session('to_date')}} )</span></h1>
                </div>
                <!-- <div class="col-sm-auto" style="width: 306px;">
                    <select name="zone_id" class="form-control js-select2-custom"
                            onchange="set_zone_filter('{{url()->full()}}',this.value)">
                        <option value="all">All Zones</option>
                        @foreach(\App\Models\Zone::orderBy('name')->get() as $z)
                            <option
                                value="{{$z['id']}}" {{isset($zone) && $zone->id == $z['id']?'selected':''}}>
                                {{$z['name']}}
                            </option>
                        @endforeach
                    </select>
                </div> -->
            </div>
        </div>
        <!-- End Page Header -->

        <div class="card px-3">
            <div class="row" style="border-radius: 10px">
                <div class="col-lg-12 pt-3">
                    <form action="{{route('admin.report.set-date')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">{{__('messages.show')}} {{__('messages.data')}} by {{__('messages.date')}}
                                        {{__('messages.range')}}</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <input type="date" name="from" id="from_date" {{session()->has('from_date')?'value='.session('from_date'):''}}
                                        class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="col-4">
                                <div class="mb-3">
                                    <input type="date" name="to" id="to_date" {{session()->has('to_date')?'value='.session('to_date'):''}}
                                        class="form-control" required>
                                </div>
                            </div>
                            <!-- <div class="col-2">
                                <div class="mb-3">
                                    <select name="type" class="form-control select2">
                                        <option value="detail" @if(session('type') == 'detail') selected @endif >Detail Report</option>
                                        <option value="summary"  @if(session('type') == 'summary') selected @endif >Summary Report</option>
                                        
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-3">
                                <div class="mb-3">
                                    <select name="employee" class="form-control select2">
                                        <option value="all">--All Employees--</option>
                                        @foreach($employee as $e)
                                            <option @if(session('employee') == $e->id) selected @endif value="{{$e->id}}">{{$e->f_name}} {{$e->l_name}}</option>

                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div> -->
                            <div class="col-3">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">{{__('messages.show')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @php
                    $from = session('from_date');
                    $to = session('to_date');
                    $total=\App\Models\Attendance::when(isset($zone), function($query)use($zone){                        
                            return $query->where('zone_id', $zone->id);
                    })->groupBy('employee_id')->whereBetween('created_at', [$from, $to])->count();
                    if($total==0){
                        $total=.01;
                    }
                    
                @endphp
     
            </div>
        </div>

        <!-- End Stats -->
        <!-- Card -->
        <div class="card mt-3">
            <!-- Header -->
            <div class="card-header">
                <h1>{{__('messages.attendance_report')}}
                </h1>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-thead-bordered table-align-middle card-table"
                        style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th  style="width: 5%">{{__('messages.sr')}}</th>
                                <th  style="width: 10%">{{__('messages.employee_name')}}</th>
                                <th  style="width: 17%">{{__('messages.attendance')}}</th>
                                <th  style="width: 10%">{{__('messages.time_in')}}</th>
                                <th  style="width: 10%">{{__('messages.time_out')}}</th>
                                <th  style="width: 8%">{{__('messages.active_hours')}}</th>
                                <th  style="width: 22%">{{__('messages.updated_at')}}</th>
                                <th  style="width: 10%">{{__('messages.zone_status')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php 
                            if($user->id != 1 && $user->role_id != 1)
                            $attendance = \App\Models\Attendance::where('zone_id',$zone->id)->whereBetween('created_at', [$from, $to])->with('employee')->where('zone_id' , $user->zone_id)->latest()->paginate(25);
                            
                            else
                            $attendance = \App\Models\Attendance::whereBetween('created_at', [$from, $to])->with('employee')->latest()->paginate(25);
                            @endphp
                          
                     
                        
                        @foreach($attendance as $k=>$activity)
                     
                            <tr scope="row">
                                <td >{{$k+1}}</td>
                                <td>
                                    <a href="#0">
                                    {{@$activity->employee->f_name}} {{@$activity->employee->l_name}}
                                    </a>
                                </td>
                                <td>
                                    @if($activity->check_in)
                                        Present
                                    @else 
                                        Absent
                                    @endif
                                </td>
                                <td>{{$activity->check_in}}</td>
                                <td>{{$activity->check_out}}</td>
                                <td>{{$activity->active_hours}}</td>
                                <td>{{$activity->updated_at->format('d/m/Y h:i')}}</td>
                                <td class="text-capitalize">{{$activity->status}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Body -->
            <div class="card-footer">
                {!!$attendance->links()!!}
            </div>    
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script')

@endpush

@push('script_2')

    <script src="{{asset('public/assets/admin')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script
        src="{{asset('public/assets/admin')}}/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/hs.chartjs-matrix.js"></script>

    <script>
        $(document).on('ready', function () {

            // INITIALIZATION OF FLATPICKR
            // =======================================================
            $('.js-flatpickr').each(function () {
                $.HSCore.components.HSFlatpickr.init($(this));
            });


            // INITIALIZATION OF NAV SCROLLER
            // =======================================================
            $('.js-nav-scroller').each(function () {
                new HsNavScroller($(this)).init()
            });


            // INITIALIZATION OF DATERANGEPICKER
            // =======================================================
            $('.js-daterangepicker').daterangepicker();

            $('.js-daterangepicker-times').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'M/DD hh:mm A'
                }
            });

            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#js-daterangepicker-predefined .js-daterangepicker-predefined-preview').html(start.format('MMM D') + ' - ' + end.format('MMM D, YYYY'));
            }

            $('#js-daterangepicker-predefined').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);


            // INITIALIZATION OF CHARTJS
            // =======================================================
            $('.js-chart').each(function () {
                $.HSCore.components.HSChartJS.init($(this));
            });

            var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

            // Call when tab is clicked
            $('[data-toggle="chart"]').click(function (e) {
                let keyDataset = $(e.currentTarget).attr('data-datasets')

                // Update datasets for chart
                updatingChart.data.datasets.forEach(function (dataset, key) {
                    dataset.data = updatingChartDatasets[keyDataset][key];
                });
                updatingChart.update();
            })


            // INITIALIZATION OF MATRIX CHARTJS WITH CHARTJS MATRIX PLUGIN
            // =======================================================
            function generateHoursData() {
                var data = [];
                var dt = moment().subtract(365, 'days').startOf('day');
                var end = moment().startOf('day');
                while (dt <= end) {
                    data.push({
                        x: dt.format('YYYY-MM-DD'),
                        y: dt.format('e'),
                        d: dt.format('YYYY-MM-DD'),
                        v: Math.random() * 24
                    });
                    dt = dt.add(1, 'day');
                }
                return data;
            }

            $.HSCore.components.HSChartMatrixJS.init($('.js-chart-matrix'), {
                data: {
                    datasets: [{
                        label: 'Commits',
                        data: generateHoursData(),
                        width: function (ctx) {
                            var a = ctx.chart.chartArea;
                            return (a.right - a.left) / 70;
                        },
                        height: function (ctx) {
                            var a = ctx.chart.chartArea;
                            return (a.bottom - a.top) / 10;
                        }
                    }]
                },
                options: {
                    tooltips: {
                        callbacks: {
                            title: function () {
                                return '';
                            },
                            label: function (item, data) {
                                var v = data.datasets[item.datasetIndex].data[item.index];

                                if (v.v.toFixed() > 0) {
                                    return '<span class="font-weight-bold">' + v.v.toFixed() + ' hours</span> on ' + v.d;
                                } else {
                                    return '<span class="font-weight-bold">No time</span> on ' + v.d;
                                }
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            position: 'bottom',
                            type: 'time',
                            offset: true,
                            time: {
                                unit: 'week',
                                round: 'week',
                                displayFormats: {
                                    week: 'MMM'
                                }
                            },
                            ticks: {
                                "labelOffset": 20,
                                "maxRotation": 0,
                                "minRotation": 0,
                                "fontSize": 12,
                                "fontColor": "rgba(22, 52, 90, 0.5)",
                                "maxTicksLimit": 12,
                            },
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            type: 'time',
                            offset: true,
                            time: {
                                unit: 'day',
                                parser: 'e',
                                displayFormats: {
                                    day: 'ddd'
                                }
                            },
                            ticks: {
                                "fontSize": 12,
                                "fontColor": "rgba(22, 52, 90, 0.5)",
                                "maxTicksLimit": 2,
                            },
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });


            // INITIALIZATION OF CLIPBOARD
            // =======================================================
            $('.js-clipboard').each(function () {
                var clipboard = $.HSCore.components.HSClipboard.init(this);
            });


            // INITIALIZATION OF CIRCLES
            // =======================================================
            $('.js-circle').each(function () {
                var circle = $.HSCore.components.HSCircles.init($(this));
            });
        });
    </script>

    <script>
        $('#from_date,#to_date').change(function () {
            let fr = $('#from_date').val();
            let to = $('#to_date').val();
            if (fr != '' && to != '') {
                if (fr > to) {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    toastr.error('Invalid date range!', Error, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            }

        })
    </script>
@endpush
