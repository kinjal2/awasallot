<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
     
<div class="container">
  <h1>Frequently Asked Questions (FAQs)</h1>

    <div class="faq">
      <h3>1. What is the Estate Management System?</h3>
      <p>The Estate Management System is an internal platform developed to manage, monitor, and maintain properties under the Roads & Buildings Department.</p>
    </div>

    <div class="faq">
      <h3>2. Who can access the system?</h3>
      <p>Only authorized government personnel with valid credentials can access the system.</p>
    </div>

    <div class="faq">
      <h3>3. How is data protected?</h3>
      <p>All data is stored securely and protected using industry-standard encryption and security protocols.</p>
    </div>

    <div class="faq">
      <h3>4. What if I forget my password?</h3>
      <p>You can use the "Forgot Password" option on the login page or contact the system administrator for help.</p>
    </div>

    <div class="faq">
      <h3>5. How do I report a technical issue?</h3>
      <p>Please contact your department's IT support or email us at <a href="mailto:support@example.gov.in">support@example.gov.in</a>.</p>
    </div>
</div>

  
  <!-- ======= Footer ======= -->
    @include(Config::get('app.theme').'.template.footer_welcome')
</body>
</html>
