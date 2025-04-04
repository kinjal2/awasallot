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
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                @if($errors->has('code'))
                    <div class="alert alert-danger">
                        <!-- Display the first error message for the 'code' field -->
                        <strong>{{ $errors->first('code') }}</strong>
                    </div>
                @endif

                <div class="card-body bg-lightwhite p-4">
                    <form method="POST" action="{{ route('otp.login') }}" id="LoginForm" name='LoginForm'>
                        @csrf
                        <div class="col-12 form-group relative mb-3">
                          <label for="email" class="form-label">{{ __('E-Mail Address') }}&nbsp;  OR  {{ __('Mobile no') }}<span class="text-danger">*</span></label>
                          <input id="identifier" type="email" class="custon-control form-control @error('email') is-invalid @enderror" placeholder="Enter your E-mail"  name="identifier"  required autocomplete="identifier" autofocus >
                          <i class="bi bi-envelope form-icon"></i>
                            @error('email')
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
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">Enter Captcha Here&nbsp;<span class="text-danger">*</span></label>

                            <div class="col-md-8">
                                <input type="text" class="form-control custon-control" id="captcha" name="captcha" placeholder="Enter Captcha" required>
                            </div>
                        </div>
                        <div class="form-group row relative my-4">
                                <span class="text-danger">Fields marked with *  are mandatory to fill. </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                        <button class="btn-new btn btn-primary btn-md" type="submit">Send OTP</button>

                         <!-- 04-03-2025 --> <div><a class="btn btn-link float-right px-0 text-danger" href="{{ route('register') }}">{{ __(' New User Registration') }}</a> </div>
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
                identifier: {
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
