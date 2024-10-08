@extends('layouts.layout')
@section('page_css')
    <style>
        body {
            background-color: #f8f9fd;
            display: grid;
            height: 100vh;
            place-items: center;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="col-lg-4 col-md-6 m-auto rounded form-register position-relative">
            <div class="d-flex justify-content-around form-buttons-select">
                <p class="active" data-div="login">تسجيل</p>
                <p data-div="register">حساب جديد</p>
            </div>
            <div class="text-center">
                <img src="{{asset('images/logo.png')}}" class="rounded-circle" width="100px" height="100px"
                     alt=""></div>
            <div>
                <form action="{{ route('login') }}" method="post" class="login">
                    @csrf
                    <h5 class="my-4 text-center">تسجيل الدخول</h5>
                    <div class="form-group mb-3 position-relative">
                        <i class="fa fa-envelope position-absolute"></i>
                        <input type="email" name="email" class="form-control py-2" id="emailLogin"
                               placeholder="البريد الالكتروني" value="{{old('email')}}"
                               @error('email') is-invalid @enderror">
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

{{--                    <input type="hidden" name="ip" class="ip-user" id="ip">--}}
                    <input style="display: none" type="checkbox" checked name="remember">
                    <button class="btn btn-primary w-100 mt-3 py-3" type="submit">تسجيل حساب جديد</button>
                </form>
            </div>
        </div>
    </div>
@endsection
{{--@section("page_js")--}}
{{--    <script>--}}
{{--        fetch("https://api.ipify.org/?format=json").then(result => result.json()).then(data => document.getElementById("ip").value = data.ip)--}}
{{--    </script>--}}
{{--@endsection--}}
