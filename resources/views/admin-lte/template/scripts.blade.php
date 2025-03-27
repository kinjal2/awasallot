
<!-- jQuery -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/moment/moment.min.js') }}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

<!-- Sweet Alert-->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/sweetalert2/sweetalert2.min.js') }}"></script>


<!-- DataTables -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>


<!-- AdminLTE App -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ URL::asset(Config::get('app.theme_path').'/dist/js/demo.js') }}"></script>
<script src="{{ URL::asset('/bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset('/bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>




<script type="text/javascript">
var oTable = null;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

</script>
@stack('footer-script')
<script type="text/javascript">
$(document).ready(function () {
        @stack('page-ready-script')
    });
    $('.select2').select2({
  selectOnClose: true
});
</script>
