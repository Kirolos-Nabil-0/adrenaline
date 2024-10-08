<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.26.0/apexcharts.min.css"
      integrity="sha512-JQIBcZTDAWa1umaHZvCXqHC1xa4jU8NyTWFCV977oIcbcLFdqtRxgoNC1CEv3c9GJWdIj4Vs7jfhgDQSEkpMMQ=="
      crossorigin="anonymous"/>
{{--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>--}}


<link rel="stylesheet" href="{{asset('css/dashboard/select2.min.css') }}">
<link rel="stylesheet" href="{{asset('css/dashboard/main.css') }}"> -->

<link rel="icon" href="{{URL::asset('css/dashboard/new/img/brand/favicon.png')}}" type="image/x-icon"/>
<!-- Icons css -->
<link href="{{URL::asset('css/dashboard/new/css/icons.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('css/dashboard/new/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--  Sidebar css -->
<link href="{{URL::asset('css/dashboard/new/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{URL::asset('css/dashboard/new/css/sidemenu.css')}}">
@yield('css')
<!--- Style css -->
<link href="{{URL::asset('css/dashboard/new/css/style.css')}}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{URL::asset('css/dashboard/new/css/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('css/dashboard/new/css/skin-modes.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.6/dist/sweetalert2.min.css">
<link href="{{URL::asset('css/dashboard/new/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('css/dashboard/new/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('css/dashboard/new/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('css/dashboard/new/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- <link href="{{URL::asset('css/dashboard/new/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet"> -->
<link href="{{URL::asset('css/dashboard/new/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
@media (max-width: 767.98px) {
  .main-header-left{
    order: 1;
  }
  .main-header-left img{
      display: none !important
  }
}
</style>