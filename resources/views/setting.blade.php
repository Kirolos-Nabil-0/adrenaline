@extends('layouts.layout')
@section('content')
    @include('layouts.navbar')
    <section class="breadcrumb__area include-bg pt-250 pb-150 breadcrumb__overlay">
        <div class="shadow w-100 position-absolute h-100 start-0 top-0 bg-light"></div>
        <div class="container">
           <div class="row">
              <div class="col-xxl-12">
                 <div class="breadcrumb__content p-relative z-index-1">
                    <h3 class="breadcrumb__title mb-20">Settings</h3>
                 </div>
              </div>
           </div>
        </div>
     </section>
    <div class="dashboard-content-side pt-115 pb-110">
        <div class="container mb-5">
            <form action="{{route('update-info')}}" method="post" class="form-edit-info basic-login border-0" enctype="multipart/form-data">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('success')}}
                    </div>
                @endif
                @csrf
                {{-- <div class="form-group mb-3 position-relative text-center">
                    <div class="profile-pic" style="position:relative;">
                        <label class="-label position-relative" for="file">
                            <span class="glyphicon glyphicon-camera"></span>
                            <span>تغيير الصورة</span>
                            <button type="button" class="btn btn-transparent"
                                style="position: absolute;top: 0;left: 5px;z-index: 99999;" title="حذف الصورة"
                                id="removeImageBtn"
                                data-type="{{$user->profile_photo_path?1:0}}"
                                data-empty="{{asset('images/user.jpg')}}"><i class="fa fa-trash text-danger"></i>
                            </button>
                        </label>
                        <input id="file" type="file" name="profile_photo_path" onchange="loadFile(event)"/>
                        <img src="{{asset($user->profile_photo_path??'images/user.jpg')}}" id="output"
                             width="200"/>
                    </div>
                </div> --}}
                <div class="form-group mb-3 position-relative">
                    <label for="name">First Name</label>
                    <input type="text" id="name" name="firstname" value="{{$user->firstname}}"
                           placeholder="الاسم الاول">
                    @error('firstname')
                    <small class="form-text text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group mb-3 position-relative">
                    <label for="name2">Last Name</label>
                    <input type="text" id="name2" name="lastname" value="{{$user->lastname}}"
                           placeholder="الاسم الاوسط والاخير">
                    @error('lastname')
                    <small class="form-text text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group mb-3 position-relative">
                    <label for="email">Email</label>
                    <input type="email" class="font-family" name="email" id="email"
                           value="{{$user->email}}"
                           placeholder="البريد الالكتروني">
                    @error('email')
                    <small class="form-text text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group mb-3 position-relative">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" value=""
                           placeholder="Password">
                    @error('password')
                    <small class="form-text text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group position-relative">
                    <label for="repassword">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="repassword"
                           value=""
                           placeholder="Confirm Password">

                </div>
                <button class="tp-btn w-100 w-100 mt-3" type="submit">Save Changes</button>
            </form>
        </div>

    </div>

    <form id="removeImageForm" method="post" action="{{route('remove-image')}}">
        @csrf
    </form>
@endsection
@section('page_js')
    <script>
        $('#removeImageBtn').on('click', function () {
            var type = $(this).data('type');
            var empty = $(this).data('empty');
            if (type == 1) {
                $('#removeImageForm').submit()
            } else {
                $('#file').val('');
                $('#output').attr('src', empty);
            }

        })
    </script>
@endsection
