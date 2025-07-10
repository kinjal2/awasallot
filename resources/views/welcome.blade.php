<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Roads and Buildings Department</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{ URL::asset('/css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('/css/bootstrap-icons.css') }}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ URL::asset('/css/style.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('/css/accessibility-widget.css') }}" rel="stylesheet">																			  
   <!-- Styles -->

              
<style>
    @keyframes blink {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }
    .accessibility-toolbar {
    background: #dfbfa7;
    padding: 6px 12px;
    font-size: 14px;
    text-align: right;
    border-top: 4px solid #ef6603;
}
    .accessibility-toolbar a {
        text-decoration: none;
        font-weight: bold;
        margin-right: 10px;
        color: #000;
    }
    .accessibility-toolbar a:hover {
        text-decoration: underline;
    }
    .btn_top_icon {
    border: 2px solid #ffffff;
    padding: 0 6px;
    font-weight: 600;
    background: #ef6603;
    color: #fff;
}
    .btn_top_icon:hover {
    border: 2px solid #ef6603;
    padding: 0 6px;
    font-weight: 600;
    background: #fff;
    color: #000;
}
  </style>
</head>
<body>
  <!-- ✅ Accessibility Toolbar -->
 <div> 
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top align-items-center  header-transparent">
    <div class="accessibility-toolbar">
      <!-- <a href="#" id="increasetext" onclick="adjustTextSize('increase')">A+</a>
      <a href="#" id="decreasetext" onclick="adjustTextSize('decrease')">A-</a>
      <a href="#" id="resettext" onclick="adjustTextSize('reset')">A</a>
      <a href="#main-content">Skip to main content</a>
      <a href="#" onclick="activateScreenReader()">Access screen reader</a> -->
      <a href="#information" > Skip to Main Content</a>
       <button id="btn-decrease" class="btn btn-default btn_top_icon " type="button"><i class="fa fa-font" aria-hidden="true"></i>A-</button>
          <button id="btn-orig" class="btn btn-default btn_top_icon " type="button"><i class="fa fa-font" aria-hidden="true"></i>A</button>
          <button id="btn-increase" class="btn btn-default btn_top_icon " type="button"><i class="fa fa-font" aria-hidden="true"></i>A+</button>
          
  </div>
     <div class="container-fluid d-flex align-items-center justify-content-between px-5_new py-2">
        <div class="logo">
            <h1><a href="index.html"><img src="{{ URL::asset('/images/logo.png') }}"></a></h1>
        </div>
        <nav id="navbar" class="navbar">
          <ul class="navbar-nav navbar-nav ml-auto">            
            @if (Route::has('login'))
              <div class="top-right links">
                @auth
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ url('/home') }}" class="logindata">Home</a></li>
                  @else
                  <li class="nav-item d-none d-sm-inline-block "><a href="{{ url('/') }}" class="logindata {{ Request::is('/') ? 'round_btn' : '' }}">Home</a></li>
                  <li class="nav-item d-none d-sm-inline-block "><a href="{{ route('login') }}" class="logindata {{ Request::is('login') ? 'round_btn' : '' }}">Login</a></li>
                  <!-- @if (Route::has('register'))
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('register') }}" class="logindata">Register</a></li>
                  @endif -->
                  @if (Route::has('ddo.login'))
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('ddo.login.form') }}" class="logindata {{ Request::is('ddo/login') ? 'round_btn' : '' }}"> DDO Login</a></li>
                  @endif
                  @if (Route::has('register'))
                  <li class="nav-item d-none d-sm-inline-block"><a href="https://staging5.gujarat.gov.in/SSOtest/SSO.aspx?Rurl={{ route('grasapi') }}" class="logindata"> Department User Login</a></li>
                  @endif
                   <li class="nav-item d-none d-sm-inline-block"><a href="{{ url('/government_resolution') }}" class="logindata {{ Request::is('government_resolution') ? 'round_btn' : '' }}">Government Resolution</a></li>
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ url('/government_document') }}" class="logindata {{ Request::is('government_document') ? 'round_btn' : '' }}">Download</a></li>
                   <!-- <li class="nav-item d-none d-sm-inline-block "><a href="{{  route('vacant.quarter.form')}}" class="logindata {{ Request::is('checkvacant') ? 'round_btn' : '' }}">Check Vacant</a></li> -->
                @endauth
              </div>
            @endif
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
    </div>
  </header><!-- End Header -->
  
  <!-- ======= Hero Section ======= -->
  <section id="hero"  class="d-flex flex-column justify-content-end align-items-center">
    <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">
      <div class="carousel-item active">
        <div class="carousel-container">
          <h2 class="animate__animated animate__fadeInDown">Welcome to <span style="color: #ef6603;">Roads & Buildings Department</span></h2>
          <p class="animate__animated fanimate__adeInUp">Welcome to this portal for easy quarter Allocation, Management and Maintenance</p>
          <!-- Welcome to the Quarter Allocation, Management, and Maintenance Portal

