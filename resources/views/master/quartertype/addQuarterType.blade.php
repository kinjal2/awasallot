@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)
@section('content')
<div class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Quarter Type</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Quarter Type</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card card-head">
            <div class="card-header">
                <h3 class="card-title">Add Quarter Type</h3>
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

                <form id="quartertypeForm" name="quartertypeForm" class="form-horizontal" action="{{-- route('masterquartertype.storenew') --}}" method="POST">
                    @csrf

                    <label for="quartertype" class="col-sm-6 control-label">Quarter Type</label>
                    <div class="col-sm-12">
                        <div class="form-group">
                            
                            <input type="text" class="form-control" id="quartertype"  name="quartertype" placeholder="Enter Quarter Type" value="{{ old('quartertype') }}" maxlength="255" >
                            <span class="text-danger" id="quartertypeError"></span>
                        </div>
                        @error('quartertype')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quartertype_g" class="col-sm-6 control-label">Quarter Type Gujarati</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="quartertype_g" name="quartertype_g" placeholder=" Enter Quarter Type Gujarati" value="{{ old('quartertype_g') }}" maxlength="255">
                            <span class="text-danger" id="quartertype_gError"></span>
                        </div>
                        @error('quartertype_g')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bpay_from" class="col-sm-6 control-label">Basic Pay From</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="bpay_from" name="bpay_from" placeholder="Enter Basic Pay From" value="{{ old('bpay_from') }}" maxlength="255">
                            <span class="text-danger" id="bpay_fromError"></span>
                        </div>
                        @error('bpay_from')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bpay_to" class="col-sm-6 control-label">Basic Pay To</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="bpay_to" name="bpay_to" placeholder="Enter Basic Pay From" value="{{ old('bpay_to') }}" maxlength="255">
                            <span class="text-danger" id="bpay_toError"></span>
                        </div>
                        @error('bpay_from')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="rent_normal" class="col-sm-6 control-label">Normal Rent</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="rent_normal" name="rent_normal" placeholder="Enter Basic Pay From" value="{{ old('rent_normal') }}" maxlength="255">
                            <span class="text-danger" id="rent_normalError"></span>
                        </div>
                        @error('rent_normal')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="rent_standard" class="col-sm-6 control-label">Standard Rent</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="rent_standard" name="rent_standard" placeholder="Enter Standard Rent" value="{{ old('rent_standard') }}" maxlength="255">
                            <span class="text-danger" id="rent_standardError"></span>
                        </div>
                        @error('rent_standard')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rent_economical" class="col-sm-6 control-label">Economical Rent</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="rent_economical" name="rent_economical" placeholder="Enter Economical Rent" value="{{ old('rent_economical') }}" maxlength="255">
                            <span class="text-danger" id="rent_economicalError"></span>
                        </div>
                        @error('rent_economical')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rent_market" class="col-sm-6 control-label">Market Rent</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="rent_market" name="rent_market" placeholder="Enter Market Rent" value="{{ old('rent_market') }}" maxlength="255">
                            <span class="text-danger" id="rent_marketError"></span>
                        </div>
                        @error('rent_market')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="remarks" class="col-sm-6 control-label">Remarks</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks" maxlength="255">{{ old('remarks') }}</textarea>
                            <span class="text-danger" id="remarksError"></span>
                        </div>
                        @error('remarks')
                        <div class="col-sm-6 alert alert-dark mt-3 ml-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="priority" class="col-sm-6 control-label">Priority</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="priority" name="priority" placeholder="Enter Priority" value="{{ old('priority') }}" min="1" max="100">
                            <span class="text-danger" id="priorityError"></span>
                        </div>
                        @error('priority')
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
        $("#quartertypeForm").validate({
           /* rules: {
                areaname: {
                    required: true,
                    regex: /^[A-Za-z0-9\s]+$/, // Only letters, numbers, and spaces
                },
                address: {
                    required: true,
                    regex: /^[A-Za-z0-9\s,.-]+$/, // Letters, numbers, spaces, and some punctuation
                },
                address_g: {
                    required: true
                },
            },
            messages: {
                areaname: {
                    required: "Area Name is required",
                    regex: "Only letters, numbers and spaces are allowed."
                },
                address: {
                    required: "Address is required",
                    regex: "Only letters, numbers, spaces, and basic punctuation are allowed.",
                },
                address_g: {
                    required: "Address in Gujarati is required"
                },
            },*/
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
                       // $(form).trigger("reset"); // Reset the form
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