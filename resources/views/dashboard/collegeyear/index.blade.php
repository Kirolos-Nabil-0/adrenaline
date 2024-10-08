@extends('dashboard.layouts.layout')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <!-- Internal Data table css --> css/dashboard/new/plugins/select2/css/ --}}
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
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Collage years /</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">All Collage years</span>
            </div>
        </div>

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
                <div class="col-sm-6 col-md-4 col-xl-3 p-3">
                    <a class="modal-effect btn btn-outline-primary btn-inline-block" data-effect="effect-scale" data-toggle="modal"
                        href="#modaldemo8">Add Collage year</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="collages-year">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">Collage Year</th>
                                    <th class="wd-15p border-bottom-0">Collage name</th>
                                    <th class="wd-15p border-bottom-0">Its affiliated university</th>
                                    <th class="wd-15p border-bottom-0">Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($collegeyears as $color)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $color->year_number }}</td>
                                        <td>{{ $color->college->name }}</td>
                                        <td>{{ $color->college->university->name }}</td>

                                        <td>
                                            <div class="d-flex">

                                                <a class="modal-effect btn btn-sm btn-info btn-sm mr-2"
                                                    data-effect="effect-scale" data-id="{{ $color->id }}"
                                                    data-name="{{ $color->year_number }}" data-toggle="modal"
                                                    href="#exampleModal2" title="تعديل"><i class="las la-pen">

                                                    </i>
                                                </a>



                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $color->id }}" data-name="{{ $color->year_number }}"
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

        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Add Collage year</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('collegeyear.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label for="exampleInputEmail1">University Name</label>
                            {{-- <select name="university_id" id="university_id" class="form-control mb-1"> --}}
                            <div class="form-group">
                                <select id="category" name="category" class="form-control SlectBox" required>
                                    <option selected disabled>Select University</option>
                                    @foreach ($universities as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Collage Name</label>
                                <select id="college_id" name="college_id" class="form-control SlectBox" required>
                                    <option value="">Select University first</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Collage year</label>
                                <input type="number" class="form-control" id="year_number" name="year_number" required>
                            </div>
                            <div class="modal-footer pr-0">
                                <button type="submit" class="btn btn-success">Confirm</button>
                                <button type="button" class="btn btn-secondary mr-0" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- row closed -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Collage year</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('collegeyear.update') }}" method="post" enctype="multipart/form-data">
                            {{ method_field('post') }}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name of collage year</label>
                                <input type="text" class="form-control" id="name" name="year_number" required>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- delete -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف سنه الكليه</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('collegeyear.destroy', 0) }}" method="POST">
                        {{ method_field('POST') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل أنت متأكد من عملية الحذف؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input class="form-control" name="name" id="name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تأكيد</button>
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
        let table = $('#collages-year').DataTable();
    </script>
    <script>
        $(document).ready(function() {
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var subCategoryDropdown = $('#college_id');
                console.log(categoryId)
                console.log(subCategoryDropdown)
                if (categoryId) {
                    // Make an AJAX request to fetch the subsections based on the selected section
                    $.ajax({
                        url: '{{ route('collegeyear.byid') }}',
                        type: 'GET',
                        data: {
                            id: categoryId
                        },
                        success: function(response) {
                            console.log(response);
                            console.log("------------------");
                            console.log(response.data);
                            subCategoryDropdown.empty();
                            $.each(response, function(key, value) {
                                console.log(value.id + "-------------------------" +
                                    key);
                                subCategoryDropdown.append(
                                    '<option  value="' + value.id + '">' + value
                                    .name +
                                    '</option>'
                                );
                            });
                        }
                    });
                } else {
                    // Clear the subsection dropdown if no section is selected
                    subCategoryDropdown.empty();
                }
            });
        });
    </script>
    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script>


    <script>
        const appUrl = "{{ url('/') }}";
        $(document).ready(function() {
            $('#exampleModal2').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var name = button.data('name')
                var name_en = button.data('name_en')
                var arrange = button.data('arrange')
                var status = button.data('status')
                var image = button.data('image')
                var modal = $(this)
                modal.find('.modal-body #id').val(id)
                modal.find('.modal-body #name').val(name)
                modal.find('.modal-body #preview-image').attr('src', appUrl + "/" + image)
                modal.find('.modal-body #name_en').val(name_en)
                modal.find('.modal-body #arrange').val(arrange)
                modal.find('.modal-body #status').val(status)
            })
        });
    </script>
@endsection
