@extends('dashboard.layouts.layout')
@section('css')
    <link href="{{ URL::asset('css/dashboard/new/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection

@section('content-dashboard')

    <!-- row -->
    <div class="mt-4">
        <div class="row row-sm">
            <div class="col-xl-{{ $num }} col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Number of Courses</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $courses }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                </div>
            </div>
            <div class="col-xl-{{ $num }} col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Number of Lessons</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $lessons }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                </div>
            </div>
            {{-- @admin --}}
            <div class="col-xl-{{ $num }} col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Number of enrollment</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $enroll }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
                </div>
            </div>
            {{-- @endadmin --}}
            @admin
                <div class="col-xl-{{ $num }} col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-warning-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">Number of Students</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $users }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                    </div>
                </div>
            @endadmin
        </div>

        <div class="row row-sm"> @admin
                <div class="col-xl-{{ $num }} col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-primary-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">Number of Universities</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $universitys }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endadmin
            <div class="col-xl-{{ $num }} col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">Number of Sections</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $section }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @admin
                <div class="col-xl-{{ $num }} col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-success-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">Number of Course Codes</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $codes }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endadmin
            @admin
                <div class="col-xl-{{ $num }} col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-warning-gradient">
                        <div class="pl-3 pt-3 pr-3 pb-2">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">Number of Colleges</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $colleges }}</h4>
                                        <p class="mb-0 tx-12 text-white op-7"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endadmin
        </div>
    </div>
    @admin
        <div style="height: 500px" class="bg-white main-shadow p-4 border rounded">
            <canvas id="myChart"></canvas>
        </div>
    @endadmin

    <div style="height: 500px" class="bg-white main-shadow p-4 border rounded">
        <canvas id="myChartIns"></canvas>
    </div>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        let myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthNames) !!},
                datasets: [{
                    label: 'Yearly Course Sales',
                    data: {!! json_encode($totalSales) !!},
                    backgroundColor: {!! json_encode($colors) !!},
                    borderColor: {!! json_encode($colors) !!},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        });
    </script>
    <script>
        const ctxs = document.getElementById('myChartIns');

        let myChartIns = new Chart(ctxs, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthNamesIns) !!},
                datasets: [{
                    label: 'Yearly Course Sales - Instructor',
                    data: {!! json_encode($totalSalesIns) !!},
                    backgroundColor: {!! json_encode($colorsIns) !!},
                    borderColor: {!! json_encode($colorsIns) !!},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        });
    </script>

    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('js/dashboard/new/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('js/dashboard/new/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('js/dashboard/new/js/index.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/js/jquery.vmap.sampledata.js') }}"></script>
@endsection