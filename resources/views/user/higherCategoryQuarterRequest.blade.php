@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1 class="m-0 text-dark">Higher Quarter Request</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Higher Quarter Request</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
   @if(session('active_tab'))
    {{ session('active_tab') }}
@endif

  {{ $isEdit }}
    @if( $isEdit == 1)
        <!-- Nav tabs -->
        <ul class="nav nav-tabs " id="quarterTabs" role="tablist" >
       
           @if( ($quarterequestb['app_ddo']==1) || ($quarterequestb['app_admin']==1) )
            <li class="nav-item" role="presentation">
                <button class="nav-link   {{ session('active_tab') != 'tab2' || session('active_tab') != 'tab3' ? 'active' : '' }}"
                        id="request-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#request"
                        type="button"
                        role="tab"
                        aria-controls="request"
                        aria-selected="true">
                    User Details
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link  {{ session('active_tab') == 'tab2' ? 'active' : '' }}"
                        id="history-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#history"
                        type="button"
                        role="tab"
                        aria-controls="history"
                        aria-selected="false">
                 Higher Category Request Form
                </button>
            </li>
            @endif 
             @if(count($document_list) > 0)
            <li class="nav-item" role="presentation">
                <button class="nav-link  {{ session('active_tab') == 'tab3' ? 'active' : '' }}"
                        id="upload-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#upload"
                        type="button"
                        role="tab"
                        aria-controls="upload"
                        aria-selected="false">
               Document Attachment
                </button>
            </li>
            @endif
        </ul>

        <!-- Tab content -->
        <div class="tab-content mt-3" id="quarterTabContent">
             @if( ($quarterequestb['app_ddo']==1) || ( $quarterequestb['app_admin']==1))
            <div class="tab-pane fade {{ session('active_tab') != 'tab2' || session('active_tab') != 'tab3' ? 'show active' : '' }}"
                 id="request"
                 role="tabpanel"
                 aria-labelledby="request-tab">
                @include('user.userprofile_tabview')
            </div>
            <div class="tab-pane fade {{ session('active_tab') == 'tab2' ? 'show active' : '' }}"
                 id="history"
                 role="tabpanel"
                 aria-labelledby="history-tab">
                @include('user.higherqueter_tabview')
            </div>
            @endif
           
             @if(count($document_list) > 0)
            <div class="tab-pane fade  show {{ session('active_tab') == 'tab3' ? 'show active' : '' }}"
                 id="upload"
                 role="tabpanel"
                 aria-labelledby="upload-tab">
                @include('user.documentupload_tabview')
                
            </div>
            @endif
        </div>
    @else
        {{-- If not edit mode, just show the Request Form directly --}}
        @include('user.higherqueter_tabview')
    @endif

</div>

@endsection

@push('page-ready-script')
@endpush

