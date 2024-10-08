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
                <h4 class="content-title mb-0 my-auto">Universites /</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">All
                    Universites
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
                        data-toggle="modal" href="#modaldemo8">Add University</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="univeristes">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">University</th>
                                    <th class="wd-15p border-bottom-0">University Image</th>
                                    <th class="wd-15p border-bottom-0">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($universities as $color)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        </td>
                                        <td>{{ $color->name }}</td>
                                        <td>
                                            <div class="image-container">
                                                <img src="{{ $color->image }}" alt="Avatar Image">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="modal-effect btn btn-sm btn-info btn-sm mr-2"
                                                    data-effect="effect-scale" data-id="{{ $color->id }}"
                                                    data-name="{{ $color->name }}" data-toggle="modal"
                                                    href="#exampleModal2" title="تعديل"><i class="las la-pen">

                                                    </i>
                                                </a>
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $color->id }}" data-name="{{ $color->name }}"
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
                        <h6 class="modal-title">Add University</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('university.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">University Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Upload a picture of the University</label>


                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" required>
                                    <label class="custom-file-label" for="image">اختار صوره</label>
                                </div>
                                <img src="#" id="preview"
                                    style="display: none; max-width: 200px; max-height: 200px;">
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Uinversity</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('university.update') }}" method="post" enctype="multipart/form-data">
                            {{ method_field('post') }}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">University</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">اختار صوره</label>
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
                        <h6 class="modal-title">Delete University</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('university.destroy', 0) }}" method="POST">
                        {{ method_field('POST') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>Are you sure about that?</p><br>
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
    <script>
        let table = $('#univeristes').DataTable();
        document.querySelector("#image").addEventListener("change", function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector("#preview").setAttribute("src", e.target.result);
                document.querySelector("#preview").style.display = "block";
            };
            reader.readAsDataURL(this.files[0]);
        });

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

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
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
