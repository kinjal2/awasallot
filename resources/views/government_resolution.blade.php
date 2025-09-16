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
          <h6 class="title mt-2">સરકારી કર્મચારી/અધિકારીઓ માટે નવા પગારધોરણો મુજબ સરકારી આવાસની કક્ષા નક્કી કરવા બાબત.</h6>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/Quarter_as_per_7th_pay.pdf') }}', '_blank')">
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
          <h6 class="title mt-2">ગાંધીનગર સ્થિત સરકારી આવાસોની ફાળવણી બાબત.</h6>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/resiyo_4_3_2_1 30-9-2023.pdf') }}', '_blank')">
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
          <h6 class="title mt-2">સરકારી આવાસોના ભાડાના દર નકકી કરવા બાબત</h6>
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/revised_rents.pdf') }}', '_blank')">
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
