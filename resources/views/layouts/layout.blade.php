<!doctype html>

@yield('variables')
<?php
if (!isset($dir)) {
    $dir = "ltr";
}
?>
<html lang="en" dir="{{$dir}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--    <title>@yield('title')</title>--}}
    <meta name="description" content="Your Trusted Source for Educational Resources and Medical Insights">
    <meta name="keywords" content="education, medicine, healthcare, medical research, online courses, learning resources, medical articles, health education, medical education, academic resources, medical insights, healthcare updates, medical news, e-learning, medical professionals, student resources, patient information">

    <link rel="shortcut icon" href="{{URL::asset('images/logo.png')}}" type="image/x-icon">
    <title>Adrenaline - Online Courses</title>
    
    @include('layouts.header')
    @yield('page_css')

</head>
<body >
    {{-- oncontextmenu="return false" --}}
@yield('content')
@include('layouts.footer')
@include('layouts.scripts')
@yield('page_js')
</body>
</html>
