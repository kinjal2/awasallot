
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
            <a href="{{ url('/privacy') }}" >Privacy Policy</a>
        </div>
        <!-- Last Updated -->
        <div style="margin-top: 10px; font-size: 14px; color: #aaa;">
            Last Updated On: {{ \Carbon\Carbon::now()->format('F d, Y') }}
        </div>
        <!-- Visitor Count -->
        <div class="visitor-count" style="font-size: 14px; color: #aaa; margin-top: 10px;">
            Total Visitors: {{ number_format(getVisitorCount()) }}
        </div>
        <div class="copyright">
            All Rights Reserved &copy; Copyright <strong><span>@ National Informatics Centre,Gujarat.</span></strong>
        </div>
    </div>
</footer>

</div>
<!-- End Footer -->