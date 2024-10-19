@extends('dashboard.layouts.layout')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* CSS for image container */
        .image-container {
            width: 50px;
            height: 50px;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
        }

        /* CSS for the circular image */
        .image-container img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Packages /</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> All
                Package
            </span>
        </div>
        <a class="btn btn-primary btn-inline-block" href="{{route("packages.create")}}">Create Package</a>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content-dashboard')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="collages">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">Package</th>
                                    <th class="wd-15p border-bottom-0">Price</th>
                                    <th class="wd-15p border-bottom-0">Duration</th>
                                    <th class="wd-15p border-bottom-0">Courses Limit</th>
                                    <th class="wd-15p border-bottom-0">Lessons / Course</th>
                                    <th class="wd-15p border-bottom-0">Video Support</th>
                                    <th class="wd-15p border-bottom-0">Video Maximum</th>
                                    <th class="wd-15p border-bottom-0">Maximum Storage</th>
                                    <th class="wd-15p border-bottom-0">Consumers</th>
                                    <th class="wd-15p border-bottom-0">Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($packages as $package)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $package->name }}</td>
                                        <td>{{ $package->price }}</td>
                                        <td>{{ $package->duration }} {{ $package->duration_type }} </td>
                                        <td>{{ $package->courses_limit >= 10000 ? 'Unlimited' : $package->courses_limit }}</td>
                                        <td>{{ $package->lessons_per_course_limit >= 10000 ? 'Unlimited' : $package->lessons_per_course_limit }}</td>
                                        <td><span class="badge text-white bg-{{ $package->video_support ? 'success' : 'danger' }} text-uppercase">{{ $package->video_support ? 'Yes' : 'No' }}</span></td>
                                        <td>
                                            @if ($package->video_support)
                                                {{ $package->video_maximum >= 10000 ? 'Unlimited' : $package->video_maximum}}
                                            @else
                                                0
                                            @endif
                                            MB
                                        <td>
                                            @if ($package->video_support)
                                                {{ ($package->video_maximum >= 10000 || $package->courses_limit >= 10000 || $package->lessons_per_course_limit >= 10000) ? 'Unlimited' : $package->courses_limit * $package->lessons_per_course_limit *  $package->video_maximum / 1000 . " GB"}}
                                            @else
                                                0 GB
                                            @endif
                                            
                                        </td>
                                        <td>{{ $package->consumers->count() }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-sm btn-info btn-sm mr-2"
                                                    href="{{route("packages.edit", $package)}}" title="تعديل"><i class="las la-pen">
                                                    </i>
                                                </a>
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $package->id }}" data-name="{{ $package->name }}"
                                                    data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                        class="las la-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- delete -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Delete Package</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="delete-form">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>Are you sure about this?</p><br>
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


    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('page_js')

    <!-- Internal Data tables -->
    <script src="{{ URL::asset('js/dashboard/new/js/modal.js') }}"></script>
    <script>
        let table = $('#collages').DataTable();
    </script>
    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)

            var actionUrl = '{{ route("packages.destroy", ":id") }}'; 
            actionUrl = actionUrl.replace(':id', id);

            modal.find('#delete-form').attr('action', actionUrl);
            modal.find('.modal-body #name').val(name);
        })
    </script>

@endsection
