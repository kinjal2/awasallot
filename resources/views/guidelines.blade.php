<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
     
<div class="container">
   <h1>Usage Guidelines</h1>

    <p>Welcome to the Roads & Buildings Department – Estate Management System. Please read the following guidelines carefully to ensure proper use of the system.</p>

    <h2>1. System Access</h2>
    <ul>
      <li>Only authorized personnel are allowed to access the system.</li>
      <li>Users must use their government-issued login credentials.</li>
      <li>Do not share login credentials with others.</li>
    </ul>

    <h2>2. Data Entry Guidelines</h2>
    <ul>
      <li>Ensure that all data entered is accurate and up to date.</li>
      <li>Use proper formatting for names, dates, and property IDs.</li>
      <li>Regularly verify and update property records.</li>
    </ul>

    <h2>3. Security and Privacy</h2>
    <ul>
      <li>Do not store sensitive data in unsecured formats.</li>
      <li>Always log out after completing your session.</li>
      <li>Report any suspicious activity to the IT department.</li>
    </ul>

    <h2>4. Support and Maintenance</h2>
    <p>For any technical support or issues, please contact the IT helpdesk at <a href="mailto:support@example.gov.in">support@example.gov.in</a>.</p>

</div>

  
  <!-- ======= Footer ======= -->
    @include(Config::get('app.theme').'.template.footer_welcome')
</body>
</html>
