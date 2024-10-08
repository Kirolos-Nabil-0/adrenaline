@extends('dashboard.layouts.layout')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <!-- Internal Data table css --> css/dashboard/new/plugins/select2/css/ --}}
    <link href="{{ URL::asset('css/dashboard/new/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('css/dashboard/new/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/dashboard/new/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('css/dashboard/new/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/dashboard/new/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/dashboard/new/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
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
                <h4 class="content-title mb-0 my-auto">الترم /</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">جيمع
                    الترم
                </span>
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
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal"
                        href="#modaldemo8">اضافة ترم</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">اسم الترم</th>
                                    <th class="wd-15p border-bottom-0">سنة الكليه</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($semesters as $color)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $color->semester_name }}</td>
                                        <td>{{ $color->year->year_number ?? '' }}</td>


                                        <td>
                                            <div class="d-flex">

                                                <a class="modal-effect btn btn-sm btn-info btn-sm ml-2"
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
                        <h6 class="modal-title">اضافة سنه الكليه</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('collegeyear.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label for="exampleInputEmail1">اسم الجامعه</label>
                            {{-- <select name="university_id" id="university_id" class="form-control mb-1"> --}}
                            <select id="category" name="category" class="form-control SlectBox" required>
                                <option selected disabled>Select University</option>
                                @foreach ($universities as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>

                            <label for="exampleInputEmail1">اسم الكليه</label>
                            <select id="college_id" name="college_id" class="form-control SlectBox" required>
                                <option value="" selected disabled>Select University first</option>
                            </select>

                            <label for="exampleInputEmail1">العام الدراسي</label>
                            <select id="year_number" name="year_number" class="form-control SlectBox" required>
                                <option value="">Select college first</option>
                            </select>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Semester year</label>
                                <input type="number" class="form-control" id="semester_name" name="semester_name"
                                    required>
                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">تاكيد</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">تعديل سنه الكليه</h5>
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
                                <label for="exampleInputEmail1">اسم سنه الكليه</label>
                                <input type="text" class="form-control" id="name" name="year_number" required>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
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

@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('js/dashboard/new/js/modal.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('js/dashboard/new/js/table-data.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var subCategoryDropdown = $('#college_id');

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




        $(document).ready(function() {
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var subCategoryDropdown = $('#college_id');

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
