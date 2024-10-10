@extends('dashboard.layouts.layout')
@section('css')

@endsection
@section('content-dashboard')

            <div class="d-flex mt-5">
                <h4 class="content-title mb-0 my-auto">Manage</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Instructors<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Create</span>
            </div>
            <div class="page-details mt-3 bg-white main-shadow p-4">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('success')}}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('error')}}
                    </div>
                @endif

                
                <form action="{{ route('instructors.store') }}" method="POST" id="loginForm">
                    @csrf
                    <span class="invalid-feedback d-block" role="alert">
                        <strong id="invalid-email"></strong>
                    </span>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong id="invalid-password"></strong>
                    </span>
                    <div class="form-group">
                        <label for="firstname">First Name <span class="text-danger">*</span></label>
                        <input id="firstname" name="firstname" type="text" placeholder="Enter First Name" value="{{ old('firstname') }}" class="@error('firstname') is-invalid @enderror form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name <span class="text-danger">*</span></label>
                        <input id="lastname" name="lastname" type="text" placeholder="Enter First Name" value="{{ old('lastname') }}" class="@error('lastname') is-invalid @enderror form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input id="email" name="email" type="email" placeholder="Enter Email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input id="password" name="password" type="text" placeholder="Enter password..." class="@error('password') is-invalid @enderror form-control" required/>
                    </div>
                    <div class="mt-10"></div>
                
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Create Now</button>
                    </div>
                </form>
            </div>
@endsection

@section('js')
@endsection
