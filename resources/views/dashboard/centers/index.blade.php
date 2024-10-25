@extends('dashboard.layouts.layout')
@section('css')
@endsection
@section('content-dashboard')

            <div class="d-flex mt-5">
                <h4 class="content-title mb-0 my-auto">Manage</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Centers</span>
            </div>
            <div class="page-details mt-3 bg-white main-shadow p-4">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('success')}}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="centers_table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Instructors</th>
                                <th>Courses</th>
                                <th>Package</th>
                                <th>Package Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @forelse ($centers as $center)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $center->firstname }}</td>
                                    <td>{{ $center->email }}</td>
                                    <td>{{ $center->instructors_count }}</td>
                                    <td>{{ $center->getCenterCourses()->count() }}</td>
                                    <td>
                                        @if ($center->currentPackage())
                                            <a href="{{route("packages.edit", $center->currentPackage())}}" target="_blank">{{ $center->currentPackage()->name }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($center->currentPackage())
                                            <span class="badge text-white bg-{{$center->currentPackage()->pivot->status ? 'success' : 'danger'}}">{{ $center->currentPackage()->pivot->status ? 'Active' : 'Inactive' }}</span>
                                        @endif
                                    </td>
                                    <td class="d-flex align-items-center gap-1">
                                        <a href="{{route("centers.edit", $center)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">There are no centers available!</td>
                                </tr>
                            @endforelse
                        </tbody>
                   </table>
                </div>
            </div>
@endsection

@section('page_js')
<script>
    let table = $('#centers_table').DataTable();
</script>
@endsection
