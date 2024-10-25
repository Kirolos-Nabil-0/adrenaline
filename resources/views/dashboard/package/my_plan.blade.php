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
            <h4 class="content-title mb-0 my-auto">Plans / 
            <span class="text-muted mt-1 tx-13 mr-2 mb-0"> My Plan </span>
        </h4>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content-dashboard')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="mb-4">{{ $package->name }}</h1>
                
                            <div class="card">
                                <div class="card-body">
                                    <p><strong>Price:</strong> ${{ number_format($package->price, 2) }}</p>
                                    <p><strong>Duration:</strong> {{ $package->duration }} {{ ucfirst($package->duration_type) }}(s)</p>
                
                                    <p><strong>Courses Limit:</strong> 
                                        {{ $package->courses_limit ? $package->courses_limit . ' Courses' : 'Unlimited Courses' }}
                                    </p>
                
                                    <p><strong>Lessons per Course Limit:</strong> 
                                        {{ $package->lessons_per_course_limit ? $package->lessons_per_course_limit . ' Lessons' : 'Unlimited Lessons' }}
                                    </p>
                
                                    <p><strong>Video Upload Support:</strong> 
                                        {{ $package->video_support ? 'Yes' : 'No' }}
                                    </p>
                
                                    @if($package->video_support)
                                        <p><strong>Max Video Size:</strong> 
                                            {{ $package->video_maximum ? $package->video_maximum . ' MB' : 'Unlimited' }}
                                        </p>
                                    @endif
                
                                    <p><strong>Description:</strong></p>
                                    <div>{!! $package->description !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        }
    }
</script>

@endsection