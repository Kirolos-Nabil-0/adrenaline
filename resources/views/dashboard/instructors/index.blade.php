@extends('dashboard.layouts.layout')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />

@endsection
@section('content-dashboard')

            <div class="d-flex mt-5">
                <h4 class="content-title mb-0 my-auto">Manage <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Instructors</span></h4>
            </div>
            <div class="page-details mt-3 bg-white main-shadow p-4">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('success')}}
                    </div>
                @endif
                
                @if(Session::has('danger'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('danger')}}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="instructors_table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                @admin
                                    <th>Center</th>
                                @endadmin
                                <th>Courses</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($instructors as $instructor)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$instructor->firstname . ' ' . $instructor->lastname}}</td>
                                    <td>{{$instructor->email}}</td>
                                    @admin
                                        <td>{{$instructor->center ? $instructor->center->firstname : ''}}</td>
                                    @endadmin
                                    <td>{{ $instructor->owned_courses_count }}</td>
                                    <td class="d-flex align-items-center justify-content-center flex-wrap">
                                        <a href="{{route("instructors.show", $instructor)}}" class="btn btn-success btn-sm mx-1"><i class="fa fa-eye"></i></a>
                                        @admin
                                            @if (!$instructor->center)
                                                <a href="{{route("instructors.edit", $instructor)}}" class="btn btn-primary btn-sm mx-1"><i class="fa fa-edit"></i></a>
                                            @endif
                                            <form action="{{route('instructors.destroy', $instructor)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Are you sure you want to delete this instructor? it will delete all of its associated coureses!!')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endadmin
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                   </table>
                </div>
                <!-- modals here -->


                <!-- modal add section here -->


                <!-- modal add lesson here -->


                <!-- modals here -->
            </div>
@endsection

@section('page_js')
<script src="{{ URL::asset('js/dashboard/new/js/modal.js') }}"></script>
<script>
    let table = $('#instructors_table').DataTable();
</script>
@endsection
