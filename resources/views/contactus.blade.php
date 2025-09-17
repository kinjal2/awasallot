<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
     
<!-- <div class="container">
   <h1>Contact Us</h1>

    <div class="contact-info">
      <p><strong>Department Name:</strong> Roads & Buildings Department, Government of Gujarat</p>
      <p><strong>System:</strong> Estate Management System (EMS)</p>
      <p><strong>Email:</strong> <a href="mailto:support@gujarat.gov.in">support@gujarat.gov.in</a></p>
      <p><strong>Phone:</strong> +91-79-2325-XXXX</p>
      <p><strong>Address:</strong> Block No. 14, 5th Floor, New Sachivalaya, Gandhinagar - 382010, Gujarat</p>
    </div>
</div> -->


 <!-- <div class="container py-5">
    <h1 class="text-center mb-4">Contact Us</h1>

    <div class="card shadow p-4 contact-card">
      <div class="card-body">
        <p><strong>Department Name:</strong> Roads &amp; Buildings Department, Government of Gujarat</p>
        <p><strong>System:</strong> Estate Management System (EMS)</p>
        <p><strong>Email:</strong> <a href="mailto:support@gujarat.gov.in">support@gujarat.gov.in</a></p>
        <p><strong>Phone:</strong> +91-79-2325-XXXX</p>
        <p><strong>Address:</strong> Block No. 14, 5th Floor, New Sachivalaya, Gandhinagar - 382010, Gujarat</p>
      </div>
    </div>
  </div> -->
 <h1 class="text-center m-4">Contact Us</h1>
  <div class="container py-5">
    <div class="row">
      <div class="col-md-4 contact-block">
        <i class="bi bi-envelope"></i>
         <p><a style="color:#4f4f4f" href="mailto:support@gujarat.gov.in">support@gujarat.gov.in</a></p>
      </div>
      <div class="col-md-4 contact-block">
        <i class="bi bi-telephone"></i>
        <p>+91-79-2325-XXXX</p>
      </div>
      <div class="col-md-4 contact-block">
        <i class="bi bi-geo-alt"></i>
        <p>Block No. 14, 5th Floor, New Sachivalaya, Gandhinagar - 382010, Gujarat</p>
      </div>
    </div>
  </div>

  
  <!-- ======= Footer ======= -->
    @include(Config::get('app.theme').'.template.footer_welcome')
</body>
</html>
