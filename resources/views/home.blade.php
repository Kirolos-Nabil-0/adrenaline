@extends('layouts.layout')
@section('page_css')
    <style>
        .search-form i {
            left: 15px;
            top: 11px;
        }
        .img-custom {
            width: 200px;
            object-fit: cover;
            height: 400px;            
            border-radius: 15px; /* Equivalent to rounded-xl */
            transition: transform .3s ease; /* Adjust transition duration as needed */
         }
         .img-custom:hover {
            transform: translateY(-8px); /* Adjust based on the hover effect you want */
         }
         .platform-icon:hover {
            transform: translateX(2px); /* Adjust based on the hover effect you want */
         }
         .platform-icon{
            width: 200px;
            height: 85px;
         }
         .img-custom:nth-of-type(2):hover {
            transform: translateY(-1px); /* Specific hover effect for the second image */
         }
    </style>
@endsection
@section('content')
    @include('layouts.navbar')
    @include('layouts.banner')
    {{-- <div class="container mt-5">
        <h3>{{$title}}</h3>
        <div class="row">
            @foreach($data as $item)
                <div class="col-lg-3 my-3">
                    <div class="card course-item-card m-auto" style="width: 230px;">
                        <a href="{{url('course-view/'.$item->id)}}" class="text-decoration-none text-dark">
                            <img src="{{$item->image}}" class="card-img-top course-img"
                                 alt="...">
                            <div class="card-body py-3 border-top">
                                <h5 class="card-title font-family text-start mb-3" dir="ltr">{{$item ->name}}</h5>
                                <p class="font-family text-start mb-2"
                                   dir="ltr">{{\Str::words($item -> description , 15)}}</p>
                                <div class="d-flex justify-content-between mt-4">
                                    <p class="font-family text-end m-0 text-success" dir="ltr">
                                        <span class="fw-bold">
                                        @if($item ->free == true )
                                                <span>مجاني</span>
                                            @else
                                                {{$item ->price}} EGP
                                            @endif
                                        </span>
                                    </p>
                                    <span class="text-end font-family text-danger" dir="ltr"><i
                                            class="fa fa-graduation-cap"
                                            aria-hidden="true"></i>{{$item->users_count}}</span>

                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div> --}}
    <section class="course-area pt-115 pb-110">
        <div class="container">
           <div class="row">
              <div class="col-md-12">
                 <div class="section-title mb-65">
                    <h2 class="tp-section-title mb-20">Explore Popular Courses</h2>
                 </div>
              </div>
           </div>
           <div class="row justify-content-center">
            @foreach($data as $key => $item)
            @if($key < 6)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="tpcourse mb-40">
                   <div class="tpcourse__thumb p-relative w-img fix">
                      <a href="{{url('course-view/'.$item->id)}}"><img src="{{$item->image}}" alt="course-thumb"></a>
                   </div>
                   <div class="tpcourse__content">
                      <div class="tpcourse__avatar d-flex align-items-center mb-20">
                         <h4 class="tpcourse__title"><a href="{{url('course-view/'.$item->id)}}">{{$item->name}}</a></h4>
                      </div>
                      <div class="tpcourse__meta pb-15 mb-20">
                         <ul class="d-flex align-items-center">
                            {{-- <li><img src="{{asset('images/icon/c-meta-01.png')}}" alt="meta-icon"> <span>{{$item->name}} Classes</span></li> --}}
                            <li><img src="{{asset('images/icon/c-meta-02.png')}}" alt="meta-icon"> <span>{{$item->users_count}} Students</span></li>
                            <li><img src="{{asset('images/icon/c-meta-03.png')}}" alt="meta-icon"> <span>{{$item->rate}}</span></li>
                         </ul>
                      </div>
                      <div class="tpcourse__category d-flex align-items-center justify-content-between">
                         <h5 class="tpcourse__course-price">
                            @if($item ->free == true )
                            <span>مجاني</span>
                        @else
                            {{$item ->price}} EGP
                        @endif
                         </h5>
                      </div>
                   </div>
                </div>
             </div>
            @else
               @break
            @endif
            @endforeach
           </div>
           <div class="row text-center">
              <div class="col-lg-12">
                 <div class="course-btn mt-20"><a class="tp-btn" href="{{route('courses')}}">Browse All Courses</a></div>
              </div>
           </div>
        </div>
     </section>
     <section class="bg-primary gap-3 pt-4 px-4 px-md-5">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <div class="d-flex justify-content-center gap-3 overflow-hidden">
                     <img src="{{ asset('images/app/1.webp') }}" class="d-none d-md-block img-custom">
                     <img src="{{ asset('images/app/2.webp') }}" class="img-custom">
                     <img src="{{ asset('images/app/3.webp') }}" class="d-none d-md-block img-custom">
                  </div>
               </div>
               <div class="col-lg-6 mt-lg-0 mt-40 mb-lg-0 mb-40">
                  <div class="text-center order-1 order-md-2">
                     <h1 class="text-white fs-2 fs-md-4xl fw-medium lh-1">You can download our app</h1>
                     <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <a href="https://apps.apple.com/us/app/adrenaline-platform/id6526502535" class="rounded-3 hover:translate-y-1 transition">
                        <img src="{{ asset('images/icon/apple store.png') }}" class="platform-icon" style="object-fit: cover;" alt="Placeholder">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.adrinaline.adrinaline" class="rounded-3 hover:translate-y-1 transition">
                        <img src="{{ asset('images/icon/google play.png') }}" class="platform-icon" style="object-fit: cover;" alt="Placeholder">
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
     <section class="tp-counter-area bg-bottom grey-bg pt-120 pb-60" data-background="assets/img/bg/shape-bg-1.png" style="background-image: url(&quot;assets/img/bg/shape-bg-1.png&quot;);">
        <div class="container">
           <div class="row">
              <div class="col-xl-3 col-md-6">
                 <div class="counter-item mb-60 text-center">
                    <div class="counter-item__icon mb-25">
                       <i class="fi fi-rr-user"></i>
                    </div>
                    <div class="counter-item__content">
                       <h4 class="counter-item__title"><span class="counter">102</span>K</h4>
                       <p>Worldwide Students</p>
                    </div>
                 </div>
              </div>
              <div class="col-xl-3 col-md-6">
                 <div class="counter-item mb-60 text-center">
                    <div class="counter-item__icon mb-25">
                       <i class="fi fi-rr-document"></i>
                    </div>
                    <div class="counter-item__content">
                       <h4 class="counter-item__title"><span class="counter">8</span>+</h4>
                       <p>Years Experience</p>
                    </div>
                 </div>
              </div>
              <div class="col-xl-3 col-md-6">
                 <div class="counter-item mb-60 text-center">
                    <div class="counter-item__icon mb-25">
                       <i class="fi fi-rr-apps"></i>
                    </div>
                    <div class="counter-item__content">
                       <h4 class="counter-item__title"><span class="counter">271</span>+</h4>
                       <p>Professional Courses</p>
                    </div>
                 </div>
              </div>
              <div class="col-xl-3 col-md-6">
                 <div class="counter-item mb-60 text-center">
                    <div class="counter-item__icon mb-25">
                       <i class="fi fi-rr-star"></i>
                    </div>
                    <div class="counter-item__content">
                       <h4 class="counter-item__title"><span class="counter">1.7</span>K+</h4>
                       <p>Beautiful Review</p>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section>

     <section class="course-area pt-115 pb-110">
        <div class="container">
           <div class="row">
              <div class="col-md-12">
                 <div class="section-title mb-65">
                    <h2 class="tp-section-title mb-20">Latest Courses</h2>
                 </div>
              </div>
           </div>
           <div class="row justify-content-center">
            @foreach($data as $key => $item)
            @if($key < 3)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="tpcourse mb-40">
                   <div class="tpcourse__thumb p-relative w-img fix">
                      <a href="{{url('course-view/'.$item->id)}}"><img src="{{$item->image}}" alt="course-thumb"></a>
                   </div>
                   <div class="tpcourse__content">
                      <div class="tpcourse__avatar d-flex align-items-center mb-20">
                         <h4 class="tpcourse__title"><a href="{{url('course-view/'.$item->id)}}">{{$item->name}}</a></h4>
                      </div>
                      <div class="tpcourse__meta pb-15 mb-20">
                         <ul class="d-flex align-items-center">
                            {{-- <li><img src="{{asset('images/icon/c-meta-01.png')}}" alt="meta-icon"> <span>{{$item->name}} Classes</span></li> --}}
                            <li><img src="{{asset('images/icon/c-meta-02.png')}}" alt="meta-icon"> <span>{{$item->users_count}} Students</span></li>
                            <li><img src="{{asset('images/icon/c-meta-03.png')}}" alt="meta-icon"> <span>{{$item->rate}}</span></li>
                         </ul>
                      </div>
                      <div class="tpcourse__category d-flex align-items-center justify-content-between">
                         <h5 class="tpcourse__course-price">
                            @if($item ->free == true )
                                <span>مجاني</span>
                            @else
                                {{$item ->price}} EGP
                            @endif
                         </h5>
                      </div>
                   </div>
                </div>
             </div>
            @else
               @break
            @endif
            @endforeach
           </div>
        </div>
     </section>
     
@endsection

