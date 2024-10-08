@extends('dashboard.layouts.layout')
@section('page_css')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" /> --}}
@endsection
@section('content-dashboard')

            <div class="breadcrumb-header justify-content-between">
                <div class="my-auto">
                    <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">Modules</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Manage</span>
                    </div>
                </div>
            </div>
            <div class="page-details mt-3 bg-white main-shadow p-4">
                <table id="modules" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Module Name</th>
                        <th scope="col">Price</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
@endsection

@section('page_js')
<script>
        var changeModulePrice="{{ route('changeModulePrice') }}";

</script>
    {{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{asset('js/dashboard/instructorModules.js')}}"></script>
@endsection
