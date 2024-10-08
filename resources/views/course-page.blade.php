@extends('layouts.layout')
@section('variables')
    <?php
    $dir = "ltr";
    ?>
@endsection
@section('page_css')
    <style>

        body{
            overflow-x:hidden 
        }

        .video-section video {
            width: 100%;
        }

        .ms-auto {
            margin-right: auto !important;
            margin-left: unset !important;

        }

        .video-section {
            position: relative;
        }

        p#name {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999;
            -webkit-text-stroke: 0.8px #fff !important;
            font-size: 40px;
            font-weight: 900;
            opacity: 0.5;
            height: 60px;
        }
        .hidden-logo {
            position: absolute;
            bottom: -22px;
            background: #000;
            transform: translate(-50%, -50%);
            z-index: 999;
            -webkit-text-stroke: 0.8px #fff !important;
            font-size: 5px;
            font-weight: 900;
            opacity: 1;
            height: 38px;
            width: 27px;
            overflow: hidden;
            right: 7px;
            width: 91px;
        }
        .hidden-logo {
            position: absolute;
            bottom: -18px;
            background: #000;
            transform: translate(-50%, -50%);
            z-index: 999;
            -webkit-text-stroke: 0.8px #fff !important;
            font-size: 5px;
            font-weight: 900;
            opacity: 1;
            height: 30px;
            overflow: hidden;
            right: 12px;
            width: 83px;
            color: #000 !important;
        }
        .hidden-title {
            position: absolute;
            top: 0;
            background: #000;
            z-index: 999;
            -webkit-text-stroke: 0.8px #fff !important;
            font-size: 5px;
            font-weight: 900;
            opacity: 1;
            height: 70px;
            overflow: hidden;
            right: 0;
            width: 100%;
            color: #000 !important;
        }
        .close-slide{
            cursor: pointer;
        }
        iframe{
            width: 100% !important;
            height: 100vh !important;
        }
        @media(max-width:767px){
            iframe{
            height: 500px !important;
        }
        }
    </style>
@endsection
@section('content')
    {{-- @include('layouts.navbar') --}}
    <div class="w-100">
        <div class="row" id="userTitle" data-email="{{\Illuminate\Support\Facades\Auth::user()->email}}">
            <div class="video-section col-lg-8 p-0">
                <p class="hidden-logo">.</p>
                <p class="hidden-title">.</p>
                <p id="name">
    
                </p>
                
                <iframe class="video-player"
                src="https://www.youtube.com/embed/VBo3A-GG_rg"
                style="border:0;height:360px;width:640px;max-width:100%"
                allow="autoplay"></iframe>
            </div>
    
            <div class="slide-videos-list col-lg-4 p-0">
                <div class="d-flex justify-content-between p-4 align-items-center bg-light">
                    <h4 class="mb-0">Course Content</h4>
                    <a href="{{route('home')}}"><i class="fa fa-times text-dark text-start"></i></a>
                </div>
                @foreach($sections as $section)
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item rounded-0">
                      <h2 class="accordion-header ps-sm-0 ps-4 p-0" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$section->id}}" aria-expanded="true" aria-controls="collapse{{$section->id}}">
                            Section {{ $loop->index }}: {{$section ->section_name}}
                        </button>
                      </h2>
                      <div id="collapse{{$section->id}}" class="accordion-collapse show collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body ps-sm-0 ps-4 p-0">
                            @foreach($section->lesson as $lesson)
                                <li class="lesson-body p-3" data-name="{{$lesson->lesson_name}}" data-section="{{$section ->section_name}}"
                                    data-url="{{$lesson->url}}">{{ $loop->index }}. {{$lesson->lesson_name}}</li>
                            @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
    
            </div>
    
        </div>
    </div>
   
@endsection
@section('page_js')
    <script src="{{asset('js/dashboard/course-page.js')}}"></script>
    <script>
        $(".lesson-body").each(function(){
            var all = this
            $(this).click(function(e){
                $(this).addClass("active").siblings().removeClass("active")
                $(".video-player")[0].src = $(this).data('url')
            })
        })
    </script>
@endsection


            {{-- <ul class="list-unstyled p-0" style="background:#333 !important">
                @foreach($sections as $section)
 
                    <li class="text-decoration-none text-light p-2">
                        Section {{ $loop->index }}: {{$section ->section_name}}
                        <ul class="mt-3">
                            @foreach($section->lesson as $lesson)
                                <li data-name="{{$lesson->lesson_name}}" data-section="{{$section ->section_name}}"
                                    data-url="{{$lesson->url}}">{{$lesson->lesson_name}}</li>
                            @endforeach
                        </ul>
                    </li>
                    <hr>
                @endforeach

            </ul> --}}