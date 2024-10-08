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
                    <table id="modules" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Module Image</th>
                            <th scope="col">Module Name</th>
                            {{-- <th scope="col">Archive</th> --}}
                            <th scope="col">Add Instructors</th>
                            <th scope="col">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
                </div>

            </div>
@endsection

@section('page_js')
<script>
        var archiveModule="{{ route('archiveModule') }}";
        var users=@json($users);
        var add_auth_user="{{route('add_auth_user')}}";
        var delete_auth_user="{{route('delete_auth_user')}}";
        $(".courses-status").click(function(){
			$(this).addClass("btn-success").siblings().removeClass("btn-success")
		})

</script>
    {{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{asset('js/dashboard/modules.js')}}"></script>
@endsection
