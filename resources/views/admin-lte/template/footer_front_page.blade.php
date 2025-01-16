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
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="{{ URL::asset('/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/additional-methods.min.js') }}"></script> 
    <!-- jQuery Datetimepicker -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
     <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script> 
     <!-- Template Main JS File -->
   <script src="{{ URL::asset('/js/main.js') }}"></script> 
   
<script>
    
    // jQuery code
    $(document).ready(function() {
        $('input.dateformat').datetimepicker({
            format: 'd-m-Y',
            timepicker: false
        });
       
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
    <!-- Custom Script -->
   
</body>
</html>