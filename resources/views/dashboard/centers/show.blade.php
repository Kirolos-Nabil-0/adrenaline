@extends('dashboard.layouts.layout')
@section('css')

@endsection
@section('content-dashboard')

    <div class="d-flex mt-5">
        <h4 class="content-title mb-0 my-auto">Manage <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / centers / {{$center->firstname}}</span></h4>
    </div>
    <div class="page-details mt-3">
        @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('success')}}
                    </div>
                @endif
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-primary">Center Details</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Center Name:</strong>
                        <p>{{ $center->firstname }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p>{{ $center->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Number of Courses:</strong>
                        <p>{{$center->getCenterCourses()->count()}}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Number of Instructors:</strong>
                        <p>{{$center->instructors->count()}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="text-primary">Packages</h4>
            </div>
            <div class="card-body">
                @if($center->packages->count() > 0)
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-bordered" id="collages">
                            <thead>
                                <tr class="table-primary">
                                    <th class="wd-15p border-bottom-0">Package</th>
                                    <th class="wd-15p border-bottom-0">Price</th>
                                    <th class="wd-15p border-bottom-0">Duration</th>
                                    <th class="wd-15p border-bottom-0">Start Date</th>
                                    <th class="wd-15p border-bottom-0">End Date</th>
                                    <th class="wd-15p border-bottom-0">Status</th>
                                    <th class="wd-15p border-bottom-0">Courses Limit</th>
                                    <th class="wd-15p border-bottom-0">Lessons / Course</th>
                                    <th class="wd-15p border-bottom-0">Video Support</th>
                                    <th class="wd-15p border-bottom-0">Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($center->packages as $package)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $package->name }}</td>
                                        <td>{{ $package->price }}</td>
                                        <td>{{ $package->duration }} {{ $package->duration_type }} </td>
                                        <td>{{$package->pivot->start_date}}</td>
                                        <td>{{$package->pivot->end_date}}</td>
                                        <td><span class="badge text-white bg-{{$package->pivot->status ? 'success' : 'danger'}}">{{$package->pivot->status ? 'Active' : 'Deactive'}}</span></td>
                                        <td>{{ $package->courses_limit >= 10000 ? 'Unlimited' : $package->courses_limit }}</td>
                                        <td>{{ $package->lessons_per_course_limit >= 10000 ? 'Unlimited' : $package->lessons_per_course_limit }}</td>
                                        <td><span class="badge text-white bg-{{ $package->video_support ? 'success' : 'danger' }} text-uppercase">{{ $package->video_support ? 'Yes' : 'No' }}</span></td>
                                        <td>
                                            @if ($center->currentDeactivePackage() && $center->currentDeactivePackage()->id == $package->id)
                                                <a class="modal-effect btn btn-sm btn-success d-flex gap-1" data-effect="effect-scale"
                                                data-id="{{ $center->id }}" data-name="{{ $package->name }}"
                                                data-toggle="modal" href="#modaldemo9" title="تفعيل">Activate <i
                                                    class="las la-star"></i></a>
                                            @endif
                                            @if ($center->currentPackage() && $center->currentPackage()->id == $package->id)
                                                <a class="modal-effect btn btn-sm btn-danger d-flex gap-1" data-effect="effect-scale"
                                                data-id="{{ $center->id }}" data-name="{{ $package->name }}"
                                                data-toggle="modal" href="#modaldemo10" title="الغاء التفعيل">Deactivate <i
                                                    class="las la-star"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No packages associated with this center.</p>
                @endif
            </div>
        </div>
    </div>

    
        <!-- delete -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Activate Package</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="activate-form">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>Are you sure about activating this package?</p><br>
                            <input class="form-control" name="name" id="name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <!-- deactivating -->
        <div class="modal" id="modaldemo10">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Deactivate Package</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="deactivate-form">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>Are you sure about deactivating this package?</p><br>
                            <input class="form-control" name="name" id="name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('page_js')

    <!-- Internal Data tables -->
    <script src="{{ URL::asset('js/dashboard/new/js/modal.js') }}"></script>
    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)

            var actionUrl = '{{ route("centers.activate-package", ":id") }}'; 
            actionUrl = actionUrl.replace(':id', id);

            modal.find('#activate-form').attr('action', actionUrl);
            modal.find('.modal-body #name').val(name);
        })
        $('#modaldemo10').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)

            var actionUrl = '{{ route("centers.deactivate-package", ":id") }}'; 
            actionUrl = actionUrl.replace(':id', id);

            modal.find('#deactivate-form').attr('action', actionUrl);
            modal.find('.modal-body #name').val(name);
        })
    </script>

@endsection