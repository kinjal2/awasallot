<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">
      <h3 class="m-0">Roads & Buildings Department</h3>
      <p class="sublogo">Estate Management System</p>
      <div class="copyright">
        All Rights Reserved &copy; Copyright <strong><span>@ National Informatics Centre,Gujarat.</span></strong>
      </div>
     
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  
  <script src="{{ URL::asset('/js/bootstrap.bundle.min.js') }}"></script>

  
 
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/dist/js/demo.js') }}"></script>
    <!-- jQuery Validation -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- jQuery Datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

  <!-- Template Main JS File -->
  <script src="{{ URL::asset('/js/main.js') }}"></script>

  @stack('scripts')

    <!-- Custom Script -->
    <script type="text/javascript">
        jQuery.noConflict();

        jQuery(document).ready(function($) {
           // console.log('jQuery is working.');

            $('#reload').on('click', function() {
                $.ajax({
                    type: 'GET',
                    url: 'reload-captcha',
                    success: function(data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
        });
    </script>