@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)
@section('content')

 {{-- <div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Area List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Area</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-head ">
            <div class="card-header">
                <h3 class="card-title">Edit Area</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">


                <div id="successMessage" class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span id="successText"></span>
                </div>
                <div id="errorMessage" class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span id="errorText"></span>
                </div>


                <div class="table-responsive p-4">

                    <table class="table table-bordered table-hover custom_table dataTable" id="arealist">
                        <thead>
                        </thead>
                        <tbody>
                        <form id="areaForm" name="areaForm" class="form-horizontal"
                                    action="{{ route('masterarea.store') }}" method="POST" >
                                    @csrf
                                    <input type="hidden" name="areacode" id="areacode" value="{{$area->areacode}}">
                                    <div class="form-group">
                                        <label for="areaname" class="col-sm-6 control-label">Area Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="areaname"
                                                name="areaname" placeholder="Enter Area Name" value="{{$area->areaname}}"
                                                maxlength="255" >
                                                <span class="text-danger" id="areanameError"></span>
                                        </div>
                                        @error('areaname')
                                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-6 control-label">Address</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="Enter Address" value="{{$area->address}}" maxlength="255">
                                                <span class="text-danger" id="addressError"></span>
                                        </div>
                                        @error('address')
                                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address_g" class="col-sm-6 control-label">Address Gujarati</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="address_g" name="address_g"
                                                placeholder="Enter Address Gujarati" value="{{$area->address_g}}" maxlength="255" >
                                                <span class="text-danger" id="address_gError"></span>
                                        </div>
                                        @error('address_g')
                                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" id="saveBtn"
                                            value="create">Save changes
                                        </button>
                                    </div>
                                </form>

                        </tbody>
                    </table>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Area List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Area</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card card-head">
            <div class="card-header">
                <h3 class="card-title">Edit Area</h3>
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

                <form id="areaForm" name="areaForm" class="form-horizontal" action="{{ route('masterarea.store') }}" method="POST">
                    @csrf

                        <label for="areaname" class="col-sm-6 control-label">Area Name</label>
                        <div class="col-sm-12">
                        <div class="form-group">
                            <input type="hidden" name="areacode" id="areacode" value="{{ base64_encode($area->areacode) }}"/>
                            <input type="text" class="form-control" id="areaname" name="areaname" placeholder="Enter Area Name" value="{{ $area->areaname }}" maxlength="255">
                            <span class="text-danger" id="areanameError"></span>
                        </div>
                        @error('areaname')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-6 control-label">Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="{{ $area->address }}" maxlength="255">
                            <span class="text-danger" id="addressError"></span>
                        </div>
                        @error('address')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address_g" class="col-sm-6 control-label">Address Gujarati</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="address_g" name="address_g" placeholder="Enter Address Gujarati" value="{{ $area->address_g }}" maxlength="255">
                            <span class="text-danger" id="address_gError"></span>
                        </div>
                        @error('address_g')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- /.card -->

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
                $("#areaForm").validate({
                    rules: {
                        areaname: { required: true, regex: /^[A-Za-z0-9\s]+$/, // Only letters, numbers, and spaces
                            },
                        address: { required: true,  regex: /^[A-Za-z0-9\s,.-]+$/, // Letters, numbers, spaces, and some punctuation
                            },
                        address_g: { required: true },
                    },
                    messages: {
                        areaname: { required: "Area Name is required", regex: "Only letters, numbers and spaces are allowed."},
                        address: { required: "Address is required",  regex: "Only letters, numbers, spaces, and basic punctuation are allowed.", },
                        address_g: { required: "Address in Gujarati is required" },
                    },
                    submitHandler: function(form) {
                        // Perform AJAX request on form submission
                        $.ajax({
                            url: $(form).attr('action'), // Use the form's action attribute
                            type: "POST",
                            data: $(form).serialize(),
                            success: function(data) {
                                // Show success message
                                $('#successMessage').find('#successText').html(data.success);
                                $('#successMessage').show();

                                // Hide success message after 3 seconds
                                setTimeout(function() {
                                    $('#successMessage').fadeOut();
                                }, 3000);

                                // Hide error message if shown
                                $('#errorMessage').hide();
                                $(form).trigger("reset"); // Reset the form
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
