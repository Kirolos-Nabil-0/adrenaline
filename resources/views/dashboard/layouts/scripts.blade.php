<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"
        integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a1a75d5546.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.26.0/apexcharts.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}

{{-- <script src="{{asset('js/dashboard/select2.min.js')}}"></script> --}}-->
{{-- <script src="{{asset('js/dashboard/numeric.js')}}"></script> --}}
{{-- <script src="{{asset('js/dashboard/app.js')}}"></script>  --}}


<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{URL::asset('js/dashboard/new/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('js/dashboard/new/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('js/dashboard/new/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('js/dashboard/new/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('js/dashboard/new/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('js/dashboard/new/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
<!--Internal Sparkline js -->
<script src="{{URL::asset('js/dashboard/new/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('js/dashboard/new/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{URL::asset('js/dashboard/new/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/sidebar/sidebar-custom.js')}}"></script>
<!-- Eva-icons js -->
<script src="{{URL::asset('js/dashboard/new/js/eva-icons.min.js')}}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{URL::asset('js/dashboard/new/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('js/dashboard/new/js/custom.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/side-menu/sidemenu.js')}}"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.6/dist/sweetalert2.min.js"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/notify/js/notifit-custom.js')}}"></script>
<script>
   if($("#ui_notifIt")){
        setTimeout(() => {
           $("#ui_notifIt").fadeOut() 
        }, 5000);
   }
</script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('js/dashboard/new/js/advanced-form-elements.js')}}"></script>

<script src="{{URL::asset('js/dashboard/new/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('js/dashboard/new/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('js/dashboard/new/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!-- Internal Select2.min js -->
<script src="{{URL::asset('js/dashboard/new/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('js/dashboard/new/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('js/dashboard/new/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
