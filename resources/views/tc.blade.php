<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')

  
  
  <style>
   .container p {
  font-family: Arial, sans-serif;
  font-size: 1rem;
  line-height: 1.6;
  color: #333333;
  margin-bottom: 1rem;
  text-align: justify;
  text-indent: 2em;
}

.container p:first-of-type {
  margin-top: 2rem;
  text-indent: 2em;
}

/* Indent numbered headings and their paragraphs */
.lg-block h5,
.lg-block h5 + p {
  margin-left: 3em;
  color: #222222;
  /* font-weight: 600; */
}

.lg-block h5 {
  margin-top: 2rem;
  margin-bottom: 1rem;
}

/* Border and padding for content */
.lg-block {
  border: 1.5px solid #FFA500; /* orange border */
  padding: 20px;
  border-radius: 8px;          /* rounded corners */
  box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* subtle shadow */
  background-color: #fff;
}

.feedback-heading {
  font-family: Arial, sans-serif;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 2rem;
  color:rgb(252, 246, 246);
  text-align: center;
}

  </style>

<div class="container py-5">
  <h1 class="feedback-heading">Terms and Conditions</h1>
  <div class="col-md-12 mb-3">
      <div class="lg-block">
  <p >Welcome to the Roads & Buildings Department – Estate Management System. By accessing this website, you agree to comply with and be bound by the following terms and conditions of use.</p>

  <h5 class="mt-5">1. Use of the Website</h5>
  <p class="info1">You agree to use this website for lawful purposes only and in a manner that does not infringe the rights or restrict the use of this site by any third party.</p>

  <h5>2. Intellectual Property</h5>
  <p class="info1">All content on this website is the property of the Roads & Buildings Department or its licensors and is protected by applicable copyright laws.</p>

  <h5>3. Changes to Terms</h5>
  <p class="info1">We reserve the right to modify these terms at any time. You should review this page periodically for any updates.</p>

  <h5>4. Governing Law</h5>
  <p class="info1">These terms and conditions are governed by the laws of Gujarat, India.</p>

 
      </div></div>
</div>

  
  <!-- ======= Footer ======= -->
    @include(Config::get('app.theme').'.template.footer_welcome')
</body>
</html>
