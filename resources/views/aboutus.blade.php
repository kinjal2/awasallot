<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
     
<!-- <div class="container">
  <h1>About Us</h1>

    <p>The <strong>Roads & Buildings Department, Government of Gujarat</strong> is responsible for the planning, construction, and maintenance of government infrastructure across the state. This includes roads, bridges, and government-owned buildings used for administrative, residential, and institutional purposes.</p>

    <h2>About the Estate Management System</h2>

    <p>The <strong>Estate Management System (EMS)</strong> is an internal digital platform designed to streamline the administration and management of government properties under the jurisdiction of the department.</p>

    <p>This system provides a centralized approach to property data, ensuring real-time access, transparency, and efficiency in handling estate-related processes such as allocation, maintenance tracking, and asset utilization.</p>

    <h2>Our Mission</h2>
    <p>To enhance operational transparency and digital governance by providing a secure and efficient estate management platform for all stakeholders within the department.</p>

    <h2>Key Features</h2>
    <ul>
      <li>Centralized property records and digital archives</li>
      <li>Role-based user access and approvals</li>
      <li>Real-time property tracking and status updates</li>
      <li>Maintenance request handling and history</li>
      <li>Reports and analytics for decision-makers</li>
    </ul>
</div> -->


<section id="about" class="about" style="word-spacing: 0em;">
        <div class="container" style="word-spacing: 0em;">
          <div class="section-title aos-init aos-animate" data-aos="zoom-out" style="word-spacing: 0em;">
            <h2 style="word-spacing: 0em;">About</h2>
            <p style="word-spacing: 0em;">Who we are</p>
          </div>
          <div class="row content aos-init aos-animate" data-aos="fade-up" style="word-spacing: 0em;">
            <div class="col-lg-6" style="word-spacing: 0em;">
              <!-- <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna aliqua.
            </p> -->
              <ul style="word-spacing: 0em;">
                <li style="word-spacing: 0em;"><i class="ri-check-double-line" style="word-spacing: 0em;"></i> This Portal offers easy access to quarters information and various Government Buildings Information.</li>
                <li style="word-spacing: 0em;"><i class="ri-check-double-line" style="word-spacing: 0em;"></i> Our user Friendly portal enables swift application, Allocations and maintenance of the Quarters and Offices.</li>
                <!-- <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li> -->
              </ul>
              <!-- <a href="#" class="btn-learn-more">Learn More</a> -->
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0" style="word-spacing: 0em;">
              <img class="img-responsive" src="{{ URL::asset('/images/gift-home.jpg') }}" alt="Home" title="Home" style="word-spacing: 0em;">
            </div>
          </div>
        </div>
      </section>
    </section>
  
  <!-- ======= Footer ======= -->
    @include(Config::get('app.theme').'.template.footer_welcome')
</body>
</html>
