{{-- <div class="banner">
    <div class="shadow position-absolute w-100 h-100"></div>
    <h1 dir="ltr">!اهلا بيك ف عرب ميديسن </h1>
    <form action="{{route('home')}}" method="get" class="mt-5 position-relative ms-auto search-form">

        <button type="submit" class="position-absolute text-dark"
                style="background: transparent !important; border: 0 ; left: 5px ; top: 5px"><i
                class="fa fa-search"></i></button>
        <input type="text" name="search" value="{{request('search')}}" placeholder="عايز تبحث عن اي كورس ؟" class="form-control">
    </form>
</div> --}}
      <!-- banner-area -->
    <section class="banner-area fix p-relative banner">
    <div class="banner-bg banner-bg-rainbow" data-background="{{asset('images/banner-bg-2.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-8">
                <div class="hero-content hero-content-black">
                    <h2 class="hero-title-black mb-45">Online Learning Designed For <br>Real Life</h2>
                    <div class="hero-btn">
                        <a href="{{route('courses')}}" class="tp-btn">All Courses</a>
                    </div>
                </div>
                </div>
                {{-- <div class="col-xl-6 col-lg-6">
                <div class="banner-shape d-none d-md-block">
                    <img src="{{asset('images/1.png')}}" alt="banner-shape" class="b-shape-3">
                </div>
                </div> --}}
            </div>
        </div>
    </div>
    </section>
    <!-- banner-area-end -->