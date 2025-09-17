<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')
<div class="container  py-5">
    <h1 class="feedback-heading">Feedback Form</h1>
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <form name="feedbackForm" id="feedbackForm" method="POST" action="{{ route('feedback.store') }}">
        @csrf
 
        <div class="row">
    <!-- Name -->
    <div class="col-md-4 mb-3">
        <div class="lg-block">
            <div class="form-group">
                <label for="name" class="question_bg mb-3">Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" />
                @error('name')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Email -->
    <div class="col-md-4 mb-3">
        <div class="lg-block">
            <div class="form-group">
                <label for="email" class="question_bg mb-3">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" />
                @error('email')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Mobile -->
    <div class="col-md-4 mb-3">
        <div class="lg-block">
            <div class="form-group">
                <label for="phone" class="question_bg mb-3">Mobile Number:</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="form-control" maxlength="10"/>
                @error('phone')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Message -->
    <div class="col-md-12 mb-3">
        <div class="lg-block">
            <div class="form-group">
                <label for="message" class="question_bg mb-3">Message:</label>
                <textarea name="message" id="message" rows="5" class="form-control">{{ old('message') }}</textarea>
                @error('message')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 mb-3">
        <div class="lg-block">
            <div class="form-group">
        <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>
        <div class="col-md-4">
            <div class='captcha'> <span>{!! captcha_img() !!} </span>
                <button type="button" class="btn btn-secondary" id="reload">
                    &#x21bb;
                </button>
            </div>
             <div class="col-md-6 form-group relative my-3">
                        <label for="captcha" class="col-form-label text-md-right">Enter Captcha Here&nbsp;<span class="text-danger">*</span></label>

                        <input type="text" class=" custon-control form-control" id="captcha" name="captcha" placeholder="Enter Captcha" required>

                        </div>
            @error('captcha')
        <div style="color: red; margin-bottom: 10px;">{{ $message }}</div>
        @enderror
        </div>
            </div></div></div>
            <div class="col-md-12 mb-3">
        <div class="lg-block">
            <div class="form-group">
        <button type="submit" class="btn-new btn btn-primary btn-md mt-3">
            Submit Feedback
        </button> </div></div></div>
    </form>
</div>
<!-- ======= Footer ======= -->
@include(Config::get('app.theme').'.template.footer_welcome')
<script>
    $(document).ready(function() {
        // Custom rule for letters and spaces only
        $.validator.addMethod("lettersAndSpaces", function(value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/.test(value);
        }, "Name can only contain letters and spaces.");
        // Custom rule for 10-digit mobile number
        $.validator.addMethod("validMobile", function(value, element) {
            return this.optional(element) || /^[0-9]{10}$/.test(value);
        }, "Please enter a valid 10-digit mobile number.");
        $.validator.addMethod("validMessage", function(value, element) {
                // Allowed chars: letters, numbers, space, &, comma, colon, single and double quotes, dot, hyphen
                return this.optional(element) || /^[A-Za-z0-9 &,:'"\.\-\n\r]+$/.test(value);
            }, "Message contains invalid characters.");
        $("#feedbackForm").validate({
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
                name: {
                    required: true,
                    maxlength: 255,
                    lettersAndSpaces: true
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                phone: {
                    required : true,
                    maxlength: 10,
                    validMobile: true
                },
                message: {
                    required: true,
                    maxlength: 500,
                    validMessage: true
                },
                // captcha: {
                //         required: true
                //     }
            },
            messages: {
                name: { required : "Please enter your name.",
                 },
                email: {
                    required: "Please enter your email.",
                    email: "Please enter a valid email address."
                },
                phone: {
                    required : "Please enter mobile number",
                    maxlength: "Phone number can't be longer than 10 digits.",
                    validMobile : "Enter valid mobile number"
                },
                message: {
                    required: "Please enter your message.",
                    maxlength: "Message not more than 500 characters",
                    validMessage: "Message contains invalid characters."
                },
                
            }
        });
       
    });
</script>
</body>
</html>