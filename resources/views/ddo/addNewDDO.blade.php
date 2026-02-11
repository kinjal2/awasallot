@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)

@section('content')
@php $isEdit = isset($ddo); @endphp

<div class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">DDO List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $isEdit ? 'Edit DDO' : 'Add New DDO' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card card-head">
            <div class="card-header">
                <h3 class="card-title">{{ $isEdit ? 'Edit DDO' : 'Add New DDO' }}</h3>
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
             
                @if($isEdit )
                    @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button"
        class="btn-close"
        style="font-size:0.7rem"
        data-bs-dismiss="alert"
        aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
   <button type="button"
        class="btn-close"
        style="font-size:0.7rem"
        data-bs-dismiss="alert"
        aria-label="Close"></button>
</div>
@endif



                 <div class="table-responsive text-right">
                    <form id="ddoResetPwd" name="ddoResetPwd" class="form-horizontal" action="{{ route('ddo.resetpwd') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $isEdit ? $ddo->id : '' }}">
               
                     <button type="submit" class="btn btn-primary" id="resetpwd" value="resetpwd">
                               Reset Password
                            </button>
                    </form>
                </div>
                
                @endif
                <div class="table-responsive p-4">
                    <form id="ddoForm" name="ddoForm" class="form-horizontal" action="{{ route('ddo.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $isEdit ? $ddo->id : '' }}">

                        <div class="form-group">
                            <label for="ddo_registration_no">DDO Registration No</label>
                            <input type="text" class="form-control" id="ddo_registration_no" name="ddo_registration_no"
                                placeholder="Enter DDO Registration No"
                                value="{{ old('ddo_registration_no', $isEdit ? $ddo->ddo_reg_no : $ddo_code) }}"
                                readonly minlength="10" maxlength="10">
                            <span class="text-danger" id="ddo_registration_noError"></span>
                        </div>

                        <div class="form-group">
                            <label for="ddoofficename">DDO Office Name</label>
                            <input type="text" class="form-control" id="ddoofficename" name="ddoofficename"
                                value="{{ old('ddoofficename', $isEdit ? $ddo->ddo_office : '') }}" maxlength="255">
                            <span class="text-danger" id="ddoofficenameError"></span>
                        </div>

                        <div class="form-group">
                            <label for="ddo_office_email_id">DDO Office Email</label>
                            <input type="text" class="form-control" id="ddo_office_email_id" name="ddo_office_email_id"
                                value="{{ old('ddo_office_email_id', $isEdit ? $ddo->ddo_office_email_id : '') }}"
                                maxlength="255">
                            <span class="text-danger" id="ddo_office_email_idError"></span>
                        </div>

                        <div class="form-group">
                            <label for="district">District</label>
                            <select name="district" id="district" class="form-control select2">
                                <option value="">-- Select District --</option>

                                @foreach($district as $key => $dist)
                                <option value="{{ $key }}"
                                    {{ old('district', $isEdit ? $ddo->dcode : '') == $key ? 'selected' : '' }}>
                                    {{ $dist }}
                                </option>
                                @endforeach
                            </select>

                            <input type="hidden" name="districtname" id="districtname"
                                value="{{ old('districtname', $isEdit ? $ddo->district : '') }}">
                            <span class="text-danger" id="districtError"></span>
                        </div>

                        <div class="form-group">
                            <label for="cardex_no">Cardex No</label>
                            <input type="text" class="form-control" id="cardex_no" name="cardex_no"
                                value="{{ old('cardex_no', $isEdit ? $ddo->cardex_no : '') }}" maxlength="50">
                            <span class="text-danger" id="cardex_noError"></span>
                        </div>

                        <div class="form-group">
                            <label for="ddocode">DDO Code</label>
                            <input type="text" class="form-control" id="ddocode" name="ddocode"
                                value="{{ old('ddocode', $isEdit ? $ddo->ddo_code : '') }}" maxlength="4">
                            <span class="text-danger" id="ddocodeError"></span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="saveBtn">
                                {{ $isEdit ? 'Update' : 'Save changes' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#district').on('change', function() {
            let selected = $(this).find('option:selected');
            $('#districtname').val(selected.data('name') || '');
        });
        $('#district').trigger('change');

        $("#ddoForm").validate({
            rules: {
                ddocode: {
                    required: true,
                    digits: true,
                    maxlength: 4
                },
                ddoofficename: {
                    required: true,
                    lettersonly: true
                },
                districtname: {
                    required: true,
                    lettersonly: true
                },
                cardex_no: {
                    required: true,
                    digits: true
                },
                ddo_registration_no: {
                    required: true,
                    ddoPattern: true,
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
                    lettersonly: "Only letters and spaces allowed"
                },
                districtname: {
                    required: "District name is required",
                    lettersonly: "Only letters and spaces allowed"
                },
                cardex_no: {
                    required: "Cardex No is required",
                    digits: "Only digits allowed"
                },
                ddo_registration_no: {
                    required: "DDO Reg No required",
                    ddoPattern: "Format must be SGV/OTH + 6 digits + 1 letter",
                    minlength: "Must be 10 characters",
                    maxlength: "Must be 10 characters"
                },
                ddo_office_email_id: {
                    required: "Email is required",
                    validEmail: "Only @gujarat.gov.in emails allowed"
                }
            },
            submitHandler: function(form) {
                var isEdit = {
                    {
                        $isEdit ? 'true' : 'false'
                    }
                };
                var url = $(form).attr('action');
                var method = 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(form).serialize(),
                    success: function(data) {
                        if (data.success) {
                            $('#successMessage').show();
                            $('#successText').html(data.message);
                            $('#errorMessage').hide();

                            if (!isEdit) {
                                $('#ddoForm')[0].reset();
                                $('#district').val('').trigger('change');
                            }

                            // ✅ Redirect after short delay
                            setTimeout(function() {
                                window.location.href = "{{ route('ddo.list') }}";
                            }, 1500); // 1.5 seconds delay for user to see message

                        } else {
                            $('#errorMessage').show();
                            $('#errorText').html(data.message);
                            $('#successMessage').hide();
                        }
                    },
                    error: function(xhr) {
                        let errMsg = "Something went wrong.";
                        if (xhr.responseJSON?.errors) {
                            errMsg = Object.values(xhr.responseJSON.errors).map(arr => arr.join('<br>')).join('<br>');
                        }
                        $('#errorMessage').show();
                        $('#errorText').html(errMsg);
                        $('#successMessage').hide();
                    }
                });
            }
        });

        $.validator.addMethod("ddoPattern", function(value, element) {
            return /^[A-Z]{3}\d{6}[A-Z]$/.test(value);
        }, "Invalid DDO Registration No format.");

        $.validator.addMethod("lettersonly", function(value, element) {
            return /^[a-zA-Z\s]+$/.test(value);
        }, "Only letters and spaces allowed.");

        $.validator.addMethod("validEmail", function(value, element) {
            //return /^[a-zA-Z0-9._%+-]+@gujarat\.gov\.in$/.test(value);
            return /^[a-zA-Z0-9._%+-]+@(gujarat\.gov\.in|gsrtc\.org)$/.test(value);
        }, "Only @gujarat.gov.in emails allowed.");
    });
</script>
<script>
    $('#ddoResetPwd').on('submit', function () {
    return confirm('Are you sure you want to reset the password?');
});
</script>
@endpush