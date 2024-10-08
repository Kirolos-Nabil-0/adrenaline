@extends('dashboard.layouts.layout')
@section('page_css')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" /> --}}
<style>
    .dataTables_wrapper .dataTables_info,.dataTables_wrapper .dataTables_paginate{
        float: unset !important
    }
</style>
@endsection
@section('content-dashboard')

            <div class="breadcrumb-header justify-content-between">
                <div class="my-auto">
                    <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">Enroll</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ History</span>
                    </div>
                </div>
			</div>
            <div class="page-details mt-3 bg-white fw-bold main-shadow p-4 table-responsive">
                <table class="table table-striped table-hover" id="enrollments">
                    <thead>
                    <tr>
                        {{-- <th scope="col">Photo</th> --}}
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Enrolled course</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    
            
                    </tbody>
                </table>
            </div>
@endsection
@section('page_js')

    {{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{asset('js/dashboard/enrollments.js')}}"></script>
@endsection