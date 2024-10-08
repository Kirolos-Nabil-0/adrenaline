@extends('layouts.layout')
@section('page_css')
    {{-- <style>
        body {
            background-color: #f8f9fd;
        }
    </style> --}}
@endsection
@section('content')
    {{-- <div class="container">
        <div class="col-lg-4 col-md-6 m-auto rounded form-register position-relative">
            <div class="d-flex justify-content-around form-buttons-select">
                <p class="active" data-div="login">تسجيل</p>
                <p data-div="register"><a href="{{ route('register') }}">حساب جديد</a></p>
            </div>
            <div class="text-center">
                <img src="{{asset('images/logo.png')}}" class="rounded-circle" width="100px" height="100px"
                     alt="">            </div>
            <div>
                <form action="{{ route('login') }}" method="post" class="login">
@csrf
                    <h5 class="my-4 text-center">تسجيل الدخول</h5>
                    <div class="form-group mb-3 position-relative">
                        <i class="fa fa-envelope position-absolute"></i>
                        <input type="email" name="email" class="form-control py-2" id="emailLogin"
                               placeholder="البريد الالكتروني" value="{{old('email')}}" @error('email') is-invalid @enderror">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative">
                        <i class="fa fa-key position-absolute"></i>
                        <input type="password" name="password" class="form-control py-2" id="password"
                               placeholder="كلمة السر" @error('password') is-invalid @enderror">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <input style="display: none" type="checkbox" checked name="remember">
                    <button class="btn btn-primary w-100 mt-3 py-3" type="submit">تسجيل الدخول</button>
                </form>
                <form class="register" style="display: none;" method="POST" action="{{ route('register') }}">
                    @csrf
                    <h5 class="my-4 text-center">تسجيل حساب جديد</h5>
                    <div class="form-group mb-3 position-relative">
                        <i class="fa fa-user position-absolute"></i>
                        <input type="text" name="firstname" class="form-control py-2" id="name"
                               value="{{old('firstname')}}"
                               placeholder="الاسم الاول">

                    </div>
                    <div class="form-group mb-3 position-relative">
                        <i class="fa fa-user-check position-absolute"></i>
                        <input type="text" name="lastname" class="form-control py-2" id="name2"
                               placeholder="الاسم الاوسط والاخير">
                    </div>
                    <div class="form-group mb-3 position-relative">
                        <i class="fa fa-envelope position-absolute"></i>
                        <input type="email" name="email" class="form-control py-2" id="email"
                               placeholder="البريد الالكتروني">
                    </div>
                    <div class="form-group mb-3 position-relative">
                        <i class="fa fa-key position-absolute"></i>
                        <input type="password" name="password" class="form-control py-2" id="password2"
                               placeholder="كلمة السر">
                    </div>
                    <div class="form-group position-relative">
                        <i class="fa fa-key position-absolute"></i>
                        <input type="password" name="password_confirmation" class="form-control py-2" id="repassword"
                               placeholder="تأكيد كلمة السر">
                    </div>
                    <input style="display: none" type="checkbox" checked name="remember">
                    <button class="btn btn-primary w-100 mt-3 py-3" type="submit">تسجيل حساب جديد</button>
                </form>
            </div>
        </div>
    </div> --}}
    <section class="login-area">
        <div class="container">
              <div class="row">
                 <div class="col-lg-8 offset-lg-2">
                    <div class="basic-login border-0">
                        <div class="text-center">
                            <img src="{{asset('images/logo.png')}}" class="rounded-circle text-center" width="150" height="150" alt="">
                          </div>
                          <h3 class="text-center mb-60 mt-4">Login</h3>

                          <form action="{{ route('login') }}" method="post" id="loginForm">
                            @csrf
                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="invalid-email"></strong>
                            </span>
                            <span class="invalid-feedback d-block" role="alert">
                                <strong id="invalid-password"></strong>
                            </span>
                            <div class="form-group">
                                <label for="email">Email <span>*</span></label>
                                <input id="email" name="email" type="email" placeholder="Enter Email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" />
                            </div>
                            <div class="form-group">
                                <label for="password">Password <span>*</span></label>
                                <input id="password" name="password" type="password" placeholder="Enter password..." class="@error('password') is-invalid @enderror" />
                            </div>
                        
                            <div class="mt-10"></div>
                        
                            <div class="form-group">
                                <button class="tp-btn w-100" id="submit-button" type="submit">Login Now</button>
                                <div class="or-divide"><span>or</span></div>
                                <a href="{{ route('register') }}" class="tp-border-btn w-100">Register Now</a>
                            </div>
                        </form>
                        
                    </div>
                 </div>
              </div>
        </div>
     </section>
@endsection
@section("page_js")
   <script>
    $(document).ready(function () {
    $('#loginForm').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission
        var formData = $(this).serialize(); // Serialize the form data
        $("#submit-button").html("Login Now <i class='fa fa-spinner fa-spin'></i>")
        // Make an Ajax request to submit the form data

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            success: function (response) {

                if (response) {
                    window.location.href = '{{ route('home') }}';
                    $("#submit-button").html("Logged In successfully <i class='fa fa-correct'></i>")
                }
            },
            error: function(error){
                var message = error.responseJSON.message
                var error = error.responseJSON.errors
                
                if (message) {
                    $("#submit-button").html("Login Now")
                    if (error.email) {
                    console.log($('#invalid-email'))

                        $('#invalid-email').text(error.email[0]);
                    } else {
                        $('#invalid-email').text('');
                    }

                    if (error.password) {
                        $('#invalid-password').text(error.password[0]);
                    } else {
                        $('#invalid-password').text('');
                    }
                }else{
                    console.log("no message")
                }
            }
        });
    });
});
   </script>
@endsection
