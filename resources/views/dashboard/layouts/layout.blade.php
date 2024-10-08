<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ URL::asset('images/logo.png') }}" type="image/x-icon">
    {{--    <title>@yield('title')</title> --}}
    <title>Adrenaline - Online Courses</title>
    <?php
    $currentUser = auth()->user();
    ?>
    <script>
        var site_url = "{{ url('/') }}";
        var csrf_token = "{{ csrf_token() }}";
        var csrf_input = `@csrf`;
        var currentUser = @json($currentUser);
    </script>
    @include('dashboard.layouts.header', ['currentUser' => $currentUser])
    @yield('page_css')

</head>

<body class="main-body app sidebar-mini">
    <div id="global-loader">
        <img src="{{ URL::asset('images/new/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    @include('dashboard.layouts.sidebar')

    <div class="main-content app-content">
        @include('dashboard.layouts.navbar')
        <!-- container -->
        <div class="container-fluid">
            @yield('page-header')
            @yield('content-dashboard')
            @include('dashboard.layouts.scripts')
            @yield('page_js')
</body>

</html>
