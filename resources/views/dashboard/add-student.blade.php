@extends('dashboard.layouts.layout')
@section('css')
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('css/dashboard/new/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!---Internal  Darggable css-->
<link href="{{URL::asset('css/dashboard/new/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<style>
    .add-students-sm{
        display: none
    }
    @media(max-width:767px){
        .add-students-lg{
            display: none
        }
        .add-students-sm{
            display: block
        }
    }
</style>

@endsection
@section('content-dashboard')

    <div class="mt-3">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Enroll</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Add</span>
        </div>
        <div class="mt-3 bg-white fw-bold main-shadow p-4">
            @if (Session::has('success'))
            <div id="ui_notifIt" class="success" style="width: 400px; opacity: 1; right: 10px;"><p><b>Success:</b> Well done Details Submitted Successfully</p></div>
            @endif
            <form action="{{ route('enrollment') }}" method="post">
                @csrf
                <div class="add-students-sm">
                    <label for="SelExample">Select User</label>
                    <select name="users[]" id="SelExample" class="px-3 select2"  required>
        
                        {{-- <option value="0" selected disabled>Select students</option> --}}
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->email . ' - ' . $user->firstname . ' ' . $user->lastname }}</option>
                        @endforeach
                    </select>
    
                </div>
                <div class="add-students-lg">
                    <label for="SelExample">Select User</label>
                    <select name="users[]" id="SelExample2" class="px-3 select2"  required multiple>
        
                        {{-- <option value="0" selected disabled>Select students</option> --}}
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->email . ' - ' . $user->firstname . ' ' . $user->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="status" class="mt-4">Select Course Status</label>
                <select name="status" id="status" class="form-control select-form">
                    <option value="" disabled selected>Status</option>
                    <option value="0">close</option>
                    <option value="1">open</option>
                </select>
    
    
                {{-- <div class="bg-white main-shadow p-3 mt-4 border"> --}}
                {{-- <button id="but_read" class="btn btn-primary mt-3 mb-3">Selected Value</button> --}}
                {{-- <div id="result"></div> --}}
                {{-- </div> --}}
                <div class="row mt-4 px-3">
                    <label for="selectcourse" >Select Course</label>
                    <select id="selectcourse" name="course_id" class="select2 px-3">
                        <option value="0" selected disabled>Select course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row mt-4 px-3">
                    <label for="selectmodule" >Select Module</label>
                    <select id="selectmodule" name="module" class="select2 px-3">
                        <option value="0" selected disabled>Select Module</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module->module_id }}/{{$module->user_id}}">{{ $module->module_name }} - by: {{$module->user_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <input value="Enroll By Course" name="enroll_course" class="btn btn-success mb-2" type="submit" />
                    <input value="Enroll By Module" name="enroll_module" class="btn btn-primary mb-2" type="submit" />
                </div>
            </form>
        </div>
    </div>
    </div>

@endsection
@section("js")
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
<script>
    function myFunction(x) {
  if (x.matches) { // If media query matches
    SelExample2.disabled = true
  }
}

var x = window.matchMedia("(max-width: 700px)")
myFunction(x) // Call listener function at run time
x.addListener(myFunction) // Attach listener function on state changes

</script>
<!-- Internal Select2.min js -->
<!--Internal Ion.rangeSlider.min js -->
<!--Internal  jquery-simple-datetimepicker js -->
<!-- Internal form-elements js -->

@endsection
