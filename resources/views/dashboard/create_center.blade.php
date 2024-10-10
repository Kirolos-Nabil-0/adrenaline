@extends('dashboard.layouts.layout')
@section('css')

@endsection
@section('content-dashboard')

            <div class="d-flex mt-5">
                <h4 class="content-title mb-0 my-auto">Manage</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Centers<span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Create</span>
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

                
                <form action="{{ route('centers.store') }}" method="POST" id="loginForm">
                    @csrf
                    <span class="invalid-feedback d-block" role="alert">
                        <strong id="invalid-email"></strong>
                    </span>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong id="invalid-password"></strong>
                    </span>
                    <div class="form-group">
                        <label for="name">Center Name <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" placeholder="Enter First Name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror form-control" required/>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Center Email <span class="text-danger">*</span></label>
                        <input id="email" name="email" type="email" placeholder="Enter Email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror form-control" required/>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input id="password" name="password" type="text" placeholder="Enter password..." class="@error('password') is-invalid @enderror form-control" required/>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
