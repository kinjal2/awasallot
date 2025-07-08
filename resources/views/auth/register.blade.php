<!DOCTYPE html>
<html>
@include(Config::get('app.theme').'.template.header_front_page')

<div class="container">
    <div class="row justify-content-center padd-y-50">
        <div class="col-md-8 mx-auto">
            <div class="card box-design">
                <!-- <div class="card-header login-head">{{ __('Login') }}</div> -->
                <div class=" login-head text-center  ">
                    <p class="login-icon py-2">{{ __('New User Registration') }}</p>
                    <h4 class="m-0"><b>E-state Managment System</b></h4>
                    <p class="sub-title-form">Goverment of Gujarat</p>
                </div>


                <div class="card-body bg-lightwhite p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ url('/register') }}" id="registrationForm" name="registrationForm">
                        @csrf
                    <div class="row">
                        <div class="col-12 form-group relative mb-3">
                        <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}&nbsp;<span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-2">
                                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                                <input id="surname" type="text" class="custon-control  custon-control form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" placeholder="Surname">
                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <input id="first_name" type="text" class="custon-control  custon-control form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="First Name">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <input id="last_name" type="text" class="custon-control  custon-control form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" placeholder="Last Name">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        </div>

                        <div class="col-6 form-group relative mb-3">
                        <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('Birth Date') }}&nbsp;<span class="text-danger">*</span></label>
                        <input id="birthdate" type="text" class=" custon-control form-control dateformat  @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') }}" required   readonly autofocus>
                        <i class="bi bi-cake2 form-icon"></i>
                        @error('birthdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="col-6 form-group relative mb-3">
                        <label for="designation" class="col-md-4 col-form-label text-md-right">{{ __('Designation') }}&nbsp;<span class="text-danger">*</span></label>
                        <input id="designation" type="text" class=" custon-control form-control @error('designation') is-invalid @enderror" name="designation" value="{{ old('designation') }}" required  autofocus>
                        <i class="bi bi-person-gear form-icon"></i>
                        @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="col-6 form-group relative mb-3">
                        <label for="officename" class="col-md-4 col-form-label text-md-right" style="width:50%;" >{{ __('Full Office Name') }}&nbsp;<span class="text-danger">*</span></label>
                        <input id="officename" type="text" class=" custon-control form-control @error('officename') is-invalid @enderror" name="officename" value="{{ old('officename') }}" required  autofocus>
                                @error('officename')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="col-6 form-group relative mb-3">
                        <label for="contact_no" class="col-md-4 col-form-label text-md-right" style="width:50%;">{{ __('Personal Mobile No') }}&nbsp;<span class="text-danger">*</span></label>
                        <input id="contact_no" type="text" class=" custon-control form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" required minlength='10'
                    maxlength='10'  autofocus>
                    <i class="bi bi-phone form-icon"></i>
                                @error('contact_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>


                        <div class="col-6 form-group relative mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-right" style="width:50%;">{{ __('Personal E-Mail Address') }}&nbsp;<span class="text-danger">*</span></label>
                        <input id="email" type="email" class=" custon-control form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <i class="bi bi-envelope form-icon"></i>
                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <!-- <div class="col-6 form-group relative mb-3">
                        <label for="ddo_no" class="col-md-4 col-form-label text-md-right">{{ __('DDO No') }}</label>
                        <input id="ddo_no" type="text" class=" custon-control form-control @error('ddo_no') is-invalid @enderror" name="ddo_no"  value="{{ old('ddo_no') }}" required  autofocus>
                    <i class="bi bi-phone form-icon"></i>
                                @error('ddo_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div> -->
                          <div class="col-6 form-group relative mb-3">
                                <label for="district" class="col-md-4 col-form-label text-md-right">District&nbsp;<span class="text-danger">*</span></label>
                                <select name="district" id="district" class="custon-control form-control select2">
                                    <option value="">{{ __('common.select') }}</option>
                                    @foreach (getDistricts() as $key => $value)
                                        <option value="{{ $key }}" {{ old('district') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('district')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                            <div class="col-6 form-group relative mb-3">
                                <label for="taluka" class="col-md-4 col-form-label text-md-right">Taluka&nbsp;<span class="text-danger">*</span></label>
                                <x-select 
                                    name="taluka"
                                    :options="['' => __('common.select')] + getTaluka()"
                                    :selected="''"
                                    class="custon-control form-control select2"
                                    id="taluka"
                                />



                                @error('taluka')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                       
                        <div class="col-6 form-group relative mb-3">
                        <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label>
                        <div class='captcha m-0'> <span>{!! captcha_img() !!}  </span>
                                <button type="button" class="btn btn-secondary" id="reload">
                                    &#x21bb;
                                </button>
                        </div>
                        </div>


                        <div class="col-md-6 form-group relative my-3">
                        <label for="captcha" class="col-form-label text-md-right">Enter Captcha Here&nbsp;<span class="text-danger">*</span></label>

                        <input type="text" class=" custon-control form-control" id="captcha" name="captcha" placeholder="Enter Captcha" required>

                        </div>

                <div class="form-group  my-3">

                                <button type="submit" class=" btn btn-primary">
                                    {{ __('Register') }}
                                </button><br><br>
                                <span class="text-danger">તમે હાલમાં જે કચેરીમાં ફરજ બજાવો છો તે કચેરી જે તાલુકા/જિલ્લા મા આવતી હોય તે મુજબ ફરજીયાત પસંદ કરવાનુ રહેશે.</span><br>
                                <span class="text-danger">Fields marked with *  are mandatory to fill. </span>
                                <input id="name" type="hidden" class="custon-control  custon-control form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Name">

                        </div>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include(Config::get('app.theme').'.template.footer_front_page')
<script>

    // jQuery code
    $(document).ready(function() {


        $('input.dateformat').datetimepicker({
            format: 'd-m-Y',
            timepicker: false
        });
        $('#registrationForm').on('submit', function (e) {
        var firstName = $('#first_name').val();
        var lastName = $('#last_name').val();
        var surname = $('#surname').val();
        var fullName = firstName + " " + lastName + " " + surname;

        $('#name').val(fullName);


    });
    // 20/03/2025
        $('#registrationForm').validate({
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
            /*    name: {
                    required: true
                },*/
                birthdate: {
                    required: true
                },
                designation: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/ // Allows only letters and spaces
                },
                officename: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/ // Allows only letters and spaces
                },
                /*ddo_no: {
                    required: true
                },*/
               /* cardex_no:{
                    required: true,
                },
                ddo_code:{
                    required: true,
                },*/
                contact_no: {
                    required: true,
                    digits: true,
                    minlength:10,
                    maxlength:10

                },
                 district: {
                    required: true,
                },
                taluka: {
                    required: true,
                },

                // Add rules for other fields here
            },
            messages: {
                designation: {
                    required: "Please enter your designation",
                    pattern: "Please enter a valid designation (only letters and spaces)"
                },
                officename: {
                    required: "Please enter your office name",
                    pattern: "Please enter a valid office name (only letters and spaces)"
                },
               /* name: {
                    required: "Please enter your name"
                },*/
                /*birthdate: {
                    required: "Please enter birthdate"
                },*/
                // Add custom messages for other fields here
            },
            submitHandler: function(form) {
                $('input, textarea').each(function() {
                    var value = $(this).val();
                    var sanitizedValue = value.replace(/<[^>]*>/g, ''); // Remove HTML tags
                    $(this).val(sanitizedValue); // Update the field with sanitized value
                });
                form.submit();
            }
        });
      
        });

     $('#district').on('change', function() {
    var dcode = $(this).val(); // Get the selected district code
    var csrfToken = $('#registrationForm input[name="_token"]').val();

    if (dcode) {
        $.ajax({
            url: "{{ route('getTalukaByDistrict') }}", // Your route to fetch talukas based on dcode
            type: 'POST',
            data: {
                dcode: dcode,
              
            },
            success: function(data) {
                //dd(data);
                talukaSelect = $('#taluka');
                talukaSelect.empty(); // Clear previous taluka options
                talukaSelect.append('<option value="">{{ __("common.select") }}</option>'); // Add the default "select" option

                if (data.length > 0) {
                    data.forEach(function(item) {
                        talukaSelect.append(`<option value="${item.tcode}">${item.name_e} [ ${item.name_g} ]</option>`);
                    });
                } else {
                    alert('No talukas found for this district.');
                }
            },
            error: function(xhr) {
                console.error('Error fetching talukas:', xhr.responseText);
                if (xhr.status === 401) {
                    alert('You are not authenticated. Please log in.');
                    window.location.href = '/login'; // Redirect to login if needed
                }
            }
        });
    } else {
        $('#taluka').empty().append("<option value=''>{{ __('common.select') }}</option>"); // Clear taluka options if no district selected
    }
});
</script>




