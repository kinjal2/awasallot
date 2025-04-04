<!DOCTYPE html>
<html>
<style>

</style>
@include(Config::get('app.theme').'.template.header_front_page')
<div class="container">
    <div class="row justify-content-center padd-y-50">
        <div class="col-md-6 mx-auto">
            <div class="card box-design">
                <div class="login-head text-center">
                    <p class="login-icon py-2">DDO Login</p>
                    <h4 class="m-0"><b>E-State Management System</b></h4>
                    <p class="sub-title-form">Government of Gujarat</p>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card-body bg-lightwhite p-4">
                    <form method="POST" action="{{ route('ddo.login') }}" id="LoginForm" name="LoginForm">
                        @csrf
                        <div class="col-12 form-group relative mb-3">
                            <label for="ddo_reg_no" class="form-label">DDO Registration Number&nbsp;<span class="text-danger">*</span></label>
                            <input id="ddo_reg_no" type="text" class="custon-control form-control @error('ddo_reg_no') is-invalid @enderror" placeholder="Enter your DDO Registration Number" name="ddo_reg_no" value="{{ old('ddo_reg_no') }}" required autocomplete="off" autofocus>
                            <i class="bi bi-envelope form-icon"></i>
                            @error('ddo_reg_no')
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
                                <input type="text" class="form-control custon-control  @error('captcha') is-invalid @enderror" id="captcha" name="captcha" placeholder="Enter Captcha" required>
                                @error('captcha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>

                        </div>
                        <div class="form-group row relative my-4">
                                <span class="text-danger">Fields marked with *  are mandatory to fill. </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <button class="btn-new btn btn-primary btn-md" type="submit">{{ __('Login') }}</button>
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
@push('page-ready-script') @endpush @push('footer-script')
<script>
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
                ddo_reg_no: {
                    required: true,
                    pattern: /^SGV\d{6}[A-Z]$/ // Regex for DDO Registration Number format
                },
                password: {
                    required: true
                },
                captcha: {
                    required: true
                }
            },
            messages: {
                ddo_reg_no: {
                    required: "Please enter your DDO Registration Number",
                    pattern: "Please enter a valid DDO Registration Number (e.g., SGV089757D)"
                },
                password: {
                    required: "Please enter your password"
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
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("LoginForm").addEventListener("submit", function (event) {
            event.preventDefault();

            let passwordField = document.getElementById("password");
            let csrfToken = document.querySelector('input[name="_token"]').value; // Get CSRF token
             /* alert(passwordField);
              alert(csrfToken);*/
            let encryptedPassword = btoa(passwordField.value + csrfToken); // Base64 encode password + CSRF token

            passwordField.value = encryptedPassword; // Set the encrypted value
            this.submit();
        });
    });
</script>
