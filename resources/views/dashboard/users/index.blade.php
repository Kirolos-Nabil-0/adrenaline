@extends('dashboard.layouts.layout')
@section('css')
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
                @if(Session::has('danger'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('danger')}}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="users_table">
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
                            @php
                                $i = 1;
                            @endphp
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user->firstname . " " . $user->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{route('users.change_user_role', $user)}}" method="post" class="d-flex align-items-center">
                                            @csrf
                                            <select name="role" id="role" class="form-control" style="width: 100px; max-width:100%">
                                                <option disabled selected>User</option>
                                                <option value="instructor">Instructor</option>
                                                <option value="center">Center</option>
                                            </select>
                                            <button class="btn btn-success ml-2" type="submit">Change</button>
                                        </form>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <form action="{{route('users.destroy', $user)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?!!')"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">There are no users available!</td>
                                </tr>
                            @endforelse
                        </tbody>
                   </table>
                </div>
            </div>
@endsection

@section('page_js')
<script>
    let table = $('#users_table').DataTable();
</script>
@endsection
