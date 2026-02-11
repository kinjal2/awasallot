<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
<!-- <div class="container">
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
</div> -->
<div class="container my-5">
  <h1 class="feedback-heading">Sitemap</h1>
  <div class="row justify-content-center">
    <!-- <div class="col-md-8"> -->
    <div class="col-md-12 mb-3">
      <div class="lg-block">
        <div class="list-group shadow-sm ">
          <a href="{{ url('/') }}" class="list-group-item list-group-item-action">Home</a>
          <a href="{{ url('/register') }}" class="list-group-item list-group-item-action">New User Registration</a>
          <a href="{{ url('/') }}" class="list-group-item list-group-item-action">Login</a>
          <a href="{{ url('/') }}" class="list-group-item list-group-item-action">DDO Login</a>
          <a href="{{ url('/') }}" class="list-group-item list-group-item-action">Department User Login</a>
          <a href="{{ url('/aboutus') }}" class="list-group-item list-group-item-action">About Us</a>
          <a href="{{ url('/')}}" class="list-group-item list-group-item-action">Government Resolution</a>
          <a href="{{ url('/')}}" class="list-group-item list-group-item-action">Download</a>
          <a href="{{ url('/guidelines') }}" class="list-group-item list-group-item-action">Guidelines</a>
          <a href="{{ url('/faqs') }}" class="list-group-item list-group-item-action">FAQs</a>
          <a href="{{ url('/contactus')}}" class="list-group-item list-group-item-action">Contact Us</a>
          <a href="{{ url('/feedback')}}" class="list-group-item list-group-item-action">Feedback</a>
          <a href="{{ url('/sitemap')}}" class="list-group-item list-group-item-action active" style="background-color: #ef6603; border-color: #ef6603; color: white;">Sitemap</a>
          <a href="{{ url('/tc')}}/tc" class="list-group-item list-group-item-action">Terms and Conditions</a>
          <a href="{{ url('/privacy')}}" class="list-group-item list-group-item-action">Privacy Policy</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ======= Footer ======= -->
@include(Config::get('app.theme').'.template.footer_welcome')
</body>
</html>