<footer id="footer">
    <div class="container">
        <h3 class="m-0">Roads & Buildings Department</h3>
        <h5>Government of Gujarat</h5>
        <p class="sublogo">Estate Management System</p>
        <!-- Links section -->
        <div class="footer-links">
             <a href="{{ url('/') }}">Home</a> |
            <a href="{{ url('/aboutus') }}" >About Us</a> |
            <a href="{{ url('/contactus') }}" >Contact Us</a> |
            <a href="{{ url('/feedback') }}" >Feedback</a> |
            <a href="{{ url('/sitemap') }}" >Sitemap</a> |
            <a href="{{ url('/tc') }}" >Terms and Conditions</a> |
            <a href="{{ url('/privacy') }}" >Privacy Policy</a> |
            <a href="#"  onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/FAQ.pdf') }}', '_blank')" >FAQs</a>
        </div>
        <!-- Last Updated -->
        <div style="margin-top: 5px; font-size: 14px; color: #aaa;">
            Last Updated On: {{ \Carbon\Carbon::now()->format('F d, Y') }}
        </div>
        <!-- Visitor Count -->
        <div class="visitor-count" style="font-size: 14px; color: #aaa; margin-top: 5px; margin-bottom: 5px;">
            Total Visitors: {{ number_format(getVisitorCount()) }}
        </div>
       
        <div class="copyright"> 
    Content ,Business Processes and Business rules owned, maintained and updated by <a class="font-weight-500" href="https://rnb.gujarat.gov.in/" target="_blank">Roads &amp; Buildings Department</a>
        </div>
  <div class="copyright">Web Portal Designed and Developed by : National Informatics Center , <a href="http://guj.nic.in/" target="_blank"> Gujarat State Center </a>- All Rights Reserved <span>&reg;</span> 2025 &copy; &nbsp; 
  </div>
  <div class="copyright"><span style="font-size: 0.72rem;"> <span style="color: #f17000">Disclaimer :-</span> This portal is developed and maintained by NIC. NIC not <u> assume any legal liability or responsibility for the accuracy completeness or usefulness of any information.</u></span></div>
    </div>
</footer>
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<!-- jQuery -->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- jQuery Datetimepicker -->
<script src="{{ URL::asset('/js/jquery.datetimepicker.full.min.js')}}"></script>
<script src="{{ URL::asset('/js/glightbox.min.js') }}"></script>
<script src="{{ URL::asset('/js/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('/js/aos.js') }}"></script>
<!-- Template Main JS File -->
<script src="{{ URL::asset('/js/main.js') }}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>


<script>
    $(document).ready(function() {
        //  console.log($('meta[name="csrf-token"]').attr('content')); 

        //console.log("CSRF Token:", $('meta[name="csrf-token"]').attr('content'));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //console.log("CSRF Token:", $('meta[name="csrf-token"]').attr('content'));
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