<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')

<div class="container">
    <div class="row justify-content-center padd-y-50">
        <div class="col-md-6 mx-auto">
            <div class="card box-design">
                <!-- <div class="card-header login-head">Login</div> -->
                <div class=" login-head text-center  ">

                    <p class="login-icon py-2">OTP Verification</p>
                    <h4 class="m-0"><b>E-state Managment System</b></h4>
                    <p class="sub-title-form">Goverment of Gujarat</p>
                </div>
                <div class="l-form-box mb-3">
                @if($errors->has('code'))
                    <div class="alert alert-danger">
                        <!-- Display the first error message for the 'code' field -->
                        <strong>{{ $errors->first('code') }}</strong>
                    </div>
                @endif

                    <div class="l-form-container mb-4 d-flex justify-content-center p-4">

                        <form method="POST" action="{{ route('phoneverification.verify') }}">
                            @csrf

                            <div class="form-group col-sm-12 col-lg-12 ">
                                <label class="mb-2" for=""><span>Mobile Number OTP</span><span
                                        class="text-danger text-sm m-1">*</span></label>
                                <input type="password" class="form-control" name="otpnumber" id="otpnumber"
                                    placeholder='******'>
                            </div> <!-- form-group / col ends -->
                            <div class="form-group col-sm-12 col-lg-12 ">
                                <div class='captcha m-0 mb-2'> <span>{!! captcha_img() !!} </span>
                                    <button type="button" class="btn btn-secondary" id="reload">
                                        &#x21bb;
                                    </button>
                                </div>
                                <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>
                                <input type="text" class=" custon-control form-control" id="captcha" name="captcha"
                                    placeholder="Enter Captcha" required>


                            </div> 
                            <div class="form-group col-sm-12 col-lg-12 ">
                                <label class="form-check-label" for="">Email Verification link is sent to your registred
                                    Email
                                    ID. Please verify after OTP verification. </label>
                            </div>
                            <div class="clear mb-4"></div>
                            <div class="form-group col-sm-12 col-lg-12 ">

                                <button type="submit" class="btn-new btn btn-primary btn-md">
                                    Submit
                                </button>
                            </div> <!-- col ends -->
                        </form>
                    </div> <!-- l-form-container ends -->
                    @if($errors->any())
                    <span style="color:red">{{$errors->first()}}</span>
                    @endif
                    <hr class="hr-three">
                    <div class="row no-gutters">
                        <div class="col-12 text-center text-sm mb-3">
                            <div class="d-inline-block">Didn't Get OTP?</div>
                            <div class="d-inline-block"><a href="{{ route('phoneverification.notice') }}">Resend</a>
                            </div>
                        </div> <!-- col ends -->
                    </div> <!-- row ends -->

                </div> <!-- l-form-box ends -->

            </div>
        </div>
    </div>
</div>
@include(Config::get('app.theme').'.template.footer_front_page')
<script>
$(document).ready(function() {
    $('#reload').click(function(e) {

         e.preventDefault();

        // Make an AJAX request to get a new captcha image
        $.ajax({
            url: "{{ route('phone.reload-captcha') }}", // This should be the route that reloads the captcha
            type: 'GET',
            success: function(response) {
                console.log(response.captcha_src);
                // Update the captcha image source with the new captcha
                $('#captcha_image').attr('src', response.captcha_src);
            },
            error: function(xhr, status, error) {
                alert("Error reloading captcha: " + error);
            }
        });
    });
});
</script>