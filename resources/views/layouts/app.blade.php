<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Awas Allot') }}</title>
    @include(Config::get('app.theme').'.template.header_front')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/dist/js/demo.js') }}"></script>
    <!-- jQuery Validation -->
    <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- jQuery Datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        a.logindata {
            color: white;
            background-color: transparent;
            text-decoration: none;
            font-size: 20px;
            padding-right: 8px;

        }
        .error-message {
            color: red;
        }
        .error-field {
            border-color: red;
            box-shadow: 0 0 5px red;
        }
    </style>
</head>
<body>
    <div id="app">
    <header id="header" class="fixed-top header-transparent ">
    <nav class="navbar navbar-expand-lg  p-3">
    <div class="container">
      <a class="navbar-brand logo-brand" href="#"><img class="img-fluid" src="{{ URL::asset('/images/logo.png') }}"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class=" collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto ">
          
          @guest 
          <li class="nav-item d-sm-inline-block"><a class="logindata" href="{{ route('login') }}">{{ __('Login') }}</a></li> 
            @if (Route::has('register')) 
                <li class="nav-item d-sm-inline-block"><a class="logindata" href="{{ route('register') }}">{{ __('Register') }}</a></li> 
            @endif @else 
            <li class="nav-item d-sm-inline-block dropdown"><a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->name }}
                      </a>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
                      </div>
                    </li> 
        @endguest
         
        </ul>
      </div>
    </div>
    </nav>




    
      
       
      </header>
      <!-- End Header -->
      <section id="subhero" class="d-flex flex-column justify-content-end align-items-center">
        <!-- <svg class="hero-waves"
									xmlns="http://www.w3.org/2000/svg"
									xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none"><defs><path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></defs><g class="wave1"><use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)"></g><g class="wave2"><use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)"></g><g class="wave3"><use xlink:href="#wave-path" x="50" y="9" fill="#fff"></g></svg> -->
      </section>
      <!-- End Hero -->
    

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <!-- Custom Script -->
    <script type="text/javascript">
        jQuery.noConflict();

        jQuery(document).ready(function($) {
            console.log('jQuery is working.');

            $('#reload').on('click', function() {
                $.ajax({
                    type: 'GET',
                    url: 'reload-captcha',
                    success: function(data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
        });
    </script>

    <div class="page-footer" style="padding-top: 200px;">
        @include(Config::get('app.theme').'.template.footer')
    </div>
</body>
</html>
