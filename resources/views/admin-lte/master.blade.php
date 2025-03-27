<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Estate Administration System - @yield('title')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta content="AwasAllot" name="description" />
        <meta content="AwasAllot" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include(Config::get('app.theme').'.template.styles')
      
     </head>
    <!-- END HEAD -->

   <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <!-- BEGIN HEADER -->
       <div class="wrapper">
            @include(Config::get('app.theme').'.template.header')
        
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
       <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- BEGIN SIDEBAR -->
            @include(Config::get('app.theme').'.template.sidebar')
            <!-- END SIDEBAR -->
            </aside>
              <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
                <!-- BEGIN CONTENT BODY -->
               
                    @yield('content')
                   
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
          <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            @include(Config::get('app.theme').'.template.footer')
        </div>
        <!-- END FOOTER -->
        @include(Config::get('app.theme').'.template.scripts')
    </body>

</html>