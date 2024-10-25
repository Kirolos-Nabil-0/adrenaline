@extends('dashboard.layouts.layout')
@section('css')

@endsection
@section('content-dashboard')

            <div class="d-flex mt-5 justify-content-between">
                <h4 class="content-title mb-0 my-auto">Manage <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Centers / <a href="{{route("centers.show", $center)}}">{{$center->firstname}}</a> / Edit</span></h4>
                <a href="{{route('centers')}}" class="btn btn-primary">All Centers</a>
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

                
                <form action="{{ route('centers.update', $center) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="package_id">Center Package <span class="text-muted">(Optional)</span></label>
                            <select id="package_id" name="package_id" type="package_id" class="@error('package_id') is-invalid @enderror form-control">
                                <option selected disabled>Select a package</option>
                                @foreach ($packages as $package)
                                    <option value="{{$package->id}}" {{$center->currentPackage() ? ($center->currentPackage()->id == $package->id ? 'selected' : '') : ''}}>{{$package->name}} ({{$package->price}})</option>
                                @endforeach
                            </select>
                            @error('package_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-10"></div>
                
                    <div class="col-md-6 form-group">
                        <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure you want to change the plan of the center?')">Update Now</button>
                    </div>
                </form>
            </div>
@endsection

@section('js')
@endsection
