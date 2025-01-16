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
          <button type="button" class="btn btn-primary_new" onclick="window.open('{{ url(rtrim(config('app.asset_url'), '/') . '/downloads/Guidelines.pdf') }}', '_blank')">
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
  <footer id="footer">
    <div class="container">
      <h3 class="m-0">Roads & Buildings Department</h3>
      <p class="sublogo">Estate Management System</p>
      <div class="copyright">
        All Rights Reserved &copy; Copyright <strong><span>@ National Informatics Centre,Gujarat.</span></strong>
      </div>
    </div>
  </footer>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/dist/js/adminlte.min.js') }}"></script>
     <!-- Template Main JS File -->
    <script src="{{ URL::asset('/js/main.js') }}"></script>
</body>
</html>
