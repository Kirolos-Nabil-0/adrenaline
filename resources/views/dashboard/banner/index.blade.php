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
                <h4 class="content-title mb-0 my-auto">Banners /</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">All
                    Banners
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
                        data-toggle="modal" href="#modaldemo8">Add Banners</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="univeristes">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">Banner name</th>
                                    <th class="wd-15p border-bottom-0">Banner image</th>
                                    <th class="wd-15p border-bottom-0">Banner Type</th>
                                    <th class="wd-20p border-bottom-0">Creation date</th>
                                    <th class="wd-20p border-bottom-0">Operations</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($banners as $banner)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        </td>
                                        <td>{{ $banner->name }}</td>
                                        <td>
                                            <div class="image-container">
                                                <img src="{{ asset($banner->image) }}" alt="Avatar Image">
                                            </div>
                                        </td>
                                        <td>{{ $banner->type }}</td>
                                        <td>{{ $banner->created_at }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="main-toggle main-toggle-success {{ $banner->status == true ? 'on' : '' }} btn-sm ml-2"
                                                    data-banner-id="{{ $banner->id }}">
                                                    <span></span>
                                                </div>
                                                <a class="modal-effect btn btn-sm btn-info btn-sm ml-2"
                                                    data-effect="effect-scale" data-id="{{ $banner->id }}"
                                                    data-name="{{ $banner->name }}" data-type="{{ $banner->type }}"
                                                    data-status="{{ $banner->status }}"
                                                    data-arrange="{{ $banner->arrange }}"
                                                    data-url="{{ $banner->url }}"
                                                    data-image="{{ $banner->image }}" data-toggle="modal"
                                                    href="#exampleModal2" title="تعديل"><i class="las la-pen">

                                                    </i>
                                                </a>



                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $banner->id }}" data-name="{{ $banner->name }}"
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
                        <h6 class="modal-title">add Banner</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('banners.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="exampleInputEmail1">Banner Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <label for="exampleInputEmail1">Select type</label>
                            <div class="form-group">
                                <select id="type" name="type" class="form-control SlectBox" required>
                                    <option selected disabled>Select type</option>
                                    <option value="college">
                                        Universities Department
                                    </option>
                                    <option value="public_course">
                                        General courses
                                    </option>
                                    <option value="main">
                                        main screen
                                    </option>

                                    <option value="plus">
                                        public medicine
                                    </option> 
                                    <option value="high_school">
                                        high school
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Banner Arrange</label>
                                <input type="number" class="form-control" id="arrange" name="arrange">
                            </div>
                            <div class="form-group">
                                <label for="image">image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image"
                                        required>
                                    <label class="custom-file-label" for="image">اختار صوره</label>
                                </div>
                                <img src="#" id="image"
                                    style="display: none; max-width: 200px; max-height: 200px;">
                            </div>

                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="text" class="form-control" id="url" name="url">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">sure</button>
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
                        <h5 class="modal-title"id="exampleModalLabel">Modify Banner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('banners.update') }}" method="post" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Banner Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleInputEmail1">Banner Type</label>
                                <input type="text" class="form-control" id="type" name="type" required>
                            </div> --}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Banner Arrange</label>
                                <input type="number" class="form-control" id="arrange" name="arrange">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">صوره الاعلان</label>
                                <input class="form-control" name="image" id="image" type="file"
                                    onchange="displaySelectedImage(event)">
                                <img src="image" id="preview-image" class="img-thumbnail"
                                    style="width: 100px; height: 100px;">
                            </div>
                            
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="text" class="form-control" id="url" name="url">
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
                        <h6 class="modal-title">Delete Banner</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('banners.destroy', 0) }}" method="post">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>Are you sure about the deletion process?</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input class="form-control" name="name" id="name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">sure</button>
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
        $(document).ready(function() {
            $('.main-toggle').on('click', function() {
                $(this).toggleClass('on');
                var isToggleOn = $(this).hasClass('on');
                var url = '{{ route('banners.update-status') }}';
                var categoryId = $(this).data('banner-id');
                // Retrieve the CSRF token value from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        isToggleOn: isToggleOn,
                        categoryId: categoryId
                    },
                    success: function(response) {
                        console.log(response);
                        // Handle the success response
                    },
                    error: function(error) {
                        console.log(error);
                        // Handle the error response
                    }
                });
            });
        });
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
                var type = button.data('type')
                var arrange = button.data('arrange')
                var status = button.data('status')
                var image = button.data('image')
                var url = button.data('url')
                var modal = $(this)
                modal.find('.modal-body #id').val(id)
                modal.find('.modal-body #name').val(name)
                modal.find('.modal-body #preview-image').attr('src', image)
                modal.find('.modal-body #type').val(type)
                modal.find('.modal-body #url').val(url)
                modal.find('.modal-body #arrange').val(arrange)
                modal.find('.modal-body #status').val(status)
            })
        });
    </script>
@endsection
