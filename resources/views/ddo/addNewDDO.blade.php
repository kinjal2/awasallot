@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">DDO List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add New DDO</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-head">
            <div class="card-header">
                <h3 class="card-title">Add New DDO</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                @if (session('success'))
                    <div id="success" class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div id="successMessage" class="alert alert-success" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span id="successText"></span>
                </div>
                <div id="errorMessage" class="alert alert-danger" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span id="errorText"></span>
                </div>

                <div class="table-responsive p-4">
                    <form id="ddoForm" name="ddoForm" class="form-horizontal" action="{{ route('ddo.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="ddo_registration_no" class="col-sm-6 control-label">DDO Registration No</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="ddo_registration_no" name="ddo_registration_no" placeholder="Enter DDO Registration No" value="{{ $ddo_code }}" readonly minlength="10" maxlength="10">
                                <span class="text-danger" id="ddo_registration_noError"></span>
                            </div>
                            @error('ddo_registration_no')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>
                       													
							<div class="form-group">		 
                            <label for="ddoofficename" class="col-sm-6 control-label">DDO Office Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="ddoofficename" name="ddoofficename" placeholder="Enter DDO Office Name" value="{{ old('ddoofficename') }}" maxlength="255">
                                <span class="text-danger" id="ddoofficenameError"></span>
                            </div>
                            @error('ddoofficename')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>
                        	<div class="form-group">		 
                            <label for="ddo_office_email_id" class="col-sm-6 control-label">DDO Office Email</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="ddo_office_email_id" name="ddo_office_email_id" placeholder="Enter DDO Office Email" value="{{ old('ddo_office_email_id') }}" maxlength="255">
                                <span class="text-danger" id="ddo_office_email_idError"></span>
                            </div>
                            @error('ddo_office_email_id')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="districtname" class="col-sm-6 control-label">District Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="districtname" name="districtname" placeholder="Enter District Name" value="{{ old('districtname') }}" maxlength="255">
                                <span class="text-danger" id="districtnameError"></span>
                            </div>
                            @error('districtname')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cardex_no" class="col-sm-6 control-label">Cardex No</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="cardex_no" name="cardex_no" placeholder="Enter Cardex No" value="{{ old('cardex_no') }}" maxlength="50">
                                <span class="text-danger" id="cardex_noError"></span>
                            </div>
                            @error('cardex_no')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
								<label for="ddocode" class="col-sm-6 control-label">DDO Code</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="ddocode" name="ddocode" placeholder="Enter DDO Code" value="{{ old('ddocode') }}" maxlength="4">
                                <span class="text-danger" id="ddocodeError"></span>
                            </div>
                            @error('ddoofficename')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>			

                        

						  <!-- <div class="form-group">
                            <label for="dto_registration_no" class="col-sm-6 control-label">DTO Registration No</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="dto_registration_no" name="dto_registration_no" placeholder="Enter DTO Registration No" value="{{ old('dto_registration_no') }}" minlength="7" maxlength="7">
                                <span class="text-danger" id="dto_registration_noError"></span>
                            </div>
                            @error('dto_registration_no')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-6 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" maxlength="255">
                                <span class="text-danger" id="emailError"></span>
                            </div>
                            @error('email')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="col-sm-6 control-label">Mobile No</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile No" value="{{ old('mobile') }}" minlength="10" maxlength="10">
                                <span class="text-danger" id="mobileError"></span>
                            </div>
                            @error('mobile')
                                <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                            @enderror
                        </div>   -->

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                        </div>
                    </form>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>

@endsection

@push('page-ready-script')
@endpush

@push('footer-script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#successMessage').hide();
        $('#errorMessage').hide();

        $("#ddoForm").validate({
            rules: {
                ddocode: { required: true, digits: true, maxlength: 4 },
                ddoofficename: {
                    required: true,
                    lettersonly: true // Custom rule for letters and spaces
                },
                districtname: {
                    required: true,
                    lettersonly: true // Custom rule for letters and spaces
                },
                cardex_no: {
                    required: true,
                    digits: true // Only digits
                },
                ddo_registration_no: {
                    required: true,
                    ddoPattern: true, // Custom rule for ddo_registration_no
                    minlength: 10,
                    maxlength: 10
                },
                ddo_office_email_id: {
                    required: true,
                    validEmail: true,
                }
            },
            messages: {
                ddoofficename: {
                    required: "DDO Office name is required",
                    lettersonly: "DDO Office name must contain only letters and spaces"
                },
                districtname: {
                    required: "District name is required",
                    lettersonly: "District name must contain only letters and spaces"
                },
                cardex_no: {
                    required: "Cardex No is required",
                    digits: "Cardex No must contain only digits"
                },
                ddo_registration_no: {
                    required: "DDO Registration No is required",
                    ddoPattern: "DDO Registration No must be in the format SGV089819C (3 letters, 6 digits, 1 letter)",
                    minlength: "DDO Registration No must be exactly 10 characters long",
                    maxlength: "DDO Registration No must be exactly 10 characters long"
                },
                ddo_office_email_id: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address (e.g., example@gujarat.gov.in)"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: "{{ route('ddo.store') }}",
                    type: "POST",
                    data: $(form).serialize(),
                    success: function(data) {
                        $('#successMessage').find('#successText').html(data.success);
                        $('#successMessage').show();
                        setTimeout(function() {
                            $('#successMessage').fadeOut();
                        }, 3000);
                        $('#errorMessage').hide();
                        $(form).trigger("reset"); // Reset the form
                    },
                    error: function(xhr) {
                        $('#successMessage').hide();

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $('.text-danger').text(''); // Clear previous error messages
                            $.each(errors, function(key, value) {
                                $('#' + key + 'Error').text(value[0]);
                            });
                        } else {
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

        // Custom validation methods
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
        }, "Please enter letters only.");

        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
        }, "Please enter letters and numbers only.");

        // Custom validation method for ddo_registration_no to match SGV089819C format
        $.validator.addMethod("ddoPattern", function(value, element) {
            return this.optional(element) || /^[A-Z]{3}[0-9]{6}[A-Z]$/.test(value);
        }, "DDO Registration No must be in the format SGV089819C (3 letters, 6 digits, 1 letter).");

        $.validator.addMethod("validEmail", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._%+-]+@gujarat\.gov\.in$/.test(value);
    }, "Invalid email. Email must end with @gujarat.gov.in.");
    });
</script>

@endpush
