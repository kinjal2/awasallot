<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')

<div class="container">
  <h1>Sitemap</h1>
  <ul>
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('/') }}">Login</a></li>
    <li><a href="{{ url('/') }}">DDO Login</a></li>
    <li><a href="{{ url('/') }}">Department User Login</a></li>
    <li><a href="{{ url('/aboutus') }}">About Us</a></li>
    <li><a href="{{ url('/') }}">Government Resolution</a></li>
    <li><a href="{{ url('/') }}">Download</a></li>
    <li><a href="{{ url('/guidelines') }}">Guidelines</a></li>
    <li><a href="{{ url('/faqs') }}">FAQs</a></li>
    <li><a href="{{ url('/contactus') }}">Contact Us</a></li>
    <li><a href="{{ url('/feedback') }}">Feedback</a></li>
    <li><a href="{{ url('/sitemap') }}">Sitemap</a></li>
    <li><a href="{{ url('/tc') }}">Terms and Conditions</a></li>
    <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
  </ul>
</div>


<!-- ======= Footer ======= -->
@include(Config::get('app.theme').'.template.footer_welcome')
</body>

</html>