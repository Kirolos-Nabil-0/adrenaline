@extends('layouts.layout')
@section('page_css')
    {{-- <style>
        body {
            background-color: #f8f9fd;
            display: grid;
            height: 100vh;
            place-items: center;
        }
    </style> --}}
@endsection
@section('content')
    {{-- <div class="container">
        <div class="col-lg-4 col-md-6 m-auto rounded form-register position-relative">
            <div class="d-flex justify-content-around form-buttons-select">
                <p data-div="login">تسجيل</p> --}}
                {{-- <p class="active" data-div="register">حساب جديد</p>
            </div>
            <div class="text-center">
                <img src="{{asset('images/logo.png')}}" class="rounded-circle" width="100px" height="100px" alt="">
            </div>
            <div>
                <form class="register" method="POST" action="{{ route('register') }}">
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
                   <input type="hidden" name="ip" class="ip-user" id="ip">
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
                      <h3 class="text-center mb-30 mt-4">Register</h3>
                      <form action="{{ route('register') }}" method="POST" id="loginForm">
                        @csrf
                        <span class="invalid-feedback d-block" role="alert">
                            <strong id="invalid-email"></strong>
                        </span>
                        <span class="invalid-feedback d-block" role="alert">
                            <strong id="invalid-password"></strong>
                        </span>
                        <div class="form-group">
                            <label for="firstname">First Name <span>*</span></label>
                            <input id="firstname" name="firstname" type="text" placeholder="Enter First Name" value="{{ old('firstname') }}" class="@error('firstname') is-invalid @enderror" required/>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name <span>*</span></label>
                            <input id="lastname" name="lastname" type="text" placeholder="Enter First Name" value="{{ old('lastname') }}" class="@error('lastname') is-invalid @enderror" required/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span>*</span></label>
                            <input id="email" name="email" type="email" placeholder="Enter Email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror" required/>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span>*</span></label>
                            <input id="password" name="password" type="password" placeholder="Enter password..." class="@error('password') is-invalid @enderror" required/>
                        </div>
                        <div class="form-group">
                            <label for="repassword">Re Password <span>*</span></label>
                            <input id="repassword" name="password_confirmation" type="password" placeholder="Enter password..." class="@error('password_confirmation') is-invalid @enderror" required/>
                        </div>
                        <div class="mt-10"></div>
                    
                        <div class="form-group">
                            <button class="tp-btn w-100" id="submit-button" type="submit">Register Now</button>
                            <div class="or-divide"><span>or</span></div>
                            <a href="{{ route('login') }}" class="tp-border-btn w-100">Login Now</a>
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
        $("#submit-button").html("Register Now <i class='fa fa-spinner fa-spin'></i>")
        // Make an Ajax request to submit the form data
        $('#invalid-password').text('');
        $('#invalid-email').text('');

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            success: function (response) {

                if (response) {
                    window.location.href = '{{ route('home') }}';
                    $("#submit-button").html("Registerd successfully <i class='fa fa-correct'></i>")
                }
            },
            error: function(error){
                var message = error.responseJSON.message
                var error = error.responseJSON.errors
                
                if (message) {
                    $("#submit-button").html("Register Now")

                    console.log(error)
                    if (error.email) {
                    console.log($('#invalid-email'))

                        $('#invalid-email').text(error.email[0]);
                    }
                    if (error.password) {
                        error.password.forEach(password => {
                            console.log(password)
                            $('#invalid-password')[0].innerHTML += password + '<br>'
                        });
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
