@extends('dashboard.layouts.layout')
@section('content-dashboard')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">Courses / {{ $course->name }}/ Lessons/ {{$les->lesson_name}}</span>
            </div>
        </div>
    </div>
    <div class="page-details mt-3">
        @if (Session::has('success'))
            <div id="ui_notifIt" class="success" style="width: 400px; opacity: 1; right: 10px;">
                <p><b>Success:</b> Well done Details Submitted Successfully</p>
            </div>
        @endif

        <div class="bg-white main-shadow p-4 border">
            <h4 class="mb-4">Edit Lesson</h4>
            <form action="{{ route('update-lesson', $les->id) }}"
                enctype="multipart/form-data" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="lessonnameedit">Lesson title <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lessonnameedit"
                            name="lesson_name" value="{{ $les->lesson_name }}"
                            placeholder="Lesson Name" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="sectionselect">Section <span
                                class="text-danger">*</span></label>
                        <select name="section_id" id="sectionselect"
                            class="form-control">

                            @foreach ($sections as $sec)
                                <option value="{{ $sec->id }}"
                                    @if ($sec->id == $les->section_id) selected @endif>
                                    {{ $sec->section_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="video_type" class="d-block">Video Type <span
                                class="text-danger">*</span></label>
                        <select name="video_type" id="video_type" class="form-control">
                            <option value="video_url" {{ $les->video_type == 'video_url' ? 'selected' : '' }}>Video URL</option>
                            <option value="video_upload" {{ $les->video_type == 'video_upload' ? 'selected' : '' }}>Video Upload</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group" id="video_url_container">
                        <label for="videourl">Video URL <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control" id="videourl"
                            value="{{ $les->url }}">
                        @error('url')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group" id="video_upload_container">
                        <label for="videoupload">Video Upload <span class="text-danger">*</span></label>
                        <input type="file" name="video" class="form-control" id="videoupload">
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
                        @if ($les->video_type == 'video_upload' && $les->video)
                            <div class="col-md-6 form-group">
                                <video controls style="width: 100%; max-height: 500px;">
                                    <source src="{{ asset($les->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="duration">Duration <span
                                class="text-danger">*</span></label>
                        <input type="number" min="0" name="duration" class="form-control"
                            id="duration" placeholder="Duration"
                            value="{{ $les->duration }}">
                        @error('duration')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="mcq_url">MCQ Link </label>
                        <input type="url" name="mcq_url" class="form-control"
                            id="mcq_url" placeholder="MCQ Link"
                            value="{{ $les->mcq_url }}">
                        @error('mcq_url')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="pdf_attach">PDF File </label>
                        <div class="position-relative">
                            <input type="file" name="pdf_attach"
                                class="custom-file-input" id="pdf_attach"
                                placeholder="pdf attach" accept="application/pdf">
                            <label class="custom-file-label" for="pdf_attach">Choose
                                file</label>
                            @error('pdf_attach')
                                <small
                                    class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>
                        <div class="">
                            @if ($les->pdf_attach)
                                <a class="btn btn-success" target="_blank"
                                    href="{{ $les->pdf_attach }}">Show attached
                                    file</a>
                            @else
                                No attachments
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="is_lecture_free">Lecture free</label>
                        <br>
                        <input type="checkbox" name="is_lecture_free" id="is_lecture_free" 
                        placeholder="MCQ Link" value="{{ $les->is_lecture_free }}" 
                        {{ $les->is_lecture_free ? 'checked' : '' }}>
                        @error('is_lecture_free')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <button type="submit" id="submit-button" class="btn btn-primary w-100">Update Lesson</button>
            </form>

        </div>

@endsection

@section('js')
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
        videoUrlContainer.hide();
        progressContainer.hide();
        successBadge.hide();
        failureBadge.hide();
        progressBar.hide();

        const defaultVideoType = videoTypeSelect.val(); // Get the selected value from the dropdown
        if (defaultVideoType === 'video_url') {
            videoUrlContainer.show();
        } else if (defaultVideoType === 'video_upload') {
            videoUploadContainer.show();
        }

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
                    videoUrlInput.val(response.video_path);
                    progressContainer.hide();
                    successBadge.show(); // Show the success badge
                    failureBadge.hide();
                    progressBar.hide();
                    submitButton.prop('disabled', false);
                },
                error: function (jqXHR) {
                    progressContainer.hide();
                    successBadge.hide();
                    failureBadge.show(); // Show the failure badge
                }
            });
        });
    });

    </script>
@endsection
