@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="dashboard__content">

        @include($activeTemplate.'partials.user_history')

        <div class="job__completed">
            <div class="job__completed-header d-flex align-items-center justify-content-between">
                <h5>@lang('Jobs Completed')</h5>
            </div>
            <div class="job__completed-body">
                <div id="chartprofile"></div>
            </div>
        </div>

        <div class="finished__jobs__wrapper mt-5">
            <div class="finished__jobs__header d-flex flex-wrap justify-content-between align-items-center mb-2">
                <h4 class="pe-4 mb-2">@lang('Recent Earnings Jobs')</h4>
                <a href="{{ route('user.job.finished') }}" class="btn btn--sm btn--base mb-2">@lang('View All')</a>
            </div>
            <table class="table transection__table">
                <thead>
                    <tr>
                        <th>@lang('Job Code')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Date')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jobs as $k => $data)
                        <tr>
                            <td data-label="#@lang('Job Code')">
                                <span class="invoice-id">{{ __($data->job->job_code) }}</span>
                            </td>
                            <td data-label="@lang('Rate')">
                                <span class="amount">
                                    {{ __($general->cur_sym) }}{{ showAmount($data->job->rate) }}
                                </span>
                            </td>
                            <td data-label="@lang('Status')">
                                @if ($data->status == 0)
                                    <span class="status pending">@lang('Pending')</span>
                                @else
                                    <span class="status completed">@lang('completed')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Date')">
                                <span class="time">{{ showDateTime($data->created_at) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="justify-content-center text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('script')
<script src="{{ asset($activeTemplateTrue .'js/chart.min.js') }}"></script>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            var color = "{{ $general->base_color }}";

            function generateData(baseval, count, yrange) {
                var i = 0;
                var series = [];
                while (i < count) {
                    var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
                    var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
                    var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

                    series.push([x, y, z]);
                    baseval += 86400000;
                    i++;
                }
                return series;
            }

            var options = {
                series: [85, 75, 60, 40],
                chart: {
                toolbar: {
                    show: false
                },
                height: 250,
                type: 'radialBar',
                },
                plotOptions: {
                radialBar: {
                    offsetY: 0,
                    startAngle: 0,
                    endAngle: 270,
                    hollow: {
                    margin: 5,
                    size: '50%',
                    background: 'transparent',
                    image: undefined,
                    },
                    dataLabels: {
                    name: {
                        show: false,
                    },
                    value: {
                        show: false,
                    }
                    }
                }
                },
                colors: ['#7B46BE', '#FA6CA4', '#FACD3A', '#24C0DC'],
                labels: ['Applied Jobs', 'Messenger', 'Facebook', 'LinkedIn'],
                legend: {
                show: false,
                floating: true,
                fontSize: '16px',
                position: 'bottom',
                offsetX: 160,
                offsetY: 15,
                labels: {
                    useSeriesColors: true,
                },
                markers: {
                    size: 0
                },
                formatter: function(seriesName, opts) {
                    return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                },
                itemMargin: {
                    vertical: 3
                }
                },
                responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        show: false
                    }
                }
                }]
                };


                var chart = new ApexCharts(document.querySelector("#chartradial"), options);
                chart.render();

                var options = {
                series: [{
                    name: "Jobs Completed",
                    data: [
                        @foreach($jobArr as $job)
                             @json($job['count']),
                        @endforeach
                    ]
                }],
                chart: {
                height: 360,
                type: 'line',
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
                },
                dataLabels: {
                enabled: false
                },
                colors: ["#"+color],
                stroke: {
                curve: 'straight',
                width: [1]
                },
                markers: {
                size: 5,
                colors: ["#"+color],
                strokeColors: "#"+color,
                strokeWidth: 1,
                hover: {
                    size: 6,
                }
                },
                grid: {
                    position: 'front',
                    borderColor: '#ddd',
                    strokeDashArray: 7,
                    xaxis: {
                        lines: {
                        show: true
                        }
                    }
                },
                xaxis: {
                categories: [
                        @foreach($jobArr as $job)
                             @json($job['month']),
                        @endforeach
                    ],
                lines: {
                    show: true,
                }
                },
                yaxis: {
                lines: {
                    show: true,
                }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartprofile"), options);
            chart.render();

            });
    </script>
@endpush
