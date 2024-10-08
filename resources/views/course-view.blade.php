@extends('layouts.layout')
@section('page_css')
    <style>
        .search-form i {
            left: 15px;
            top: 11px;
        }
    </style>
@endsection
@section('content')
    @include('layouts.navbar')
    {{-- <div class="course-information py-5">
        <div class="container">
            <div class="d-flex flex-column text-start">
                <h1 class="font-family text-light">{{$course->name}}</h1>
                <p class="text-light font-family" dir="ltr">{{$users_count}} Students enrolled</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row course-main">
            <div class="col-lg-5 course-box-info py-5">
                <div class="card py-2" style="width: 300px;">
                    <div class="card-body">
                        <h1 class="card-title font-family fw-bold mb-4 text-success text-end" dir="ltr">
                            @if ($course->free)
                                <p>مجاني</p>
                            @else
                                {{$course ->price}} EGP
                            @endif
                        </h1>
                        <hr>
                        <p class="mt-3">يتضمن:</p>
                        <ul class="list-unstyled p-0">
                            <li>
                                <i class="far fa-file text-success"></i>
                                <span class="font-family">{{$lessons_count}}</span> حصة
                            </li>
                            <li>
                                <i class="far fa-compass text-danger"></i>
                                تحكم كامل اثناء المحاضرات
                            </li>
                            <li>
                                <i class="far fa-user text-primary"></i>
                                عضو <span class="font-family">{{$users_count}}</span> يوجد
                            </li>
                        </ul>

                        @if (!$access)

                            <a href="https://wa.me/+201024579388" target="_blank" class="">
                                <button class="btn btn-success mt-1 w-100 rounded-0">تواصل معنا لفتح الكورس <i
                                        class="fa fa-whatsapp"></i></button>
                            </a>
                        @else
                            <a href="{{route('course-page' , $course->id)}}" class="">
                                <button class="btn btn-danger w-100 rounded-0">الذهاب الي الكورس</button>
                            </a>
                        @endif


                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="container">
                                       <div class="what-you-get-box"> --}}
    {{--                        <div class="what-you-get-title">ماذا سأتعلم؟</div> --}}
    {{--                    </div> --}}


    {{--                    @foreach ($sections as $section) --}}
    {{--                        <hr> --}}
    {{--                        <li class="text-decoration-none text-light p-2"> --}}
    {{--                            Section1: {{$section ->section_name}} --}}
    {{--                            <ul class="mt-3"> --}}
    {{--                                @foreach ($section->lesson as $lesson) --}}
    {{--                                    <li data-name="{{$lesson->lesson_name}}" data-section="{{$section ->section_name}}" --}}
    {{--                                        data-url="{{$lesson->url}}">{{$lesson->lesson_name}}</li> --}}
    {{--                                @endforeach --}}
    {{--                            </ul> --}}
    {{--                        </li> --}}
    {{--                        <hr> --}}
    {{--                    @endforeach


                    @foreach ($sections as $section)
                        <div class="section-course-box">
                            <div class="what-you-get-box">
                                <div class="what-you-get-title font-family" dir="ltr"><i class="fas fa-screencast"></i>
                                    {{$section->section_name}}
                                </div>
                            </div>

                            <ul class="p-0 mt-3">
                                @foreach ($section->lesson as $lesson)
                                    <li class="lecture mt-2 has-preview d-flex justify-content-between"
                                        style="padding-left: 20px;">
                                <span class="lecture-time font-family" dir="ltr">{{$lesson->duration}} <i
                                        class="fa fa-clock"></i></span>
                                        <span class="lecture-title font-family" dir="ltr"><i
                                                class="fa fa-graduation-cap"></i> {{$lesson->lesson_name}}</span>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/tTcWeU_moy4"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div> --}}


    <section class="breadcrumb__area include-bg pt-250 pb-150 breadcrumb__overlay" data-background="{{ $course->image }}">
        <div class="shadow w-100 position-absolute h-100 start-0 top-0 bg-light"></div>
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title mb-20">{{ $course->name }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- course-details-area -->
    <section class="c-details-area pt-120 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="c-details-wrapper mr-25">
                        <div class="c-details-thumb p-relative mb-40">
                            <img src="{{ $course->image }}" alt="details-bg">
                        </div>
                        <div class="course-details-content mb-45">
                            <div class="tpcourse__ava-title mb-25">
                                <h4 class="c-details-title"><a href="#">{{ $course->name }}</a></h4>
                            </div>
                            <div class="tpcourse__meta course-details-list">
                                <ul class="d-flex align-items-center">
                                    <li>
                                        <div class="rating-gold d-flex align-items-center">
                                            <p>{{ $course->rate }}</p>
                                            <i class="fi fi-ss-star"></i>
                                        </div>
                                    </li>
                                    <li><img src="{{ asset('images/icon/c-meta-01.png') }}" alt="meta-icon">
                                        <span>{{ $lessons_count }} Classes</span></li>
                                    <li><img src="{{ asset('images/icon/c-meta-02.png') }}" alt="meta-icon">
                                        <span>{{ $users_count }} Students</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="c-details-about mb-40">
                            <h5 class="tp-c-details-title mb-20">About This Course</h5>
                            <p>{{ $course->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="c-details-sidebar">
                        <div class="course-details-widget">
                            <div class="cd-video-price">
                                <h3 class="pricing-video text-center mb-15">
                                    @if ($course->free)
                                        <p>مجاني</p>
                                    @else
                                        {{ $course->price }} EGP
                                    @endif
                                </h3>
                            </div>

                            <div class="cd-information mb-35">
                                <ul>
                                    <li><i class="fa-light fa-calendars"></i> <label>Lesson</label>
                                        <span>{{ $lessons_count }}</span></li>
                                    <li><i class="fi fi-rr-user"></i> <label>Students</label>
                                        <span>{{ $users_count }}</span></li>
                                    <li><i class="fi fi-rr-comments"></i> <label>Language</label> <span>Arabic</span></li>
                                </ul>
                            </div>
                            <div class="cd-pricing-btn text-center mb-30">
                            
                                @if (!$access)
                                    <a class="tp-vp-btn-green bg-success" target="_blank"
                                        href="https://wa.me/{{ $settings->phone_number }}"><i class="fa fa-whatsapp fs-5"></i> Contact us to
                                        open the course</a>
                                @else
                                    <a class="tp-vp-btn-green" href="{{ route('course-page', $course->id) }}">Go to
                                        course</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- course-details-area-end -->
@endsection
