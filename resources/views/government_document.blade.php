<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
        
<div class="container">
  <div class="row mt-5 min-height_50"> <!-- Added flex-column here -->

    <!-- Start Single Service -->
    <div class="col-md-4 col-lg-4 mb-3"> <!-- Adjusted to full width for vertical stacking -->
      <div class="single-service">
        <div class="part-1">
          <i class="bi bi-file-earmark-pdf"></i>
          <h5 class="title mt-2">Bahedhari Khat</h5>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/Banhedharikhat.pdf') }}', '_blank')">
            Download
          </button>
        </div>
      </div>
    </div>
    <!-- / End Single Service -->

     <!-- Start Single Service -->
    <div class="col-md-4 col-lg-4 mb-3"> <!-- Adjusted to full width for vertical stacking -->
      <div class="single-service">
        <div class="part-1">
          <i class="bi bi-file-earmark-pdf"></i>
          <h5 class="title mt-2">Jamin Khat</h5>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/Jaminkhat.pdf') }}', '_blank')">
            Download
          </button>
        </div>
      </div>
    </div>
    <!-- / End Single Service -->


     <!-- Start Single Service -->
    <div class="col-md-4 col-lg-4 mb-3"> <!-- Adjusted to full width for vertical stacking -->
      <div class="single-service">
        <div class="part-1">
          <i class="bi bi-file-earmark-pdf"></i>
          <h5 class="title mt-2">Pay Certificate</h5>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/PayCertificate.pdf') }}', '_blank')">
            Download
          </button>
        </div>
      </div>
    </div>
    <!-- / End Single Service -->
     <!-- Start Single Service -->
    <div class="col-md-4 col-lg-4 mb-3"> <!-- Adjusted to full width for vertical stacking -->
      <div class="single-service">
        <div class="part-1">
          <i class="bi bi-file-earmark-pdf"></i>
          <h5 class="title mt-2">Schedule A [Fresh Quarter Request Form]</h5>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/Schedule_A.pdf') }}', '_blank')">
            Download
          </button>
        </div>
      </div>
    </div>
    <!-- / End Single Service -->
    
 <!-- Start Single Service -->
    <div class="col-md-4 col-lg-4 mb-3"> <!-- Adjusted to full width for vertical stacking -->
      <div class="single-service">
        <div class="part-1">
          <i class="bi bi-file-earmark-pdf"></i>
          <h5 class="title mt-2">Schedule B [Higher Category Quarter Request Form]</h5>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/Schedule_B.pdf') }}', '_blank')">
            Download
          </button>
        </div>
      </div>
    </div>
    <!-- / End Single Service -->
 <!-- Start Single Service -->
    <div class="col-md-4 col-lg-4 mb-3"> <!-- Adjusted to full width for vertical stacking -->
      <div class="single-service">
        <div class="part-1">
          <i class="bi bi-file-earmark-pdf"></i>
          <h5 class="title mt-2">Schedule B [Change Quarter Request Form]</h5>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/Schedule_C.pdf') }}', '_blank')">
            Download
          </button>
        </div>
      </div>
    </div>
    <!-- / End Single Service -->
 <!-- Start Single Service -->
    <div class="col-md-4 col-lg-4 mb-3"> <!-- Adjusted to full width for vertical stacking -->
      <div class="single-service">
        <div class="part-1">
          <i class="bi bi-file-earmark-pdf"></i>
          <h5 class="title mt-2">DESIGNATION/D.O.B/NAME OF CORRECTION</h5>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/designation_dob.pdf') }}', '_blank')">
            Download
          </button>
        </div>
      </div>
    </div>
    <!-- / End Single Service -->
    <!-- Start Single Service -->
    <div class="col-md-4 col-lg-4 mb-3"> <!-- Adjusted to full width for vertical stacking -->
      <div class="single-service">
        <div class="part-1">
          <i class="bi bi-file-earmark-pdf"></i>
          <h5 class="title mt-2">Police Staff Certificate</h5>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/police_staff_certificate.pdf') }}', '_blank')">
            Download
          </button>
        </div>
      </div>
    </div>
    <!-- / End Single Service -->








    
  </div>
</div>








  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
    @include(Config::get('app.theme').'.template.footer_welcome')
</body>
</html>
