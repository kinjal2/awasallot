<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page') 
<div class="container">
    <div class="row justify-content-center padd-y-50">
        <div class="col-md-6 mx-auto">
            <div class="card box-design">
                <!-- <div class="card-header login-head">{{ __('Login') }}</div> -->
                <div class=" login-head text-center  ">
                
                  <p class="login-icon py-2">Login</p>
                  <h4 class="m-0"><b>E-state Managment System</b></h4>
                  <p class="sub-title-form">Goverment of Gujarat</p>
                </div>

                <div class="card-body bg-lightwhite p-4">
                    <form method="POST" action="{{ route('login') }}" id="LoginForm" name='LoginForm'>
                        @csrf
                        <div class="col-12 form-group relative mb-3">
                          <label for="email" class="form-label">{{ __('E-Mail Address') }} </label>
                          <input id="email" type="email" class="custon-control form-control @error('email') is-invalid @enderror" placeholder="Enter your E-mail"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                          <i class="bi bi-envelope form-icon"></i> 
                          @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="col-12 form-group relative my-3">
                          <label for="password" class="form-label">{{ __('Password') }}</label>
                          <input id="password" type="password" class="custon-control form-control @error('password') is-invalid @enderror" placeholder="Enter your Password" name="password" required autocomplete="current-password">
                          <i class="bi bi-lock form-icon"></i>
                            @error('password')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                             @enderror
                        </div>
                        
 <div class="form-group row relative my-3">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>

                            <div class="col-md-6">
                            <div class='captcha'> <span>{!! captcha_img() !!}  </span>
                                <button type="button" class="btn btn-secondary" id="reload">
                                    &#x21bb;
                                </button></div>
                            </div>
                        </div>

                        <div class="form-group row relative my-4">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">Enter Captcha Here</label>

                            <div class="col-md-8">
                                <input type="text" class="form-control custon-control " id="captcha" name="captcha" placeholder="Enter Captcha" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                        <button class="btn-new btn btn-primary btn-md" type="submit">{{ __('Login') }}</button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link float-right" href="{{ route('password.request') }}">
                              {{ __('Forgot Your Password?') }}
                            </a>
                         @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include(Config::get('app.theme').'.template.footer_front_page') 
<script>
    
    // jQuery code
    $(document).ready(function() {
        $('input.dateformat').datetimepicker({
            format: 'd-m-Y',
            timepicker: false
        });
       
      
      $('#LoginForm').validate({
            errorClass: "error-message",
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
                $(element).closest('.form-control').addClass('error-field');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
                $(element).closest('.form-control').removeClass('error-field');
            },
            rules: {
            /*    name: {
                    required: true
                },*/
                email: {
                    required: true
                },
                password: {
                    required: true
                },
                
                // Add rules for other fields here
            },
            messages: {
               /* name: {
                    required: "Please enter your name"
                },*/
                /*birthdate: {
                    required: "Please enter birthdate"
                },*/
                // Add custom messages for other fields here
            }
        });
    });
</script>