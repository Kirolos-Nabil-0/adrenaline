<?php
$currentUser = auth()->user();
?>

{{-- <div class="side">
    <div class="side-bar rounded px-2">
        <div class="logo"><img src="{{asset('images/اللوجو (2).png')}}" alt=""></div>
        <div class="user-admin text-center mt-3 mb-3">
            <div class="bg-dark rounded-circle d-inline-block"><img style="width:40px;height:40px;border-radius:50%" src="{{asset($currentUser->profile_photo_path??'images/1.png')}}" alt=""></div>
            <p class="fw-bold mt-2 text-dark">{{$currentUser->firstname}} {{$currentUser->lastname}}</p>
        </div>
        <ul>
            <a href="{{route('admin.dashboard')}}">
                <li><img src="{{asset('images/SVG/view-apps.svg')}}" width="12" height="20" alt="">
                    <span>Dashboard</span>
                </li>
            </a>
            <li class="direct"><img src="{{asset('images/SVG/archive.svg')}}" width="12" height="20" alt="">
                <span>Manage Courses</span>
                <p class="chevron"><i class="fa fa-chevron-down"></i></p>
                <ul>
                    <a href="{{route('courses-page')}}">
                        <li>Manage Courses</li>
                    </a>
                    <a href="{{route('add-course')}}">
                        <li>Add new course</li>
                    </a>
                </ul>
            </li> 
            
           <a href="{{route('instructorModules')}}">
                <li><i class="fa fa-users"></i>
                    <span>Manage Module</span>
                </li>
            </a> 
            
            @admin
            <li class="direct"><img src="{{asset('images/SVG/network-3.svg')}}" width="12" height="20" alt="">
                <span>Enrollment</span>
                <p class="chevron"><i class="fa fa-chevron-down"></i></p>
                <ul>
                    <a href="{{route('enrollment-history')}}">
                        <li>Enrollment history</li>
                    </a>
                    <a href="{{route('add-student')}}">
                        <li>Enroll a student</li>
                    </a>
                </ul>
            </li>
            <a href="{{route('settings')}}">
                <li><img src="{{asset('images/SVG/user.svg')}}" width="12" height="20" alt=""> <span>Settings</span>
                </li>
            </a>
            <a href="{{route('instructors')}}">
                <li><i class="fa fa-users"></i>
                    <span>Instuctors</span>
                </li>
            </a>
            <li class="direct"><i class="fa fa-list"></i>
                <span>Modules</span>
                <p class="chevron"><i class="fa fa-chevron-down"></i></p>
                <ul>
                    <a href="{{route('module.index')}}">
                        <li>Manage Modules</li>
                    </a>
                    <a href="{{route('module.create')}}">
                        <li>Add new module</li>
                    </a>
                </ul>
            </li>
            @endadmin

        </ul>
    </div>
    <div class="shadow"></div>
</div> --}}

