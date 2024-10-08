{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item"><span><i class="fa fa-graduation-cap"></i></span><a class="nav-link active d-inline-block" aria-current="page"
                                        href="{{route('home')}}">الكورسات</a>
                </li>
                <li class="nav-item"><span><i class="fa fa-dashboard"></i></span><a class="nav-link active d-inline-block" aria-current="page"
                                        href="{{route('home')}}?myCourses=true">كورساتي
                        الخاصة</a></li>
            </ul>
        </div>
        <!-- If user is admin -->
    @dashboard
            <a class="navbar-brand" href="{{route('admin.dashboard')}}">
                <button class="btn btn-success rounded-0">لوحة التحكم</button>
            </a>
    @enddashboard

    <!-- If user is admin -->
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{asset('images/1.png')}}" height="25" width="100" alt="">
        </a>
        <div class="User-area me-2">
            <div class="User-avtar">
                <img src="{{asset(auth()->user()->profile_photo_path??'images/user.jpg')}}" width="200" class="border"/>

            </div>
            <ul class="User-Dropdown">
                <li><a href="{{route('settings')}}">الإعدادات</a></li>
                <li><a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">الخروج</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </ul>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav> --}}
   <!-- header area start -->
   <header class="header_white_area d-none d-xl-block header__transparent">
    <div class="header__area pt-40 pb-5">
       <div class="main-header" id="header-sticky">
          <div class="container">
             <div class="row align-items-center justify-content-between">
                <div class="col-xxl-7 col-xl-6 col-lg-6 col-md-5 col-6">
                   <div class="logo-area d-flex align-items-center">
                      <div class="logo">
                         <a href="{{route('home')}}">
                            <img src="{{asset('images/1.png')}}" alt="logo">
                         </a>
                      </div>
                      @dashboard
                      <div class="header-cat-menu ml-40">
                         <nav>
                            <ul>
                               <li><a href="{{route('admin.dashboard')}}"> Dashboard</a></li>
                            </ul>
                         </nav>
                      </div>
                      @enddashboard
                   </div>
                </div>
                <div class="col-xxl-5 col-lg-6 col-md-7">
                   <div class="header-right header-right-box">
                      <div class="header-search-box">
                        {{-- <form action="{{route('home')}}" method="get" class="mt-5 position-relative ms-auto search-form">

                           <button type="submit" class="position-absolute text-dark"
                                   style="background: transparent !important; border: 0 ; left: 5px ; top: 5px"><i
                                   class="fa fa-search"></i></button>
                           <input type="text" name="search" value="{{request('search')}}" placeholder="عايز تبحث عن اي كورس ؟" class="form-control">
                       </form> --}}
                         <form action="{{route('search')}}" method="get">
                            <div class="search-input">
                               <input type="text" name="search" placeholder="What you want to learn?" value="{{request('search')}}">
                               <button class="header-search-btn" type="submit"><i class="fi fi-rs-search mr-5"></i> Search Now</button>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
             <div class="row">
                <div class="col-xxl-9 col-xl-9 col-lg-6 text-start">
                   <div class="main-menu main-menu-white">
                      <nav id="mobile-menu">
                         <ul>
                            <li>
                               <a href="{{route('home')}}">Home</a>
                            </li>
                            <!-- <li class="has-dropdown">
                               <a href="#">Pages</a>
                               <ul class="submenu">
                                  <li><a href="#">About</a></li>
                                  <li><a href="#">Contact</a></li>
                                  <li><a href="#">FAQ</a></li>
                               </ul>
                            </li> -->
                            <li class="has-dropdown">
                               <a href="#">Course</a>
                               <ul class="submenu">
                                  <li><a href="{{route('courses')}}">Courses</a></li>
                                  <li><a href="{{route('own-courses')}}">My Courses</a></li>
                               </ul>
                            </li>
                         </ul>
                      </nav>
                   </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-6 d-flex align-items-center justify-content-end">
                   <div class="header-meta-green">
                      <ul>
                        <li><a href="{{route('settings')}}"><i class="fi fi-rr-user"></i></a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img src="https://cdn-icons-png.flaticon.com/512/1828/1828427.png" width="20" alt=""></a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                        </form>
                        <li><a href="#" class="tp-menu-toggle d-xl-none"><i class="icon_ul"></i></a></li>
                      </ul>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </header>

 <div class="mobile-header-area d-xl-none">
    <div class="container">
       <div class="row align-items-center">
          <div class="col-md-6 col-5">
             <div class="logo">
                <a href="{{route('home')}}">
                   <img src="{{asset('images/1.png')}}" alt="logo">
                </a>
             </div>
          </div>
          <div class="col-md-6 col-7 d-flex align-items-center justify-content-end">
             <div class="header-meta-green text-end">
                <ul>
                   <li><a href="{{route('settings')}}"><i class="fi fi-rr-user"></i></a></li>
                   <li><a href="#" class="tp-menu-toggle d-xl-none"><i class="icon_ul"></i></a></li>
                </ul>
             </div>
          </div>
       </div>
    </div>
 </div>

 <!-- header area end -->
 <div class="tp-sidebar-menu">
    <button class="sidebar-close"><i class="icon_close"></i></button>
    <div class="side-logo mb-30">
       <a href="{{route('home')}}"><img src="{{asset('images/1.png')}}" alt="logo"></a>
    </div>
    <div class="mobile-menu"></div>
    {{--<div class="sidebar-info">
       <h4 class="mb-15">Contact Info</h4>
       <ul class="side_circle">
          <li><a href="tel:{{ $settings->phone_number }}">{{ $settings->phone_number }}</a></li>
          <li><a href="mailto:adrenaline.platform.edu@gmail.com">Adrenaline.Platform.Edu@gmail.com</a></li>
       </ul> 
    </div>
    --}}
 </div>
 <div class="body-overlay"></div>