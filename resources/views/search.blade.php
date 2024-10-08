@extends('layouts.layout')
@section('content')
    @include('layouts.navbar')
    <section class="breadcrumb__area include-bg pt-250 pb-150 breadcrumb__overlay">
        <div class="shadow w-100 position-absolute h-100 start-0 top-0 bg-light"></div>
        <div class="container">
           <div class="row">
              <div class="col-xxl-12">
                 <div class="breadcrumb__content p-relative z-index-1">
                    <h4 class="breadcrumb__title mb-20">Your Search Result about: {{ $searchQuery }}</h4>
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
                    <h2 class="tp-section-title mb-20">Explore Popular Courses</h2>
                 </div>
              </div>
           </div>
           <div class="row justify-content-center">
            @foreach($data as $key => $item)
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

            @endforeach
           </div>

        </div>
     </section>
@endsection
@section("page_js")
   <script>
        console.log(window.location)
    </script>
@endsection
