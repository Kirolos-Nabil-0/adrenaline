@extends('dashboard.layouts.layout')
@section('css')
    <style>
        .stars li {
            cursor: pointer;
        }
    </style>
    <link href="{{ URL::asset('css/dashboard/new/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ URL::asset('css/dashboard/new/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet"> -->

    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/ratings.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/bars-1to10.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/bars-movie.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/bars-square.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/bars-pill.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/bars-reversed.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/bars-horizontal.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/css-stars.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/bootstrap-stars.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dashboard/new/plugins/rating/themes/fontawesome-stars-o.css') }}">
@endsection
@section('content-dashboard')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Courses</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ View
                    Courses</span>
            </div>
        </div>
    </div>
    <div class="page-details mt-3 bg-white main-shadow p-4">
        <div class="w-50">
            <div>
                <label for="aarchived" class="btn btn-primary courses-status"> All</label>
                <label for="narchived" class="btn btn-primary courses-status"> Not Archived</label>
                <label for="archived" class="btn btn-primary courses-status"> Archived</label>
            </div>
            <div class="d-none">
                <input type="radio" id="aarchived" name="is_archived" value="all" checked />
                <input type="radio" id="narchived" name="is_archived" value="0" />
                <input type="radio" id="archived" name="is_archived" value="1" />
            </div>
        </div>
        <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Course Name</th>
                        @admin
                            <th>Created By</th>
                        @endadmin
                        <th>Price EGP</th>
                        <th>Price USD</th>
                        <th>Discount USD</th>
                        <th>Discount EGP</th>
                        <!-- @admin
                            <th>Link</th>
                        @endadmin -->
                        <!-- <th>Rate</th> -->

                        <!-- @admin
        <th >Module</th>
    @endadmin -->
                        <!-- <th style="min-width:150px">Rate</th> -->
                        <!-- <th >Archive</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page_js')
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/select2/js/select2.min.js') }}"></script>
    <!-- <script src="{{ URL::asset('js/dashboard/new/plugins/sweet-alert/sweetalert.min.js') }}"></script>
                 <script src="{{ URL::asset('js/dashboard/new/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script> -->
    <!-- Sweet-alert js  -->
    <!-- <script src="{{ URL::asset('js/dashboard/new/plugins/sweet-alert/sweetalert.min.js') }}"></script>
                 <script src="{{ URL::asset('js/dashboard/new/js/sweet-alert.js') }}"></script> -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/rating/jquery.rating-stars.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/rating/jquery.barrating.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/rating/ratings.js') }}"></script>

    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('js/dashboard/new/js/table-data.js') }}"></script>
    <script>
        var linkCourseModule = "{{ route('linkCourseModule') }}";
        var archiveCourse = "{{ route('archiveCourse') }}";
        var modules = [];
        modules = @json($modules);
        $(".courses-status").first().addClass("btn-success")
        $(".courses-status").click(function() {
            $(this).addClass("btn-success").siblings().removeClass("btn-success")
        })
    </script>
    <script src="{{ asset('js/dashboard/courses.js') }}"></script>
@endsection
