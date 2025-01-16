@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)
@section('content')

<div class="content">
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
                        <li class="breadcrumb-item active">Add New Area</li>
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
                <h3 class="card-title">Add New Area</h3>
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
                                    <div class="form-group">
                                        <label for="areaname" class="col-sm-6 control-label">Area Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="areaname"
                                                name="areaname" placeholder="Enter Area Name" value="{{ old('areaname') }}"
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
                                                placeholder="Enter Address" value="{{ old('address') }}" maxlength="255">
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
                                                placeholder="Enter Address Gujarati" value="{{ old('address_g') }}" maxlength="255" >
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
        <!-- /.card -->

        @endsection
        @push('page-ready-script')
        @endpush
        @push('footer-script')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
        <script type="text/javascript">

            $(document).ready(function() {
                $('#successMessage').hide();
                $('#errorMessage').hide();
                $("#areaForm").validate({
                    rules: {
                        areaname: {
                            required: true,
                          //  regex: /^[A-Za-z\s]+$/, // Only letters and spaces
                        },
                        address: {
                            required: true,
                            //regex: /^[A-Za-z0-9\s,.-]+$/, // Letters, numbers, spaces, and some punctuation
                        },
                        address_g: {
                            required: true,
                        },
                        // Add more validation rules for other fields here
                    },
                    messages: {
                        areaname: {
                            required: "Areaaaa Name is required",
                            //regex: "Only letters and spaces are allowed.",
                            //maxlength: "Area Name must not exceed 100 characters"
                        },
                        address: {
                            required: "Address is required",
                            //regex: "Only letters, numbers, spaces, and basic punctuation are allowed.",
                            //maxlength: "Address must not exceed 100 characters"
                        },
                        address_g: {
                            required: "Address in Gujarati is required",
                            //maxlength: "Address in Gujarati must not exceed 100 characters"
                        },
                        // Add more messages for other fields here
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: "{{ route('masterarea.store') }}",
                            type: "POST",
                            data: $(form).serialize(),
                            success: function(data) {
                                /*alert(data.success);
                                window.location.href="{{ route('masterarea.index')}}"*/
                               $('#successMessage').find('#successText').html(data.success);
                                $('#successMessage').show();
                                // Hide the success message after 3 seconds
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
                                    //$('#errorMessage').text('Something went wrong!').show();
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
