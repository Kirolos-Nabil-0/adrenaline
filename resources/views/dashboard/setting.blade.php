@extends('dashboard.layouts.layout')



@section('content-dashboard')

    <div class="main-page-title bg-white fw-bold main-shadow p-4"><img
            src="{{asset('images/SVG/view-apps.svg')}}"
            width="18" height="20" alt=""> Settings
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    <div class="page-details mt-3">
        <form action="{{route('update-info')}}" method="post" class="bg-white p-4 main-shadow">
            @csrf
            <h6 class="mb-3">المعلومات الاساسية</h6>
            <div class="form-group mb-3 position-relative">
                <input type="text" class="form-control py-2" value="{{$user->firstname}}" name="firstname"
                        id="name"
                        placeholder="الاسم الاول">
                @error('firstname')
                <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group mb-3 position-relative">
                <input type="text" class="form-control py-2" value="{{$user->lastname}}" id="name2"
                        name="lastname"
                        placeholder="الاسم الاوسط والاخير">
                @error('lastname')
                <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group mb-3 position-relative">
                <input type="email" class="form-control py-2" value="{{$user->email}}" id="email" name="email"
                        placeholder="البريد الالكتروني">
                @error('email')
                <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group mb-3 position-relative">
                <input type="text" class="form-control py-2" value="{{$user->title}}" id="title" name="title"
                        placeholder="المسمى الوظيفي">
                @error('email')
                <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>


            <div class="form-group mb-3 position-relative">
                <input type="password" class="form-control py-2" name="password" id="password2"
                        placeholder="كلمة السر الجديده">
                @error('password')
                <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group position-relative">
                <input type="password" class="form-control py-2" name="password_confirmation" id="repassword"
                        placeholder="تأكيد كلمة السر">
            </div>
            <button class="btn btn-primary w-100 mt-3" type="submit">حفظ التغييرات</button>
        </form>
    </div>
@endsection
