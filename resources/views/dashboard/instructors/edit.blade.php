@extends('dashboard.layouts.layout')
@section('css')

@endsection
@section('content-dashboard')

            <div class="d-flex mt-5">
                <h4 class="content-title mb-0 my-auto">Manage <span class="text-muted mt-1 tx-13 mr-2 mb-0"> / Instructors / <a href="{{route('instructors.show', $instructor)}}">{{$instructor->firstname}}</a> / Edit</span></h4>
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

                
                @admin
                <form action="{{ route('instructors.update', $instructor) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                            <div class="col-md-12 form-group">
                                <label for="package_id">Instructor Package <span class="text-muted">(Optional)</span></label>
                                <select id="package_id" name="package_id" type="package_id" class="@error('package_id') is-invalid @enderror form-control">
                                    <option selected disabled>Select a package</option>
                                    @foreach ($packages as $package)
                                        <option value="{{$package->id}}" {{$instructor->currentPackage() ? ($instructor->currentPackage()->id == $package->id ? 'selected' : '') : ''}}>{{$package->name}} ({{$package->price}})</option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update Now</button>
                        </div>
                    </form>
                @endadmin
            </div>
@endsection

@section('js')
@endsection