<!-- main-sidebar -->
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('/admin') }}"><img
                src="{{ asset($currentUser->profile_photo_path ?? 'images/1.png') }}" class="main-logo rounded-circle"
                alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ url('/admin') }}"><img
                src="{{ asset($currentUser->profile_photo_path ?? 'images/1.png') }}"
                class="main-logo rounded-circle dark-theme" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ url('/admin') }}"><img
                src="{{ asset($currentUser->profile_photo_path ?? 'images/1.png') }}" class="logo-icon rounded-circle"
                alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ url('/admin') }}"><img
                src="{{ asset($currentUser->profile_photo_path ?? 'images/1.png') }}"
                class="logo-icon dark-theme rounded-circle" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround"
                        src="{{ asset($currentUser->profile_photo_path ?? 'images/1.png') }}"><span
                        class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ $currentUser->firstname ?? '' }}
                        {{ $currentUser->lastname }}</h4>
                    <span class="mb-0 text-muted text-uppercase">{{ $currentUser->role }}</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category">Main</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.dashboard') }}"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                        <path
                            d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                    </svg><span class="side-menu__label">Index</span></a>
            </li>

            <!-- <li class="slide">
                <a class="side-menu__item" href="{{ route('instructorModules') }}"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm3.5 4c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zm-7 0c.83 0 1.5.67 1.5 1.5S9.33 11 8.5 11 7 10.33 7 9.5 7.67 8 8.5 8zm3.5 9.5c-2.33 0-4.32-1.45-5.12-3.5h1.67c.7 1.19 1.97 2 3.45 2s2.76-.81 3.45-2h1.67c-.8 2.05-2.79 3.5-5.12 3.5z"
                            opacity=".3" />
                        <circle cx="15.5" cy="9.5" r="1.5" />
                        <circle cx="8.5" cy="9.5" r="1.5" />
                        <path
                            d="M12 16c-1.48 0-2.75-.81-3.45-2H6.88c.8 2.05 2.79 3.5 5.12 3.5s4.32-1.45 5.12-3.5h-1.67c-.69 1.19-1.97 2-3.45 2zm-.01-14C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
                    </svg><span class="side-menu__label">Manage Module</span><span
                        class="badge badge-danger side-badge">New</span></a>

            </li> -->
            <li class="side-item side-item-category">General</li>

            @admin
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
                        <path
                            d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                    </svg><span class="side-menu__label">Manage</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ route('university') }}">Manage University</a></li>
                        <li><a class="slide-item" href="{{ route('college') }}">Manage college</a></li>
                        <li><a class="slide-item" href="{{ route('collegeyear') }}">Manage college Year</a></li>
                        {{-- <li><a class="slide-item" href="{{ route('semester') }}">Manage Semester</a></li> --}}
                    </ul>
                </li>
                @endadmin



            {{-- ------------------------------------------ --}}
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
                        <path
                            d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                    </svg><span class="side-menu__label">Manage Courses</span><i
                        class="angle fe fe-chevron-down"></i></a>
                <ul class="slide-menu">

                    <li><a class="slide-item" href="{{ route('add-course') }}">Add New Course</a></li>
                    <li><a class="slide-item" href="{{ route('courses-page') }}">Manage Courses</a></li>

                    @centeradmin
                        <li><a class="slide-item" href="{{ route('course_codes') }}">Manage Courses Codes</a></li>
                    @endcenteradmin
                    @admin
                        <li><a class="slide-item" href="{{ route('banners') }}">Manage Banners</a></li>
                        <li><a class="slide-item" href="{{ route('reviewCoureses') }}">Manage Rating</a></li>
                        <li><a class="slide-item" href="{{ route('setting_web') }}"> Manage Pages
                            </a></li>
                    @endadmin




                </ul>
            </li>
                <!-- <li class="side-item side-item-category">General</li>
                                    <li class="slide">
                                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
                                                <path
                                                    d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                                            </svg><span class="side-menu__label">Manage Enroll</span><i
                                                class="angle fe fe-chevron-down"></i></a>
                                        <ul class="slide-menu">
                                            <li><a class="slide-item" href="{{ route('add-student') }}">Enroll Student</a></li>
                                            <li><a class="slide-item" href="{{ route('enrollment-history') }}">Enrollment History</a></li>
                                        </ul>
                                    </li> -->

                @centeradmin
                <li class="side-item side-item-category">User Management</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="side-menu__icon"
                            viewBox="0 0 24 24"
                            fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.33 0-10 1.67-10 5v2h20v-2c0-3.33-6.67-5-10-5zm-2 3h4l1-4h-6l1 4zm1-10v2h2v-2h-2z"/>
                        </svg>
                        <span class="side-menu__label">Instructors</span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ route('instructors') }}">All Instructors</a></li>
                        <li><a class="slide-item" href="{{ route('instructors.create') }}">Add new Instructor</a></li>
                    </ul>
                </li>
                @endcenteradmin
                @admin
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="side-menu__icon"
                                viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M3 21h18V9H3v12zm2-10h4v4H5v-4zm0 5h4v2H5v-2zm5-5h4v4h-4v-4zm0 5h4v2h-4v-2zm5-10h4v10h-4V6zm0 11h4v2h-4v-2zM5 6h4v2H5V6zm0 11h4v2H5v-2zm-2-15h18c1.1 0 2 .9 2 2v18H1V4c0-1.1.9-2 2-2z"/>
                            </svg>

                            <span class="side-menu__label">Centers</span><i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('centers') }}">All Centers</a></li>
                            <li><a class="slide-item" href="{{ route('centers.create') }}">Add new Center</a></li>
                        </ul>
                    </li>
                @endadmin
                <!-- <li class="side-item side-item-category">General</li> -->
                <!-- <li class="slide">
                                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
                                                <path
                                                    d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                                            </svg><span class="side-menu__label">Manage Modules</span><i
                                                class="angle fe fe-chevron-down"></i></a>
                                        <ul class="slide-menu">
                                            <li><a class="slide-item" href="{{ route('module.index') }}">Manage Modules</a></li>
                                            <li><a class="slide-item" href="{{ route('module.create') }}">Add New Module</a></li>
                                        </ul>
                                    </li> -->
        </ul>
    </div>
</aside>
<!-- main-sidebar -->
