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
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Codes /</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> All
                    Codes
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
                <div class="col-sm-6 col-md-4 col-xl-3 p-3">
                    <a class="modal-effect btn btn-outline-primary btn-inline-block" data-effect="effect-scale"
                        data-toggle="modal" href="#modaldemo8">Add Codes</a>

                        <button class="modal-effect btn btn-outline-danger btn-inline-block" onclick="onMultipleDelete()">Delete</button>
                        <button class="modal-effect btn btn-outline-danger btn-inline-block" onclick="onDeleteAll('{{$courseCodes}}')">Delete All</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="Codess">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">Code</th>
                                    <th class="wd-15p border-bottom-0">The code is used</th>
                                    <th class="wd-15p border-bottom-0">Date created</th>
                                    <th class="wd-15p border-bottom-0">Expiry date</th>
                                    <th class="wd-15p border-bottom-0">course Name</th>
                                    <th class="wd-15p border-bottom-0">Action</th>
                                    <th class="wd-15p border-bottom-0">Multiple delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($courseCodes as $color)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr id="code-{{ $color->id }}">
                                        <td>{{ $i }}</td>
                                        <td>{{ $color->code }}</td>
                                        <td>{{ $color->is_used == 0 ? 'NO' : 'Yes' }}</td>
                                        <td>{{ $color->created_at }}</td>
                                        <td>{{ $color->expires_at }}</td>
                                        <td>{{ $color->course->name }}</td>
                                        <td>
                                            <div class="d-flex">

                                                {{-- <a class="modal-effect btn btn-sm btn-info btn-sm mr-2"
                                                    data-effect="effect-scale" data-id="{{ $color->id }}"
                                                    data-name="{{ $color->name }}" data-toggle="modal"
                                                    href="#exampleModal2" title="تعديل"><i class="las la-pen">

                                                    </i>
                                                </a> --}}



                                                <a class="modal-effect btn btn-sm btn-danger" onclick="removeCode(this,'{{ $color->id }}')"
                                                    data-id="{{ $color->id }}"
                                                    data-toggle="modal" title="حذف"><i
                                                        class="las la-trash"></i></a>

                                                <!-- <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $color->id }}" data-name="{{ $color->code }}"
                                                    data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                        class="las la-trash"></i></a> -->
                                            </div>

                                        </td>
                                        <td>
                                            <input type="checkbox" style="width: 21px;height: 19px;" onclick="onMultipleCheck('{{ $color->id }}')"/>
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
                        <h6 class="modal-title">Add Codes</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('course_codes.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label for="exampleInputEmail1">course Name</label>
                            <div class="form-group">
                                <select name="course_id" id="course_id" class="form-control mb-1">

                                    @foreach ($course as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" onclick="hideCodeField()" id="get_code" name="get_code">
                                <label for="get_code">Auto Code</label>
                            </div>

                            {{-- </div class="form-group">
                    <label for="exampleInputEmail1">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1"
                        required>
                </div> --}}

                            <div class="form-group">
                                <label for="exampleInputEmail1">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1"
                                    value="1" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Codes</label>
                                <input type="text" class="form-control" id="code" name="code">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">expires Codes</label>
                                <input type="date" class="form-control" id="expires_at" name="expires_at" required>
                            </div>





                            <div class="modal-footer pr-0">
                                <button type="submit" class="btn btn-success">Confirm</button>
                                <button type="button" class="btn btn-secondary mr-0"
                                    data-dismiss="modal">Cancel</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Codes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('course_codes.update') }}" method="post" enctype="multipart/form-data">
                            {{ method_field('post') }}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم الكليه</label>
                                <input type="text" class="form-control" id="name" name="name" required>
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
                        <h6 class="modal-title">Delete Codes</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('course_codes.destroy', 0) }}" method="POST">
                        {{ method_field('POST') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>Are you sure about this?</p><br>
                            <input type="hidden" name="id" id="id" value="">
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
    <script src="{{ URL::asset('js/dashboard/codes.js') }}"></script>
    <script>
        var remove_code = "{{ route('course_codes.destroy') }}";
        var remove_code_group = "{{ route('course_codes.destroyGroup') }}";
    </script>
    <script>
        let table =  $('#Codess').DataTable({
            "iDisplayLength": 35,
            dom: 'Bfrtip',  // Include Buttons
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    title: `Students codes ${new Date()}`,
                    exportOptions: {
                        columns: function (index, data, node) {
                            var totalColumns = $(node).closest('table').find('thead th').length;
                            
                            return index < totalColumns - 2;
                        }
                    }
                },
            ],
            "drawCallback": function(settings) {
                console.log(settings.json);
            }
        });
        table
        function hideCodeField(){
            const item = $('#get_code').is(":checked")
            if(item){
                $('#code').attr('disabled', true);
            }else{
                $('#code').attr('disabled', false);
            }
        }
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
        function imageImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image').attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>



    <script>
        function displaySelectedImage(event) {
            const fileInput = event.target;
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const previewImage = document.getElementById('preview-image');
                    previewImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
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
