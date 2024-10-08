@extends('dashboard.layouts.layout')
@section('css')
<link href="{{URL::asset('css/dashboard/new/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('css/dashboard/new/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('css/dashboard/new/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('css/dashboard/new/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!-- Internal Spectrum-colorpicker css -->
<link href="{{URL::asset('css/dashboard/new/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
<link href="{{URL::asset('css/dashboard/new/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('css/dashboard/new/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!---Internal  Darggable css-->
<link href="{{URL::asset('css/dashboard/new/plugins/darggable/jquery-ui-darggable.css')}}" rel="stylesheet">

@endsection
@section('content-dashboard')



            <div class="breadcrumb-header justify-content-between">
                <div class="my-auto">
                    <div class="d-flex">
                        <h4 class="content-title mb-0 my-auto">Modules</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Add</span>
                    </div>
                </div>
            </div>
            <div class="page-details mt-3">
                @if (Session::has('success'))
                <div id="ui_notifIt" class="success" style="width: 400px; opacity: 1; right: 10px;"><p><b>Success:</b> Well done Details Submitted Successfully</p></div>
                @endif
                @if($action=='add')
                <form action="{{route('module.store')}}" method="POST" enctype="multipart/form-data">
                    @else
                    <form action="{{route('module.update',$module->id)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @endif
                    @csrf
                    <div class="bg-white main-shadow p-4 border">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="cortitle">Module title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="cortitle" value="{{$action=='edit'?$module->name:''}}"
                                       placeholder="Enter Course Title" value="{{old('name')}}" required>
                                @error('name')
                                <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="cortitle">Choose course </label>
                                <select id="SelExample" class="form-control select2" name="courses[]" multiple>
                                    @foreach($courses as $course)
                                        <option @if($action=='edit') @if(in_array($course->id,$selectedCourses)) selected @endif @endif value="{{$course->id}}">{{$course->name}} - by: {{$course->owner->firstname}} {{$course->owner->lastname}} </option>
                                    @endforeach
                                </select>
                                @error('name')
                                <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label for="thumbnail">thumbnail <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control dropify" data-height="200"  id="thumbnail"
                                       placeholder="Enter Course Price">
                                       @if($action=='edit')
                                        @if($module->image)
                                        <input type="hidden" name="imageExist" value="true" />
                                        <div class="border p-2 d-inline-block mt-2">
                                            <img src="{{asset($module->image)}}" width="100" height="100" />
                                        </div>
                                        @else
                                        No Image
                                        @endif
                                       @endif
                                @error('image')
                                <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <button class="btn btn-primary w-100 mt-2 col-12" type="submit">{{ucwords($action)}} Module</button>
                        </div>
                    </div>

                    {{-- <div class="bg-white main-shadow py-4 px-5 border">
                        <h4 class="mb-4">Add Courses</h4>


                    </div> --}}

                </form>
            </div>
@endsection
@section('page_js')
<script src="{{URL::asset('js/dashboard/new/plugins/select2/js/select2.min.js')}}"></script>

<script src="{{URL::asset('js/dashboard/new/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/fileuploads/js/file-upload.js')}}"></script>
<!--Internal Fancy uploader js-->
<script src="{{URL::asset('js/dashboard/new/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/fancyuploder/fancy-uploader.js')}}"></script>
<!--Internal  Form-elements js-->
<!-- Ionicons js -->
<script src="{{URL::asset('js/dashboard/new/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('js/dashboard/new/plugins/pickerjs/picker.min.js')}}"></script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('js/dashboard/new/js/form-elements.js')}}"></script>
<script src="{{ asset('js/dashboard/course.js') }}"></script>
<script src="{{URL::asset('js/dashboard/new/js/modal.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/darggable/jquery-ui-darggable.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/darggable/darggable.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/js/advanced-form-elements.js')}}"></script>

@endsection
