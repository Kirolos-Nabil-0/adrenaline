@extends('dashboard.layouts.layout')
@section('css')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" /> --}}
<link href="{{URL::asset('css/dashboard/new/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<style>
    .dataTables_wrapper .dataTables_info,.dataTables_wrapper .dataTables_paginate{
        float: unset !important
    }
</style>

@endsection
@section('content-dashboard')

            <div class="d-flex mt-5">
                <h4 class="content-title mb-0 my-auto">Manage</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Users</span>
            </div>
            <div class="page-details mt-3 bg-white main-shadow p-4">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('success')}}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table" id="instructors">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                   </table>
                </div>
                <!-- modals here -->


                <!-- modal add section here -->


                <!-- modal add lesson here -->


                <!-- modals here -->
            </div>
@endsection

@section('js')
    <script>
        var update_user_role="{{route('update_user_role')}}";
        var remove_user="{{route('remove_user')}}";
    </script>
    {{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{asset('js/dashboard/instructors.js')}}"></script>
@endsection