@push('footer-script')
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script>
 $(document).ready(function () {
        $('.disabled-tab').on('click', function (e) {
            e.preventDefault();            // Prevent link action
            e.stopImmediatePropagation();  // Stop Bootstrap tab switch
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $('.dateformat').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    });
    
   
    $(document).ready(function() {
        updateChoiceOptions();
        // Function to toggle the visibility
        function toggleHcQuarterSection() {
            const selectedValue = $('input[name=have_hc_quarter_yn]:checked').val();
            if (selectedValue === 'Y') {
                $('.have_hc_quarter').show();
            } else {
                $('.have_hc_quarter').hide();
            }
        }

        // Initial check on page load
        toggleHcQuarterSection();

        // Check again when user changes selection
        $('input[name=have_hc_quarter_yn][type=radio]').change(function() {
            toggleHcQuarterSection();
        });
        // $('.have_hc_quarter').hide();
        // $('input[name=have_hc_quarter_yn][type=radio]').change(function() {
        //     if (this.value == 'Y') {
        //         $('.have_hc_quarter').show();
        //     }
        //     else if (this.value == 'N') {
        //         $('.have_hc_quarter').hide();
        //     }
        // });
        jQuery.validator.addMethod("cdate",
            function(value, element) {
                return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
            },
            "Please specify the date in DD-MM-YYYY format"
        );

        $("#annexurea").validate({
            rules: {

                quartertype: "required",
                prv_quarter_type: "required",
                prv_area: "required",
                prv_blockno: {
                    required: true,
                    number: true
                },
                prv_unitno: {
                    required: true,
                    number: true
                },
                prv_allotment_details: "required",
                prv_possession_date: {
                    required: true,
                    cdate: true
                },
                have_hc_quarter_yn: "required",
                hc_quarter_type: "required",
                hc_area: "required",
                hc_blockno: {
                    required: true,
                    number: true
                },
                hc_unitno: {
                    required: true,
                    number: true
                },
                hc_allotment_details: "required",
                agree_rules: "required",
                declaration: "required",
            }
        });
        $("#cardexForm").validate({
            rules: {

                cardex_no: "required",
                ddo_code: "required",

            },
            messages: {
                cardex_no: {
                    required: "Please enter a Cardex Number"
                },
                ddo_code: {
                    required: "Please select a DDO Code"
                }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function(error, element) {
                error.appendTo(element.closest('.form-group'));
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            }
        });
    });
    $('#cardex_no').on('blur', function() {
        var cardexNo = $(this).val();
        var csrfToken = $('#cardexForm input[name="_token"]').val();

        if (cardexNo) {
            $.ajax({
                url: "{{ route('ddo.getDDOCode') }}", // Your route to fetch data
                type: 'POST', // Change to POST
                data: {
                    cardex_no: cardexNo,
                    _token: csrfToken // Include CSRF token here
                },
                success: function(data) { //alert(data);
                    //  console.log(data);  // Check the actual response data from the server
                    const ddo_code = $('#ddo_code');
                    ddo_code.empty();

                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(function(item) {
                            ddo_code.append(`<option value="${item.ddo_code}">${item.ddo_office} [ Code - ${item.ddo_code} ]</option>`);
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
        } else {
            // $('#ddo_code').hide(); // Hide dropdown if input is empty
        }
    });

    function updateChoiceOptions() {
        // Get the selected values for Choice 1 and Choice 2
        var choice1Value = $('#choice1').val();
        var choice2Value = $('#choice2').val();
        var choice3Value = $('#choice3').val();

        // Get all options for Choice 2 and Choice 3
        var choice1Options = $('#choice1 option');
        var choice2Options = $('#choice2 option');
        var choice3Options = $('#choice3 option');

        // Enable all options initially for both Choice 2 and Choice 3
        choice1Options.prop('disabled', false);
        choice2Options.prop('disabled', false);
        choice3Options.prop('disabled', false);

        choice1Options.each(function() {
            var optionValue = $(this).val();
            if (optionValue === choice2Value || optionValue === choice3Value) {
                $(this).prop('disabled', true); // Disable this option
            }
        });
        // Disable the option in Choice 2 that matches the selected value in Choice 1
        choice2Options.each(function() {
            var optionValue = $(this).val();
            if (optionValue === choice1Value || optionValue === choice3Value) {
                $(this).prop('disabled', true); // Disable this option
            }
        });

        // Disable the options in Choice 3 that match the selected values in Choice 1 or Choice 2
        choice3Options.each(function() {
            var optionValue = $(this).val();
            if (optionValue === choice1Value || optionValue === choice2Value) {
                $(this).prop('disabled', true); // Disable this option
            }
        });
    }
</script>
<script type="text/javascript">
   $(function() {
      $('#is_phy_dis').trigger('change');
      // Bootstrap DateTimePicker v4
      $('.dateformat').datetimepicker({
         format: 'DD-MM-YYYY'
      });
   });
   $('.numeric').keypress(function(event) {
      return numF(event);
   });
   $('.alfanumaric').keypress(function(event) {
      return anFS(event);
   });
   $("#frm").submit(function(event) {
      //var str=$("#pancard").val();

      //	$('#pancard').val(window.btoa(str));
   });

   $.validator.addMethod(
      "indianDate",
      function(value, element) {
         // put your own logic here, this is just a (crappy) example
         return value.match(/^\d\d?-\d\d?-\d\d\d\d$/);
      },
      "Please enter a date in the format dd-mm-yyyy."
   );
   $.validator.addMethod("alphanum", function(value, element) {
      return this.optional(element) || /^[a-z0-9\s]+$/i.test(value);
   }, "Only letters, numbers and space allowed.");

   $.validator.addMethod("alnum", function(value, element) {
      return this.optional(element) || /^[a-z0-9]+$/i.test(value);
   }, "Only letters, numbers allowed.");

   $.validator.addMethod("pan", function(value, element) {
      return this.optional(element) || /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/.test(value);
   }, "Invalid PAN No.");
   $.validator.addMethod("validExt", function(value, element) {
      if (this.optional(element))
         return true;
      else {
         var arr = value.split(".");
         var ret = true;
         if (arr.length > 2) {
            ret = false;
         }
         if (/^[a-z0-9.\s]+$/i.test(value) == false) {
            ret = false;
         }
         return ret;
      }
   }, "File name should not contain special characters or more than one dots.");
   $.validator.addMethod("validEmail", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._%+-]+@gujarat\.gov\.in$/.test(value);
}, "Invalid email. Email must end with @gujarat.gov.in.");

   // Add custom validation method for salary range - 8-1-2025
   // Custom validator for salary range
      $.validator.addMethod("salaryRange", function(value, element) {
         const slab = $("#salary_slab").val(); // e.g. "25500-81100" or "25500-above"

         if (!slab || !value) return true; // Skip if empty

         const parts = slab.split("-");
         const minSalary = parseInt(parts[0], 10);
         const maxPart = parts[1].trim().toLowerCase();

         if (maxPart === 'above') {
            return value >= minSalary;
         } else {
            const maxSalary = parseInt(maxPart, 10);
            return value >= minSalary && value <= maxSalary;
         }
      }, "Basic pay must be within the salary slab range.");

   // Add custom validation method for basic pay (must be less than actual salary)
   $.validator.addMethod("lessThanActualSalary", function(value, element, params) {
                const actualSalary = parseFloat($("#actual_salary").val());
                const basicPay = parseFloat(value);
                return this.optional(element) || basicPay < actualSalary;
            }, "Basic pay must be less than gross salary.");
         
   $("#frm").validate({
      rules: {
         "maratial_status": "required",
         "office": "required",
         "is_dept_head": "required",
         "is_judge":"required",
         "is_phy_dis":"required",
         "is_transferable": "required",
         "office_email_id": {
            "required": true,
            "validEmail": true,
         },
         is_police_staff: {
            "required": true,
           
         },
         is_fix_pay_staff:{
         "required": true,
         },
         "appointment_date": {
            "required": true,
            "indianDate": true
         },
         "date_of_retirement": {
            "required": true,
            "indianDate": true
         },
         "salary_slab": "required",
         "grade_pay": {
            "required": true,
            /*"digits": true*/
         },
         "actual_salary": {
            "required": true,
            "number": true,
            
         },
         "basic_pay": {
            "required": true,
            "number": true,
            "lessThanActualSalary": true, // Ensure basic pay is less than actual salary
            "salaryRange": true,
         },
         "personal_salary": {
            "required": true,
            "number": true
         },
         "special_salary": {
            "required": true,
            "number": true
         },
         "deputation_allowence": {
            "required": true,
            "number": true
         },
         "address": {
            "required": true,
            "alphanum": true
         },
         "current_address": {
            "required": true,
            "alphanum": true
         },
         "office_address": {
            "required": true,
            "alphanum": true
         },
         "office_phone": {
            "required": true,
            "digits": true
         },
         "gpfnumber": {
            "alnum": true
         },
         "pancard": {
            "pan": true
         },
         "dis_per": {
            "number": true,
            "max": 100, // Validate that it's not more than 100
            "min": 0,
         },
         "dis_certi": {
            extension: "pdf",
            accept: "application/pdf",
            "validExt": true
         }
         //  "image":{extension: "jpg|jpeg",accept:"image/jpeg|image/pjpeg","validExt":true}
      }
   });




   function readURL(input) {
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
         }
         reader.readAsDataURL(input.files[0]);
      }
   }
   $("#imageUpload").change(function() {
      readURL(this);
   });
   $('#is_phy_dis').change(function() {
      var value = $(this).val();
      var div = document.getElementById('dis_per_yes');
      //var div1 = document.getElementById('dis_per_certi_yes');
      if (value == 'Y') {
         div.style.display = 'block';
      } else {
         div.style.display = 'none';
        // div1.style.display = 'none';
      }
   });

   $('#dis_per').change(function() {
      var value = $(this).val();
      var div = document.getElementById('dis_per_certi_yes');
      if (value >= 60) {
         div.style.display = 'block';
      } else {
         div.style.display = 'none';
      }
   });
   


   //code for physical disablity certificate 9-11-2024
   $('.open-document-btn').on('click', function(e) {
      e.preventDefault();
      let docId = $(this).attr('data-id');
      // let url = '/get-document-url'; // URL of the Laravel route to get the document URL

      $.ajax({
         url: "{{ url('get-document-url') }}",
         type: 'POST',
         data: {
            doc_id: docId,
            _token: '{{ csrf_token() }}' // Include CSRF token
         },
         success: function(response) {
            if (response.status === 'success') {
               // Open the document in a new tab
               //window.open(response.document_url, '_blank');
               const byteCharacters = atob(response.document_url);
               const byteNumbers = new Uint8Array(byteCharacters.length);

               for (let i = 0; i < byteCharacters.length; i++) {
                  byteNumbers[i] = byteCharacters.charCodeAt(i);
               }

               const blob = new Blob([byteNumbers], {
                  type: response.contentType
               });

               // Create a URL for the Blob and open it in a new window
               const blobUrl = URL.createObjectURL(blob);
               window.open(blobUrl, '_blank');
            } else {
               console.error('Failed to fetch PDF:', data.error);
            }


         },
         error: function(xhr) {
            console.error(xhr.responseText);
         }
      });
   });


   $('#grade_pay').on('change', function() {
      var payLevel = $(this).val(); // Get selected pay level

      if (payLevel) {
         // Send AJAX request to fetch salary slab details
         $.ajax({
            url: "{{ route('salarySlabDetails') }}", // Your route URL for fetching details
            method: 'POST',
            data: {
               pay_level: payLevel
            },
            success: function(response) {

               // Assuming the response is in JSON format, with 'salarySlab' object
               var salarySlab = response.salarySlab; // Extract the salarySlab object

               if (salarySlab) {
                  // Create the salary range content
                  
                  if(salarySlab.payscale_to==null)
                  {
                     salarySlab.payscale_to='above';
                  }
                  var salaryRange = salarySlab.payscale_from+" - "+salarySlab.payscale_to ;

                  // Set the value of the readonly input field with the salary range
                  $('#salary_slab').val(salaryRange);
               } else {
                  // If no salary slab details are found
                  $('#salary_slab_details').html('<p>No salary slab details available for this pay level.</p>');
               }
            },
            error: function(xhr, status, error) {
               console.log('Error fetching data:', error);
            }
         });
      } else {
         // Clear the details if no pay level is selected
         $('#salary_slab_details').html('');
      }
   });

    // JavaScript to display the selected file name
    document.getElementById('image').addEventListener('change', function(event) {
        var fileName = event.target.files[0]?.name;
        var fileNameDisplay = document.getElementById('fileNameDisplay');
        
        // Show the file name, or display a default message
        if (fileName) {
            fileNameDisplay.textContent = "Selected file to upload: " + fileName;
        } else {
            fileNameDisplay.textContent = "";
        }
    });

</script>





@endpush