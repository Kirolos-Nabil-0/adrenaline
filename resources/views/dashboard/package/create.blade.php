@extends('dashboard.layouts.layout')
@section('css')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .ck-editor__editable {
            min-height: 150px; /* Set your desired minimum height */
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Packages /</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> Create
                Package
            </span>
        </div>
        <a class="btn btn-primary btn-inline-block" href="{{route("packages.index")}}">All Packages</a>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content-dashboard')

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route("packages.store")}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">Package Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{old("name")}}" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="price">Package Price <span class="text-danger">*</span></label>
                                    <input type="number" min="0" step="0.01" name="price" id="price" value="{{old("price")}}" class="form-control">
                                    @error('price')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="duration_type">Package Duration Type <span class="text-danger">*</span></label>
                                    <select name="duration_type" id="duration_type" class="form-control">
                                        <option value="year">Per Year</option>
                                        <option value="month" {{old("duration_type" == 'month' ? 'selected' : '')}}>Per Month</option>
                                        <option value="week" {{old("duration_type" == 'week' ? 'selected' : '')}}>Per Week</option>
                                        <option value="day" {{old("duration_type" == 'day' ? 'selected' : '')}}>Per Day</option>
                                    </select>
                                    @error('duration_type')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="duration">Package Duration <span class="text-danger">*</span></label>
                                    <input type="number" min="0" name="duration" id="duration" value="{{old("duration")}}" class="form-control">
                                    @error('duration')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="courses_limit">Courses Limit <span class="text-danger">*</span> <span class="text-muted">(If You leave it, it will be unlimited)</span></label>
                                    <input type="number" min="1" name="courses_limit" id="courses_limit" placeholder="Maximum number of courses for each consumer." value="{{old("courses_limit")}}" class="form-control">
                                    @error('courses_limit')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="lessons_per_course_limit">Lessons Per Course Limit <span class="text-danger">*</span> <span class="text-muted">(If You leave it, it will be unlimited)</span></label>
                                    <input type="number" min="1" name="lessons_per_course_limit" id="lessons_per_course_limit" placeholder="Maximum number of lessons for each course." value="{{old("lessons_per_course_limit")}}" class="form-control">
                                    @error('lessons_per_course_limit')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" name="video_support" id="video_support" {{old("video_support") == 'on' ? 'checked' : ''}} onchange="supportVideo()">
                                    <label for="video_support" class="form-check-label">Video Upload Support <span class="text-danger">*</span></label>
                                    @error('video_support')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6" id="video_maximum_container" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="video_maximum">Video Maximum in MB <span class="text-danger">*</span>  <span class="text-muted">(If You leave it, it will be unlimited)</span></label>
                                    <input type="number" min="5" name="video_maximum" id="video_maximum" value="{{old("video_maximum")}}" class="form-control">
                                    @error('video_maximum')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="10" class="form-control"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.umd.js"></script>
<script>
    const {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph,
        Table,
        List
    } = CKEDITOR;

    ClassicEditor
        .create( document.querySelector( '#description' ) , {
            plugins: [ Essentials, Bold, Italic, Font, Paragraph, Table, List ],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        } )
        .then( /* ... */ )
        .catch( /* ... */ );
</script>
<script>
    function supportVideo(e){
        const checkbox = document.getElementById('video_support');
        const additionalInputContainer = document.getElementById('video_maximum_container');

        if (checkbox.checked) {
            additionalInputContainer.style.display = 'block'; // Show the additional input
        } else {
            additionalInputContainer.style.display = 'none'; // Hide the additional input
            document.getElementById('video_maximum').value = null; // Clear the input value if unchecked
        }
    }
</script>

@endsection