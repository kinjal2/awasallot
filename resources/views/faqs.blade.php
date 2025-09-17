<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
     
<!-- <div class="container">
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
</div> -->

 <div class="container my-5">
    <h1 class="mb-4 text-center">Frequently Asked Questions (FAQs)</h1>
    
    <div class="accordion" id="faqAccordion">
      
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq1Heading">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
            1. How can I register on the Awas Allotment System?
          </button>
        </h2>
        <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="faq1Heading" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            To register, click on the <strong>Login</strong> button on the homepage and select <em>New Registration</em>. Fill in your details and verify via OTP to complete registration.
          </div>
        </div>
      </div>
      
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq2Heading">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
            2. I forgot my password, how can I reset it?
          </button>
        </h2>
        <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2Heading" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Click on <strong>Forgot Password</strong> on the login page. Enter your registered email/mobile number to receive reset instructions.
          </div>
        </div>
      </div>
      
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq3Heading">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
            3. Who can apply for government housing quarters?
          </button>
        </h2>
        <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3Heading" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            All eligible government employees under the Gujarat state rules can apply for housing quarters through this portal.
          </div>
        </div>
      </div>
      
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq4Heading">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
            4. Where can I find the official guidelines and GR (Government Resolution)?
          </button>
        </h2>
        <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faq4Heading" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            The official guidelines and Government Resolution documents are available under the <a href="http://10.154.3.99/awasallot/guidelines">Guidelines</a> and <a href="http://10.154.3.99/awasallot">Government Resolution</a> sections.
          </div>
        </div>
      </div>
      
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq5Heading">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
            5. How can I contact support for issues?
          </button>
        </h2>
        <div id="faq5" class="accordion-collapse collapse" aria-labelledby="faq5Heading" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            You can reach us via the <a href="http://10.154.3.99/awasallot/contactus">Contact Us</a> page or submit your queries using the <a href="http://10.154.3.99/awasallot/feedback">Feedback</a> form.
          </div>
        </div>
      </div>
      
    </div>
  </div>

  
  <!-- ======= Footer ======= -->
    @include(Config::get('app.theme').'.template.footer_welcome')
</body>
</html>