This portal provides seamless access to information on residential quarters and various government buildings.
Designed with user convenience in mind, our platform enables quick and efficient application, allocation, and maintenance of quarters and office spaces. -->
          <!-- <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a> -->
        </div>
      </div>
    </div>
    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
      <defs>
        <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
      </defs>
      <g class="wave1">
        <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
      </g>
      <g class="wave2">
        <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
      </g>
      <g class="wave3">
        <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
      </g>
    </svg>
  </section><!-- End Hero -->


   <main id="main">
    <!-- ======= About Section =======-->
    <section id="about" class="about">
      <div class="container">
        <div class="section-title" data-aos="zoom-out">
          <h2>About</h2>
          <p>Who we are</p>
        </div>
        <div class="row content" data-aos="fade-up">
          <div class="col-lg-6">
            <!-- <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna aliqua.
            </p> -->
            <ul>
            <li><i class="ri-check-double-line"></i> This Portal offers easy access to quarters information and various Government Buildings Information.</li>  
            <li><i class="ri-check-double-line"></i> Our user Friendly portal enables swift application, Allocations and maintenance of the Quarters and Offices.</li>
              <!-- <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li> -->
            </ul>
            <!-- <a href="#" class="btn-learn-more">Learn More</a> -->
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <img class="img-responsive"  src="{{ URL::asset('/images/gift-home.jpg') }}">
          </div>
        </div>
      </div>
    </section>
    <!-- End About Section -->

    <!-- ======= Information Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="section-title" data-aos="zoom-out">
          <h2>સૂચના</h2>
          <p>Information</p>
        </div>
        <div class="row">
            <div class="col-lg-7 mt-5 mt-lg-0" data-aos="fade-right">
            <div id="letest-news">
              <ul class="list">
                 <li >
                   <span class="title"><h4><a   href="{{ url(config('app.asset_url'),'/').'/downloads/UserRegistration.pdf' }}" target="_blank" class="blink_text" target="_blank">User Registration</a></h4></span>
                </li>
                <li >
                 <span class="title"><h4><a   href="{{ url(config('app.asset_url'),'/').'/downloads/Userlogin.pdf' }}" target="_blank" class="blink_text" target="_blank">User Guidelines</a></h4></span>
                </li>
				 <li >
                  <span class="title"><h4><a   href="{{ url(config('app.asset_url'),'/').'/downloads/DDOLogin.pdf' }}" target="_blank" class="blink_text" target="_blank">DDO Guidelines</a></h4></span>
                </li> 
               <li >
                  <span class="title"><h4><a   href="{{ url(config('app.asset_url'),'/').'/downloads/ddo.pdf' }}" target="_blank" class="blink_text" target="_blank">View DDO Registration Number</a></h4></span>
                </li>
                <li >
                  <span >For Sending SSO Login form, send mail to <span style="color:red;" >itcell.rnb2018@gmail.com </span></span>
                </li>
               <!-- <li class="shopping">
                  <span class="title">વેબસાઇટ પર રજીસ્ટ્રેશન સમયે અરજદારે પોતાનું પૂરૂ નામ CAPITAL LETTER માં નિમણૂંક હુકમમાં દર્શાવ્યા મુજબનું દર્શાવવુ.</span>
                </li>
                <li class="shopping">
                  <span class="title">સરકારશ્રીના માર્ગ અને મકાન વિભાગના ઠરાવ નં.એસીડી/૧૧૯૮/૧૧૭૦/(૩૧)/ન.૧, તા.૧૩/૧૧/ર૦૧૯ મુજબ સાતમા પગારપંચ મુજબના મુળ પગાર પ્રમાણે અરજી કરવાની થાય છે તો સાતમા પગારપંચ મુજબનો મુળ પગાર દર્શાવતી છેલ્લી પગારસ્લીપ અરજી સાથે અવશ્ય સામેલ કરવી.</span>
                </li>
                <li class="shopping">
                  <span class="title">ફીકસ પગારના કર્મચારી હોય તો આપ જે પગાર ધોરણમાં કાયમી થવાના છો તે પગારધોરણ દર્શાવતો નિમણુંક હુકમ સામેલ કરવો તથા તે પગારધોરણ દર્શાવતી છેલ્લી પગારસ્લીપ સામેલ કરવી.</span>
                </li>
                <li class="shopping">
                  <span class="title">Designation માં હાલની કચેરી ખાતે તમે જે હુકમથી ફરજ બજાવો છો તે નિમણુંક હુકમમાં દર્શાવ્યા મુજબનો હોદ્દો CAPITAL LETTER માં દર્શાવવો તથા તે હુકમ સ્કેન કરીને અરજી સાથે સામેલ કરવો.</span>
                </li>
                <li class="shopping">
                  <span class="title">હાલની કચેરીનું પુરુ નામ CAPITAL LETTER માં દર્શાવવુ.</span>
                </li>
                <li class="shopping">
                  <span class="title">રજીસ્ટ્રેશન સમયે E-Mail ID અને Password કાળજીપૂર્વક દર્શાવવા અને લખીને રાખવા, આ E-Mail ID અને Password નો અરજી કરવા માટે Login ID તરીકે ઉપયોગ થઇ શકશે.</span>
                </li>
                <li class="shopping">
                  <span class="title">પ્રથમ વાર તથા ઉચ્ચ કક્ષાનું આવાસ મેળવવાની અરજી સાથે સામેલ કરવાના ડોકયુમેન્ટ બાંહેધરી ફોર્મ, જામીનખત, પગારનું પ્રમાણપત્ર વગેરે Download સેકશનમાં મુકેલ છે જેની પ્રીન્ટઆઉટ કાઢી તેમાં વિગતો ભરીને PDF ફોરમેટમાં સ્કેન કરી અરજી સાથે સામેલ કરવા. એક PDF File size max.450 KB રાખી શકાશે.</span>
                </li>
                <li class="shopping">
                  <span class="title">એટેચ કરેલ ડોકયુમેન્ટ અત્રે કચેરીમાં હાર્ડ કોપીમાં મોકલવાની જરૂરીયાત નથી.</span>
                </li>
                <li class="shopping">
                  <span class="title">અરજી પરત્વે રીમાર્ક આવે તેની ઓનલાઇન પૂર્તતા કરવી. રીમાર્કની પૂર્તતા કરવાને બદલે નવુ આઇ.ડી. બનાવીને રીમાર્કની પૂર્તતા કરવાનો પ્રયત્ન કરવો નહી. એકથી વધુ આઇ.ડી. વાળી અરજીઓ ચકાસણી કર્યા વગર પરત કરવામાં આવે છે. અરજી કરવા માટેની વિગતવાર સૂચનાઓ Download સેકશનમાં મુકેલ છે.</span>
                </li>
                <li class="shopping">
                  <span class="title">નામ તથા હોદ્દામાં ભુલ હોય તો અત્રેની કચેરીનો રૂબરૂ સંપર્ક કરવો જાતે સુધારવા પ્રયત્ન કરવો નહી કે નવું આઇ.ડી. બનાવવું નહી.</span>
                </li>
                <li class="shopping">
                  <span class="title">ઓનલાઇન અરજી સબંધીત માર્ગદર્શન માટે કચેરીમાં બપોરે ૩.૩૦ થી ૪.૩૦ ના સમયગાળામાં રૂબરૂ આવી શકો છો. સરનામુઃ અધિક્ષક ઇજનેરશ્રીની કચેરી, પાટનગર યોજના વર્તુળ,બ્લોક-૧૧/ર, ડો.જે.એમ.ભવન, ગાંધીનગર</span>
                </li> -->
              </ul>
            </div>
          </div> 
           <div class="col-lg-5" data-aos="fade-left"> <!-- original values -->
          <div class="col-lg-12" data-aos="fade-left"> <!-- set col-lg-12 to fill the space -->
            <div id="no-more-tables">
              <table class=" table table-bordered table-striped table-responsive-stack text-center">
                <thead class="cf">
                  <tr><th>અનુ.</th><th>વસવાટની કક્ષા</th><th class="numeric">સાતમા પગારપંચ મુજબ મુળ પગાર (રૂપિયા)</th></tr>
                </thead>
                <tbody>
                  <tr><td>૧</td><td>એ / જ-૧ / કક્ષા-૧</td><td>૧૪૮૦૦</td></tr>
                  <tr><td>૨</td><td>જ-ર</td><td>૧૮૦૦૦</td></tr>
                  <tr><td>૩</td><td>બી / જ / કક્ષા-ર</td>	<td>૧૯૯૦૦</td></tr>
                  <tr><td>૪</td><td>બી-૧ / છ</td>	<td>૨૫૫૦૦</td></tr>
                  <tr><td>૫</td><td>સી / ચ-૧</td>	<td>૨૯૨૦૦</td></tr>
                  <tr><td>૬</td><td>ચ / કક્ષા-૩</td>	<td>૩૯૯૦૦</td></tr>
                  <tr><td>૭</td><td>ડી / ઘ-૧</td>	<td>૫૩૧૦૦</td></tr>
                  <tr><td>૮</td><td>ડી-૧ / ઘ / કક્ષા-૪</td>	<td>૫૬૧૦૦</td></tr>
                  <tr><td>૯</td><td>ઇ / ગ-૧ / કક્ષા-પ</td>	<td>૭૮૮૦૦</td></tr>
                  <tr><td>૧૦</td>	<td>ઇ-૧ / ગ</td>	<td>૧૨૩૧૦૦</td></tr>
                  <tr><td>૧૧</td>	<td>ઇ-ર / ખ</td>	<td>૧૩૧૧૦૦</td></tr>
                  <tr><td>૧૨</td>	<td>‘ક‘ *</td>	<td>૧૪૪૨૦૦</td></tr>
                  <tr><td>૧૩</td>	<td>મંત્રીશ્રીઓના બંગલા</td>	<td>પગારધોરણ ધ્યાને લીધા સિવાય</td></tr>
                </tbody>
              </table>
              <p class="text-danger"><b>*નોંધઃ રૂા.૧,૮૨,૨૦૦ મુળ પગાર ધરાવનાર અધિકારીને અગ્રતા તથા રૂા.૨,૨૫,૦૦૦ મુળ પગાર ધરાવતા અધિકારીને ઉચ્ચ અગ્રતા આપવાની રહેશે.</b></p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->













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

  </div>
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- jQuery -->
    <script src="{{ URL::asset('/js/jquery.min.js') }}"></script>></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/dist/js/adminlte.min.js') }}"></script>
                             
     <!-- Template Main JS File -->
    <script src="{{ URL::asset('/js/main.js') }}"></script>
   <script src="{{ URL::asset('/js/accessibility-widget.js') }}" ></script>

  <!-- ✅ Accessibility JS -->
    <script>
  var $affectedElements = $("p, h1, h2, h3, h4, h5, h6, a, span, .disclaimer_text, .last-btm-foot, .b-footer-credit, li, .title");

  // Store original font sizes
  $affectedElements.each(function(){
    var $this = $(this);
    $this.data("orig-size", parseInt($this.css("font-size")));
  });

  let fontChangeSteps = 0; // Tracks net changes from original
  const maxSteps = 4;

  $("#btn-increase").click(function(){
    if (fontChangeSteps < maxSteps) {
      changeFontSize(1);
      fontChangeSteps++;
    }
  });

  $("#btn-decrease").click(function(){
    if (fontChangeSteps > -maxSteps) {
      changeFontSize(-1);
      fontChangeSteps--;
    }
  });

  $("#btn-orig").click(function(){
    $affectedElements.each(function(){
      var $this = $(this);
      $this.css("font-size", $this.data("orig-size") + "px");
    });
    fontChangeSteps = 0;
  });

  function changeFontSize(direction){
    $affectedElements.each(function(){
      var $this = $(this);
      let currentSize = parseInt($this.css("font-size"));
      $this.css("font-size", (currentSize + direction) + "px");
    });
  }
</script>
</body>
</html>
