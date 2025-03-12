<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
<div class="container">
    <div class="row justify-content-center padd-y-50">
        <div class="col-md-6 mx-auto">
            <div class="card box-design">
                <div class="login-head text-center">
                    <p class="login-icon py-2">DDO Set Email and Password</p>
                    <h4 class="m-0"><b>E-State Management System</b></h4>
                    <p class="sub-title-form">Government of Gujarat</p>
                </div>

                <div class="card-body bg-lightwhite p-4">
                    <form method="POST" action="{{ route('ddo.saveEmailPwd') }}" id="LoginForm" name="LoginForm">
                        @csrf
                        <div class="col-12 form-group relative mb-3">
                            <label for="ddo_office_email" class="form-label">DDO Official E-mail Address&nbsp;<span class="text-danger">*</span></label>
                            <input id="ddo_office_email" type="email" class="custon-control form-control @error('ddo_office_email') is-invalid @enderror" placeholder="Enter your DDO Official E-mail Address" name="ddo_office_email" value="{{ old('ddo_office_email') }}" required autocomplete="off" autofocus>
                            <i class="bi bi-envelope form-icon"></i>
                            @error('ddo_office_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-12 form-group relative my-3">
                            <label for="password" class="form-label">{{ __('Password') }}&nbsp;<span class="text-danger">*</span></label>
                            <input id="password" type="password" class="custon-control form-control @error('password') is-invalid @enderror" placeholder="Enter your Password" name="password" required autocomplete="current-password">
                            <i class="bi bi-lock form-icon"></i>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-12 form-group relative my-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}&nbsp;<span class="text-danger">*</span></label>
                            <input id="password_confirmation" type="password" class="custon-control form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm your Password" name="password_confirmation" required autocomplete="new-password">
                            <i class="bi bi-lock form-icon"></i>
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group row relative my-3">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>
                            <div class="col-md-6">
                                <div class='captcha'>
                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-secondary" id="reload">&#x21bb;</button>
                                </div>
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
                            <button class="btn-new btn btn-primary btn-md" type="submit">Submit</button>
                            <!-- @if (Route::has('password.request'))
                            <a class="btn btn-link float-right" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            @endif -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include(Config::get('app.theme').'.template.footer_front_page')

<script>
     $.validator.addMethod("validEmail", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._%+-]+@gujarat\.gov\.in$/.test(value);
    }, "Invalid email. Email must end with @gujarat.gov.in.");

    $(document).ready(function() {
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
                ddo_office_email: {
                    required: true,
                    validEmail: true,
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"  // Check if password_confirmation matches password
                },
                captcha: {
                    required: true
                }
            },
            messages: {
                ddo_office_email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address (e.g., example@gujarat.gov.in)"
                },
                password: {
                    required: "Please enter your password"
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"  // Custom message for password mismatch
                 },
                captcha: {
                    required: "Please enter the captcha"
                }
            }
        });
        $('#reload').on('click', function() {
            $.ajax({
                type: 'GET',
                url: "{{ route('ddo.reload-captcha') }}", // Use the correct route name
                success: function(data) {
                    $('.captcha span').html(data.captcha); // Update the captcha image
                },
                error: function(xhr, status, error) {
                    console.error('Error reloading captcha: ' + error);
                }
            });
        });
    });
</script>