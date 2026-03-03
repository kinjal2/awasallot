<!DOCTYPE html>
<html>
<head>
    <title>Captcha Reload Demo</title>

    <!-- jQuery CDN -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@include(Config::get('app.theme').'.template.header_front_page')
    <style>
        body{
            font-family: Arial;
            padding: 40px;
        }
        .captcha-box{
            margin-bottom: 20px;
        }
        button{
            padding: 6px 12px;
            cursor: pointer;
        }
        #timer{
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Captcha Reload Test Page</h2>

<div class="captcha-box">
    <span id="captcha-img">{!! captcha_img() !!}</span>
    <button id="reload">Reload</button>
</div>

<p>Captcha expires in: <span id="timer">60</span> sec</p>
@include(Config::get('app.theme').'.template.footer_front_page')
@push('page-ready-script') @endpush @push('footer-script')
<script>
$(document).ready(function(){

    let seconds = 60;

    function reloadCaptcha() {
        $.ajax({
            type: 'GET',
            url: "{{ route('reload-captcha') }}",
            success: function(data) {
                $('#captcha-img').html(data.captcha);
                seconds = 60; // reset timer
            },
            error: function() {
                alert("Captcha reload failed!");
            }
        });
    }

    // Manual reload
    $('#reload').click(function(){
        reloadCaptcha();
    });

    // Countdown timer
    setInterval(function(){
        seconds--;
        $('#timer').text(seconds);

        if(seconds <= 0){
            reloadCaptcha();
        }
    },1000);

});
</script>

</body>
</html>
