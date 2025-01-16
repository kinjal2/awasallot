<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')

<div class="container d-flex justify-content-center align-items-center " style="min-height: 500px;">
    <div class=" row">
    <div class="ccol-md-8 mx-auto">
            <div class="card box-design">
                <!-- <div class="card-header login-head">Login</div> -->
                <div class=" login-head text-center  ">
                
                  <p class="login-icon py-2">Verify Your Email Address</p>
                  <h4 class="m-0"><b>E-state Managment System</b></h4>
                  <p class="sub-title-form">Goverment of Gujarat</p>
                </div>
                <div class="">
               

                <div class="card-body verify-link">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
              
            </div>
        </div>
    </div>
</div>
@include(Config::get('app.theme').'.template.footer_front_page') 