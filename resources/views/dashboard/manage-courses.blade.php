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
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Courses</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Edit
                    Course</span>
            </div>
        </div>
    </div>
    <div class="page-details mt-3">
        @if (Session::has('success'))
            <div id="ui_notifIt" class="success" style="width: 400px; opacity: 1; right: 10px;">
                <p><b>Success:</b> {{Session::get("success") ?? 'Well done Details Submitted Successfully'}}</p>
            </div>
        @endif
        <form id="editCourseForm" action="{{ route('course-update', $courseId->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <div class="row row-sm">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-primary-gradient">
                            <div class="pl-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">Number of lessons</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $lessonsNumber }} {{$lessonsAvailable ? '/'.$lessonsAvailable : ''}}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span> --}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-danger-gradient">
                            <div class="pl-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">Number of sections</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $sections }}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span> --}}
                        </div>
                    </div>
                    {{-- @admin --}}
                    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-success-gradient">
                            <div class="pl-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">Number of enrollment</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $numberStudent }}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <span id="compositeline3"
                                class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span> --}}
                        </div>
                    </div>
                    {{-- @endadmin
                    <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-warning-gradient">
                            <div class="pl-3  pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">Number of Students</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $users }}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                        </div>
                    </div> --}}
                </div>
                <div style="height: 500px" class="bg-white main-shadow p-4 border">
                    <canvas id="myChart"></canvas>
                </div>
            </div>

            <div class="bg-white main-shadow p-4 border">
                <h4 class="mb-4">Course Info</h4>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="cortitle">Course title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cortitle" name="name"
                            value="{{ $courseId->name }}" placeholder="Enter Course Title" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group col-lg-6">
                        <label for="price_ar">Price (EGP)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="price_ar" placeholder="Enter Course Price"
                            name="price_ar" value="{{ $courseId->price_ar }}">
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="price_en">Price (USD)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="price_en" placeholder="Enter Course Price"
                            name="price_en" value="{{ $courseId->price_en }}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="discount_ar">Discount (EGP)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="discount_ar"
                            placeholder="Enter Course Discount" name="discount_ar" min="0" max="100"
                            value="{{ $courseId->discount_ar }}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="discount_en">Discount (USD)<span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="discount_en"
                            placeholder="Enter Course Discount" name="discount_en" min="0" max="100"
                            value="{{ $courseId->discount_en }}">
                    </div>



                    {{-- <div class="form-group col-lg-6">
                        <label for="price">Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control numeric" id="price" value="{{ $courseId->price }}"
                            placeholder="Enter Course Price" name="price">
                        <label for="freecou" class="mt-3">free <span class="text-danger">*</span></label>
                        <input type="checkbox" name="free" @if ($courseId->free) checked @endif
                            id="freecou">
                        @error('price')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div> --}}



                    <div class="form-group col-lg-6">
                        <label for="thumbnail">thumbnail <span class="text-danger">*</span></label>
                        <input type="file" class="dropify" name="image" id="thumbnail" data-height="200" />
                        @if ($courseId->image)
                            <input type="hidden" name="imageExist" value="true" />
                            <div class="border p-2 d-inline-block mt-2">
                                <img src="{{ $courseId->image }}" width="100" height="100" />
                            </div>
                        @else
                            No Image
                        @endif
                        @error('image')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @centeradmin
                        @if ($can_add_authorize)
                            <div class="form-group col-lg-6">
                                <label class="text-danger">The chosen users will be able to add and modify lessons on this
                                    course </label>
                                <select class="form-control select2" name="users[]" id="users" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @if (in_array($user->id, $selectedUsers)) selected @endif>
                                            {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endcenteradmin
                </div>
                <div class="form-group mt-4">
                    <label for="description">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" cols="30" name="description" rows="10">{{ $courseId->description }}</textarea>
                    @error('description')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <label for="freecou" class="mt-3">Free <span class="text-danger">*</span></label>
                <input type="checkbox" name="free" id="freecou" {{ $courseId->free == 1 ? 'checked' : '' }}>
                @error('free')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
                
                <button class="btn btn-primary w-100 my-2 editcourse" type="submit" id="editCourse">Edit
                    Course
                </button>
            </form>

            </div>
            <!-- row -->

            <div class="bg-white main-shadow p-4 border mt-3 sortable">

                <div class="d-flex justify-content-between">
                    <h4 class="mb-4">Lectures</h4>
                    <div class="buttons-lectures mb-4">
                        <a data-effect="effect-scale" data-toggle="modal" href="#section">
                            <button type="button" class="btn btn-primary">Add Section
                            </button>
                        </a>
                        @if (count($courseId->section) > 0)
                            <a data-effect="effect-scale" data-toggle="modal" href="#lectureadd">
                                <button type="button" class="btn btn-danger">Add Lesson
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
                <?php $sectionCount = 1; ?>
                <?php $lectCount = 1; ?>
                <?php $lessonCount = 1; ?>
                <?php $index = 1; ?>

                @foreach ($courseId->section as $sec)
                    <div class="section-lecture mb-3">
                        <form class="remove" method="post" action="{{ route('delete-section', $sec->id) }}">
                            @csrf
                        </form>
                        <div
                            class="position-relative d-flex justify-content-between align-items-center bg-light border mb-2 p-3">
                            <h5 class="m-0"><span class="fw-bold">
                                    ({{ $sec->section_name }})
                                </span></h5>
                            <div class="modal fade" id="section-{{ $sec->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Section</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('update-section', $sec->id) }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="sectionnameedit">title <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="sectionnameedit"
                                                        value="{{ $sec->section_name }}" placeholder="Section Name"
                                                        name="section_name" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Save
                                                        changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="section-butt">
                                <a data-effect="effect-scale" data-toggle="modal" href="#section-{{ $sec->id }}">
                                    <button class="btn btn-primary rounded-0 text-light p-1" type="button">
                                        <i class="fa fa-edit">
                                        </i>
                                    </button>
                                </a>
                                <button class="btn btn-danger rounded-0 text-light p-1 removeLesson" type="button">
                                    <i class="fa fa-trash text-light removesection">
                                        <form class="remove" method="post"
                                            action="{{ route('delete-section', $sec->id) }}">
                                            @csrf
                                        </form>
                                    </i>
                                </button>
                            </div>
                        </div>
                        <div
                            class="p-1 position-relative d-flex justify-content-between align-items-center card-draggable d-none">
                        </div>
                        @foreach ($sec->lesson->sortBy('order') as $les)
                            <div class="border p-3 position-relative mb-3 d-flex justify-content-between align-items-center card-draggable"
                                data-id="{{ $les->id }}">
                                <div>
                                    <span class="fw-bold">{{ $les->lesson_name }}</span>
                                </div>
                                <div class="lecture-butt">
                                    @if ($les->pdf_attach)
                                        <a href="{{ $les->pdf_attach }}" target="_blank"><i
                                                class="fa fa-paperclip text-success" title="Show attached file"></i></a>
                                    @endif
                                    {{ $les->is_lecture_free ? 'Free lecture' : '' }}
                                    <a href="{{ route("edit-lesson", $les) }}">
                                        <button class="btn rounded-0 text-primary p-1" type="button">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>
                                    <button class="btn rounded-0 text-danger p-1 removeLesson" type="button">
                                        <i class="fa fa-trash">
                                            <form action="{{ route('delete-lesson', $les->id) }}" method="post"
                                                class="remove">
                                                @csrf
                                            </form>
                                        </i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

        <!-- modals here -->


        <!-- modal add section here -->

        <div class="modal fade" id="section" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('create-section') }}" method="post">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $courseId->id }}">
                            <label for="sectionname">Section title <span class="text-danger">*</span></label>
                            <input type="text" name="section_name" class="form-control" id="sectionname"
                                placeholder="Section Name" required>
                            @error('section_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                </button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- modal add section here -->
        <!-- modal add lesson here -->
        {{-- <div class="modal" id="modaldemo8">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Modal Header</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h6>Modal Body</h6>
						<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="button">Save changes</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
					</div>
				</div>
			</div>
		</div> --}}

        <div class="modal fade" id="lectureadd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Lesson</h5>
                    </div>
                    <div class="modal-body">
                        @if (auth()->user()->role == 'admin' || ($current_package && $current_package->lessons_per_course_limit > $lessonsNumber))
                            <form action="{{ route('create-lesson') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="lessonname">Lesson title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="lesson_name" id="lessonname"
                                            placeholder="Lesson Name" required>
                                        @error('lesson_name')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sectionselect" class="d-block">Section <span
                                                class="text-danger">*</span></label>
                                        <select name="section_id" id="sectionselect" class="form-control select2-no-search">
                                            @foreach ($courseId->section as $sec)
                                                <option value="{{ $sec->id }}">{{ $sec->section_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (auth()->user()->role == 'admin' || ($current_package && $current_package->video_support))
                                        <div class="col-md-6 form-group">
                                            <label for="video_type" class="d-block">Video Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="video_type" id="video_type" class="form-control">
                                                <option value="video_url">Video URL</option>
                                                <option value="video_upload">Video Upload</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group" id="video_upload_container">
                                            <label for="videoupload">Video Upload <span class="text-danger">*</span></label>
                                            <input type="file" name="video" class="form-control" id="videoupload" accept="video/*">
                                                <div class="progress mt-2">
                                                    <div id="progress" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                        aria-valuemin="0" aria-valuemax="100">0%</div>
                                                </div>
                                                <input type="hidden" name="uploaded_video_path" id="uploaded_video_path">
                                                <!-- Success and Danger Badges -->
                                                <div id="upload-success" class="alert alert-success mt-2" style="display: none;">
                                                    Video uploaded successfully!
                                                </div>
                                                <div id="upload-failure" class="alert alert-danger mt-2" style="display: none;">
                                                    Video upload failed. Please try again.
                                                </div>
                                            @error('uploaded_video_path')
                                                <small class="form-text text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @else
                                    <input type="hidden" name="video_type" value="video_url">
                                    @endif
                                    <div class="col-md-6 form-group" id="video_url_container">
                                        <label for="videourl">Video URL <span class="text-danger">*</span></label>
                                        <input type="url" name="url" class="form-control" id="videourl"
                                            placeholder="URL">
                                        @error('url')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="duration">Duration <span class="text-danger">*</span></label>
                                        <input type="number" min="0" name="duration" class="form-control" id="duration"
                                            placeholder="Duration">
                                        @error('duration')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="mcq_url">MCQ Link </label>
                                        <input type="url" name="mcq_url" class="form-control" id="mcq_url"
                                            placeholder="MCQ Link">
                                        @error('mcq_url')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="is_lecture_free">Lecture free </label>
                                        <input type="checkbox" name="is_lecture_free"
                                            id="is_lecture_free" placeholder="MCQ Link">
                                        @error('is_lecture_free')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="pdf_attach">PDF File </label>
                                        <div class="position-relative">
        
        
                                            <input type="file" name="pdf_attach" class="custom-file-input" id="pdf_attach"
                                                placeholder="pdf attach" accept="application/pdf" >
                                            <label class="custom-file-label" for="pdf_attach">Choose file</label>
                                        </div>
                                        @error('pdf_attach')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        @elseif ($current_package && $current_package->lessons_per_course_limit <= $lessonsNumber)
                            <div class="alert alert-warning">
                                <h5>You have reached out the limit of lessons for this course for your plan which is <b>{{$current_package->lessons_per_course_limit}} lesson for this course</b>.</h5>
                                <h5>Please contact with the admin for more information.</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <h5>You don't have a plan that allows you to add lesson.</h5>
                                <h5>Please contact with the admin for more information.</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- modals here -->
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        let myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthNames) !!},
                datasets: [{
                    label: 'Yearly Course Sales',
                    data: {!! json_encode($totalSales) !!},
                    backgroundColor: {!! json_encode($colors) !!},
                    borderColor: {!! json_encode($colors) !!},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        });

    </script>
    
    @if (auth()->user()->role == 'admin' || ($current_package && $current_package->video_support))
        <script>
            $(document).ready(function () {
                const videoTypeSelect = $('#video_type');
                const videoUrlContainer = $('#video_url_container');
                const videoUploadContainer = $('#video_upload_container');
                const videoUrlInput = $('#uploaded_video_path');
                const videoInput = $('#videoupload');
                const progressBar = $('#progress');
                const progressContainer = $('#progress-container');
                const successBadge = $('#upload-success');
                const failureBadge = $('#upload-failure');
                const submitButton = $('#submit-button');
        
                // Hide video upload container initially
                videoUploadContainer.hide();
                progressContainer.hide();
                successBadge.hide();
                failureBadge.hide();
                progressBar.hide();
        
                // Toggle visibility based on video type selection
                videoTypeSelect.on('change', function () {
                    if (this.value === 'video_url') {
                        videoUrlContainer.show();
                        videoUploadContainer.hide();
                        videoUrlInput.val(''); // Clear any uploaded path
                        successBadge.hide();
                        failureBadge.hide();
                    } else if (this.value === 'video_upload') {
                        videoUrlContainer.hide();
                        videoUploadContainer.show();
                        successBadge.hide();
                        failureBadge.hide();
                    }
                });
        
                // Event listener for when a video is selected for upload
                videoInput.on('change', function () {
                    const videoFile = this.files[0];
                    if (!videoFile) return;
        
                    const formData = new FormData();
                    formData.append('video', videoFile);
        
                    // Reset the badge visibility when a new upload starts
                    successBadge.hide();
                    failureBadge.hide();
                    progressBar.hide();
                    progressContainer.show();
                    submitButton.prop('disabled', true);

                    const maxFileSize = {{ $current_package->video_maximum ?? 500 }} * 1024 * 1024;
                    if (videoFile.size > maxFileSize) {
                        failureBadge.text('File size exceeds the maximum limit of ' + maxFileSize / (1024 * 1024) + ' MB. Please upload a smaller file.').show();
                        videoInput.val(''); // Clear the input
                        progressContainer.hide();
                        return;
                    }
        
                    $.ajax({
                        url: '{{ route("upload-lesson-video") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                        },
                        xhr: function () {
                            const xhr = new window.XMLHttpRequest();
                            progressBar.show();
                            xhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    const percentComplete = (e.loaded / e.total) * 100;
                                    progressBar.css('width', percentComplete + '%');
                                    progressBar.text(Math.round(percentComplete) + '%');
                                }
                            });
                            return xhr;
                        },
                        success: function (response) {
                            // Set the video path in the hidden URL input after successful upload
                            console.log(response)
                            videoUrlInput.val(response.video_path);
                            progressContainer.hide();
                            successBadge.show(); // Show the success badge
                            failureBadge.hide();
                            progressBar.hide();
                            submitButton.prop('disabled', false);
                        },
                        error: function (response) {
                            progressContainer.hide();
                            console.log(response);
                            
                            successBadge.hide();
                            failureBadge.text("").show(); // Show the failure badge
                        }
                    });
                });
            });
        </script>
    @endif
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('js/dashboard/new/chart.js') }}"></script>
    <script src="{{ URL::asset('chartjs/dist/chart.js') }}"></script>
    <script src="{{ URL::asset('node_modules/chartjs/dist/chart.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('js/dashboard/new/js/apexcharts.js') }}"></script>

    <!--Internal  index js -->
    <script src="{{ URL::asset('js/dashboard/new/js/index.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/js/jquery.vmap.sampledata.js') }}"></script>


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

    <script src="{{ URL::asset('js/dashboard/new/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}">
    </script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}">
    </script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('js/dashboard/new/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('js/dashboard/new/js/form-elements.js') }}"></script>
    <script src="{{ asset('js/dashboard/course.js') }}"></script> 
    <script src="{{ URL::asset('js/dashboard/new/js/modal.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/darggable/jquery-ui-darggable.min.js') }}"></script>
    <script src="{{ URL::asset('js/dashboard/new/plugins/darggable/darggable.js') }}"></script>
@endsection
