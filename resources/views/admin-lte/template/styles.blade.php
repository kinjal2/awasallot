<link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/fontawesome-free/css/all.min.css') !!}">
  <!-- Ionicons -->
  
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/dist/css/ionicons.min.css') !!}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/daterangepicker/daterangepicker.css') !!}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}">
  <!-- Tempusdominus Bbootstrap 5 -->
  <!-- <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}"> -->
  <link href="{{ URL::asset('/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('/css/style_admin.css') }}" rel="stylesheet">
  <!-- Select2 -->
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/select2/css/select2.min.css') !!}">
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') !!}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') !!}">

   <!-- sweet Alert -->
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/sweetalert2/sweetalert2.min.css') !!}">


    <!-- DataTables -->
    <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/dist/css/adminlte.min.css') !!}">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <link href="{!! URL::asset(Config::get('app.theme_path').'/dist/css/fontface.css') !!}" rel="stylesheet">

  

<!-- page level styles -->

@stack('head-styles')
<style>
.error{
  color:red;
}

</style>

