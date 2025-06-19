
@include(Config::get('app.theme').'.template.header_front_page')
<div class="container">
    <div class="row justify-content-center padd-y-50">
        <div class="col-md-6 mx-auto">
            <div class="card box-design">
                <div class="login-head text-center">
                    <p class="login-icon py-2">Old Profile Update</p>
                    <h4 class="m-0"><b>E-State Management System</b></h4>
                    <p class="sub-title-form">Government of Gujarat</p>
                </div>
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <div class="alert alert-danger m-3">
                    <span class="m-4">
                        <strong>તમે હાલમાં જે કચેરીમાં ફરજ બજાવો છો તે કચેરી જે તાલુકા/જિલ્લા મા આવતી હોય તે મુજબ
                            ફરજીયાત પસંદ કરવાનુ રહેશે.</strong>
                    </span>
                </div>
                <div class="card-body bg-lightwhite p-4">
                    <form method="POST" action="{{ route('user.saveoldprofiledetails') }}" id="oldProfileUpdateForm"
                        name="oldProfileUpdateForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="district"
                                        class="col-md-4 col-form-label text-md-right">District&nbsp;<span
                                            class="text-danger">*</span></label>
                                        <select name="district" id="district" class="custon-control form-control select2">
                                            <option value="">{{ __('common.select') }}</option>
                                            @foreach (getDistricts() as $key => $district)
                                                <option value="{{ $key }}" {{ old('district', '') == $key ? 'selected' : '' }}>
                                                    {{ $district }}
                                                </option>
                                            @endforeach
                                        </select>                                            
                                      @error('district')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="taluka" class="col-md-4 col-form-label text-md-right">Taluka&nbsp;<span
                                            class="text-danger">*</span></label>
                                        <select name="taluka" id="taluka" class="custon-control form-control select2">
                                            <option value="">{{ __('common.select') }}</option>
                                            @foreach (getTaluka() as $key => $taluka)
                                                <option value="{{ $key }}" {{ old('taluka', '') == $key ? 'selected' : '' }}>
                                                    {{ $taluka }}
                                                </option>
                                            @endforeach
                                        </select>                                    
                                    @error('taluka')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cardex_no"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Cardex No') }}</label>
                                   
                                    <x-select 
                           name="cardex_no"
                           :options="['null' => __('common.select')]"
                           :selected="old('cardex_no', '')"
                           class="custon-control form-control select2"
                           id="cardex_no"
                        />
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="ddo_code"
                                        class="col-md-4 col-form-label text-md-right">{{ __('DDO Code') }}</label>
                                    @if(empty($ddo_code))
                                    <select name="ddo_code" id="ddo_code" class="custon-control form-control select2">
                                        <option value="">{{ __('common.select') }}</option>
                                    </select>                                  
                                    @error('ddo_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @else
                                    <input type="text" class="form-control"
                                        value="{{ getDDO_OfficeByCode($cardex_no,$ddo_code) }}" readonly>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row relative my-4">
                                <span class="text-danger">Fields marked with * are mandatory to fill. </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <button class="btn-new btn btn-primary btn-md" type="submit">{{ __('Save') }}</button>
                                
                            </div>
                        </form>     
                   
                </div>
                
            </div>
            
        </div>
    </div>
</div>
</div>
@include(Config::get('app.theme').'.template.footer_front_page')

<script>
$(document).ready(function() {
    $('#oldProfileUpdateForm').validate({
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
            district: {
                required: true,
                //    pattern: /^SGV\d{6}[A-Z]$/ // Regex for DDO Registration Number format
            },
            taluka: {
                required: true
            },
            // captcha: {
            //     required: true
            // }
        },
        messages: {
            district: {
                required: "Please Select District",
                //  pattern: "Please enter a valid DDO Registration Number (e.g., SGV089757D)"
            },
            taluka: {
                required: "Please Select Taluka"
            },
            // captcha: {
            //     required: "Please enter the captcha"
            // }
        }
    });
});
$('#district').on('change', function() {
    var dcode = $(this).val(); // Get the selected district code
    var csrfToken = $('#oldProfileUpdateForm input[name="_token"]').val();

    if (dcode) {
        $.ajax({
            url: "{{ route('getTalukasByDistrict') }}", // Your route to fetch talukas based on dcode
            type: 'POST',
            data: {
                dcode: dcode,

            },
            success: function(data) {
                //dd(data);
                talukaSelect = $('#taluka');
                talukaSelect.empty(); // Clear previous taluka options
                talukaSelect.append(
                '<option value="">{{ __("common.select") }}</option>'); // Add the default "select" option

                if (data.length > 0) {
                    data.forEach(function(item) {
                        talukaSelect.append(
                            `<option value="${item.tcode}">${item.name_e} [ ${item.name_g} ]</option>`
                            );
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

         $.ajax({
            url: "{{ route('ddo.getCardexNo') }}",
            type: 'POST',
            data: {
                dcode: dcode,
                _token: csrfToken
            },
            success: function(data) {
                //console.log(data);
                const cardex_no = $('#cardex_no');
                cardex_no.empty();

                if (Array.isArray(data) && data.length > 0) {
            cardex_no.append(`<option value="">-- Select Cardex --</option>`);
            data.forEach(function(item) {
                cardex_no.append(
                    `<option value="${item}">${item}</option>`
                );
            });
        } else {
            alert('Invalid Data.');
        }
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr.responseText);
                if (xhr.status === 401) {
                    alert('You are not authenticated. Please log in.');
                    window.location.href = '/login';
                }
            }
        });
    } else {
        $('#taluka').empty().append(
        "<option value=''>{{ __('common.select') }}</option>"); // Clear taluka options if no district selected
    }
});
  $('#cardex_no').on('change', function() {
    var cardexNo = $(this).val();
     var dcode = $('#district').val(); // Get the fixed value
    var csrfToken = $('#cardexForm input[name="_token"]').val();

    if (cardexNo) {
        $.ajax({
            url: "{{ route('ddo.getDDOCode') }}", // Your route to fetch data
            type: 'POST', // Change to POST
            data: {
                 dcode: dcode,
                cardex_no: cardexNo,
                _token: csrfToken // Include CSRF token here
            },
            success: function(data) { //alert(data);
              //  console.log(data); // Check the actual response data from the server
                const ddo_code = $('#ddo_code');
                ddo_code.empty();

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(function(item) {
                        ddo_code.append(
                            `<option value="${item.ddo_code}">${item.ddo_office} [ Code - ${item.ddo_code} ]</option>`
                            );
                    });
                } else {
                    alert('Invalid Cardex No.');
                }
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr.responseText);
                if (xhr.status === 401) {
                    // Handle unauthenticated
                    alert('You are not authenticated. Please log in.');
                    window.location.href = '/login'; // Adjust to your login route
                }
            }
        });
    }
});
</script>