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
   <!-- Styles -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"> -->
    <link rel="stylesheet" href="{{ URL::asset('/css/swiper-bundle.min.css') }}">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"> -->
    <link rel="stylesheet" href="{{ URL::asset('/css/aos.css') }}">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"> -->
    <link rel="stylesheet" href="{{ URL::asset('/css/jquery.datetimepicker.min.css') }}">

        <!-- DataTables -->
         
        <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">
  <link rel="stylesheet" href="{!! URL::asset(Config::get('app.theme_path').'/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}">

    </style>

</head>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center  header-transparent ">
    <div class="container-fluid d-flex align-items-center justify-content-between px-5_new">
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
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ url('/') }}" class="logindata {{ Request::is('/') ? 'round_btn' : '' }}">Home</a></li>
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('login') }}" class="logindata {{ Request::is('login') ? 'round_btn' : '' }}">Login</a></li>
                  <!-- @if (Route::has('register'))
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('register') }}" class="logindata">Register</a></li>
                  @endif -->
                  @if (Route::has('ddo.login'))
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('ddo.login.form') }}" class="logindata {{ Request::is('ddo/login') ? 'round_btn' : '' }}"> DDO Login</a></li>
                  @endif
                  @if (Route::has('register'))
                  <li class="nav-item d-none d-sm-inline-block"><a href="https://staging5.gujarat.gov.in/SSOtest/SSO.aspx?Rurl={{ route('grasapi') }}" class="logindata"> Department User Login</a></li>
                  @endif
                @endauth
                   <!-- @if (Route::has('ddo/login')) -->
                   <!-- <li class="nav-item d-none d-sm-inline-block"><a href="{{ route('/ddo/login') }}" class="logindata"> DDO Login</a></li> -->
                  <!-- @endif -->
               
                   <li class="nav-item d-none d-sm-inline-block"><a href="{{ url('/government_resolution') }}" class="logindata {{ Request::is('government_resolution') ? 'round_btn' : '' }}">Government Resolution</a></li>
                  <li class="nav-item d-none d-sm-inline-block"><a href="{{ url('/government_document') }}" class="logindata {{ Request::is('government_document') ? 'round_btn' : '' }}">Download</a></li>
                   <li class="nav-item d-none d-sm-inline-block "><a href="{{  route('vacant.quarter.form')}}" class="logindata {{ Request::is('checkvacant') ? 'round_btn' : '' }}">Check Vacant</a></li>

              </div>
            @endif
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
    </div>
  </header><!-- End Header -->
  <!-- ======= Hero Section ======= -->
  <section id="subhero" class="d-flex flex-column justify-content-end align-items-center">
    <!-- <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
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
    </svg> -->
  </section><!-- End Hero -->
