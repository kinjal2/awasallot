@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)
@section('content')

<div class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">OTP</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">OTP</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card card-head">
            <div class="card-header">
                <h3 class="card-title">OTP</h3>
            </div>

            <div class="card-body">
                <div id="successMessage" class="alert alert-success" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span id="successText"></span>
                </div>
                <div id="errorMessage" class="alert alert-danger" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span id="errorText"></span>
                </div>

                <form id="otpForm" name="otpForm" class="form-horizontal" action="{{ route('user.getOtp') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="id" class="col-sm-6 control-label">User Id</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="id" name="id" placeholder="Enter User Id" value="{{ old('id') }}" maxlength="255">
                            <span class="text-danger" id="idError"></span>
                        </div>
                        @error('id')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-6 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" maxlength="255">
                            <span class="text-danger" id="emailError"></span>
                        </div>
                        @error('email')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="col-sm-6 control-label">Mobile</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile" value="{{ old('mobile') }}" maxlength="255">
                            <span class="text-danger" id="mobileError"></span>
                        </div>
                        @error('mobile')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" name="saveBtn">Get OTP</button>
                    </div>
                    <div id="otpBox" class="alert alert-success alert-dismissible fade show mt-5" style="display:none;" role="alert">
                        <strong>User ID:</strong> <span id="userIdValue"></span>
                        <strong>Your OTP is:</strong> <span id="otpValue"></span>
                        <button type="button" class="close" onclick="$('#otpBox').fadeOut()">
                            <span>&times;</span>
                        </button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('page-ready-script')
@endpush
@push('footer-script')
<script type="text/javascript">
    $(document).ready(function() {
        // Custom regex validation method
        $.validator.addMethod("regex", function(value, element, regex) {
            return this.optional(element) || regex.test(value);
        }, "Please check your input.");
        // Hide success and error messages initially
        $('#successMessage').hide();
        $('#errorMessage').hide();

        // Initialize form validation
        $("#otpForm").validate({
            rules: {
                id: {
                    // required: true,
                    regex: /^[0-9]+$/
                },
                email: {
                    // required: true,
                    email: true
                },
                mobile: {
                    // required: true,
                    regex: /^[6-9][0-9]{9}$/
                }
            },

            messages: {
                id: {
                    // required: "User Id is required",
                    regex: "User Id must be numeric"
                },
                email: {
                    // required: "Email is required",
                    email: "Enter a valid email address"
                },
                mobile: {
                    // required: "Mobile number is required",
                    regex: "Enter a valid 10-digit mobile number"
                }
            },

            submitHandler: function(form) {
                // Perform AJAX request on form submission
                $.ajax({
                    url: $(form).attr('action'), // Use the form's action attribute
                    type: "POST",
                    data: $(form).serialize(),
                    success: function(data) {


                        // Hide old messages
                        $('#successMessage').hide();
                        $('#errorMessage').hide();

                        console.log(data);

                        // Show OTP
                        if (data.otp) {
                            $('#otpValue').text(data.otp); // ✅ FIX HERE
                            $('#userIdValue').text(data.user_id);
                            $('#otpBox').fadeIn();
                        } else {
                            $('#errorText').text('OTP not received');
                            $('#errorMessage').fadeIn();
                        }
                    },
                    error: function(xhr) {
                        $('#successMessage').hide();

                        if (xhr.status === 422) {
                            // Clear previous error messages
                            $('.text-danger').text('');
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + 'Error').text(value[0]);
                            });
                        } else {
                            // Show generic error message
                            $('#errorMessage').find('#errorText').html('Something went wrong!');
                            $('#errorMessage').show();
                            setTimeout(function() {
                                $('#errorMessage').fadeOut();
                            }, 3000);
                        }
                    }
                });
            }
        });
    });
</script>



@endpush