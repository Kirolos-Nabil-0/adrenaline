@extends('dashboard.layouts.layout')
@section('css')
    <style>
        .stars li {
            cursor: pointer;
        }
    </style>
    <link href="{{ URL::asset('css/dashboard/new/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('css/dashboard/new/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('css/dashboard/new/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('css/dashboard/new/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('css/dashboard/new/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/dashboard/new/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet"
        type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('css/dashboard/new/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!---Internal  Darggable css-->
    <link href="{{ URL::asset('css/dashboard/new/plugins/darggable/jquery-ui-darggable.css') }}" rel="stylesheet">
@endsection

@section('content-dashboard')
    {{-- @include('dashboard.layouts.navbar') --}}

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Courses</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ View
                    Courses</span>
            </div>
        </div>
    </div>
    <div class="">

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('create-course') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="bg-white main-shadow p-4 border">
                <h4 class="mb-4">Course Info</h4>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="cortitle">Course title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cortitle" name="name"
                            placeholder="Enter Course Title" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="exampleInputEmail1">Course Type</label>
                        <select id="type" name="type" class="form-control SlectBox" required
                            onchange="toggleFields()">
                            <option value="universities" selected>Universities Courses</option>
                            <option value="public">General Courses</option>
                            <option value="high_school">Course High School</option>
                            <option value="public_medicine">General medicine Courses</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-6" id="universityField">
                        <label for="exampleInputEmail1">University Name</label>
                        <select id="university" name="university" class="form-control SlectBox">
                            <option selected disabled>Select University</option>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($universities as $university)
                                @php
                                    $i++;
                                @endphp
                                <option value="{{$university->id}}">{{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-6" id="collegeField">
                        <label for="exampleInputEmail1">College Name</label>
                        <select id="college_id" name="college_id" class="form-control SlectBox">
                            <option value="">Select University first</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-6" id="collegeYearField">
                        <label for="exampleInputEmail1">College year</label>
                        <select id="college_year" name="college_year" class="form-control SlectBox">
                            <option value="">College year</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-6" id="semesterField">
                        <label for="exampleInputEmail1">Semester</label>
                        <select id="semester" name="semester" class="form-control SlectBox">
                            <option value="1" selected>First semester</option>
                            <option value="2">Second semester</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="price_ar">Price (EGP)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="price_ar" placeholder="Enter Course Price"
                            name="price_ar">

                        <label for="price_en">Price (USD)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="price_en" placeholder="Enter Course Price"
                            name="price_en">

                        <label for="discount_ar">Discount (EGP)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="discount_ar"
                            placeholder="Enter Course Discount" name="discount_ar" min="0" max="100">

                        <label for="discount_en">Discount (USD)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="discount_en"
                            placeholder="Enter Course Discount" name="discount_en" min="0" max="100">


                        <label for="freecou" class="mt-3">free <span class="text-danger">*</span></label>
                        <input type="checkbox" name="free" id="freecou">
                        @error('price')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="thumbnail">thumbnail <span class="text-danger">*</span></label>
                        {{-- <input type="file" name="image" class="form-control" id="thumbnail"
                                    placeholder="Enter Course Price" required> --}}
                        <input type="file" class="dropify" name="image" id="thumbnail" data-height="200"
                            required />
                        @error('image')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" cols="30" name="description" rows="10"></textarea>
                        @error('description')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <button class="btn btn-primary w-100 mt-2 " type="submit">Add Course</button>
            </div>

        </form>

    </div>
@endsection
@section('page_js')
    <script>
        function toggleFields() {
            var courseType = document.getElementById("type").value;
            var universityField = document.getElementById("universityField");
            var collegeField = document.getElementById("collegeField");
            var collegeYearField = document.getElementById("collegeYearField");
            var semesterField = document.getElementById("semesterField");

            if (courseType === "universities") {
                universityField.style.display = "block";
                collegeField.style.display = "block";
                collegeYearField.style.display = "block";
                semesterField.style.display = "block";
            } else {
                universityField.style.display = "none";
                collegeField.style.display = "none";
                collegeYearField.style.display = "none";
                semesterField.style.display = "none";
            }
        }
        // Initial call to toggleFields to ensure correct visibility on page load
        toggleFields();
    </script>
    <script src="{{ asset('js/dashboard/course.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#university').on('change', function() {
                var categoryId = $(this).val();
                var subCategoryDropdown = $('#college_id');
                var subCategoryDropdowncollege = $('#college_year');
                var x = 1;
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

                            subCategoryDropdown.empty();
                            subCategoryDropdown.append(`
                                        <option selected disabled>Please select the collage</option>
                                    `)
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
            $('#college_id').on('change', function() {
                var collegeId = $(this).val();
                var collegeYearDropdown = $('#college_year'); // تعديل اسم المتغير
                console.log("######################################");
                console.log(collegeId);
                console.log(collegeYearDropdown); // تعديل اسم المتغير
                console.log("######################################");
                if (collegeId) {
                    // Make an AJAX request to fetch the years based on the selected college
                    $.ajax({
                        url: '{{ route('collegeyear.collegeyearbyid') }}',
                        type: 'GET',
                        data: {
                            id: collegeId // تعديل اسم المتغير
                        },
                        success: function(response) {
                            console.log(response);
                            console.log("------------------");
                            console.log(response.data);
                            collegeYearDropdown.empty(); // تعديل اسم المتغير
                            $.each(response, function(key,
                                value) { // تعديل response.data بدلاً من response
                                console.log(value.id + "-------------------------" +
                                    key);
                                collegeYearDropdown.append(
                                    '<option  value="' + value.id + '">' + value
                                    .year_number +
                                    '</option>'
                                );
                            });
                        }
                    });
                } else {
                    // Clear the college year dropdown if no college is selected
                    collegeYearDropdown.empty(); // تعديل اسم المتغير
                }
            });
        });
    </script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('js/dashboard/new/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('js/dashboard/new/js/advanced-form-elements.js') }}"></script>

    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <!--Internal  jquery-simple-datetimepicker js -->
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('js/dashboard/new/js/form-elements.js') }}"></script>
    <script src="{{ asset('js/dashboard/course.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/js/modal.js') }}"></script>
@endsection
