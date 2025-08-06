 @include(Config::get('app.theme').'.template.severside_message')
 @include(Config::get('app.theme').'.template.validation_errors')
 <!-- /.card-header -->
 <!-- form start --> 
  
   
      
 <form method="POST" action="{{ url('profiledetails') }}" enctype="multipart/form-data" name='frm' id="frm">
    @csrf

    @isset($isEdit)
      @if($isEdit == 1)
         <input type="hidden" value="request_form" name="request_form" id="request_form">
         <input type="hidden" name="requestid" id="request_id" value="{{ $request_id }}">
         <input type="hidden" name="rev" id="rev" value="{{ $rev }}">
         <input type="hidden" name="type" id="type" value="{{ $type }}">
         <input type="hidden" name="edit_type" id="edit_type" value="{{ $edit_type }}">
      @endif
    @endisset

     @isset($oldprofile)
         @if($oldprofile == 1)
            <input type="text" value="1" name="oldprofile" id="oldprofile">
         @endif
      @endisset
    <div class="card-body">
       <div class="row">
          <div class="col-md-3">
             <div class="form-group">
                <label for="Name">{{ __('profile.name') }}</label>
                <input type="text" value="{{isset($users->name)?$users->name:''}}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter name" readonly>
                @error('name')
                <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
                </span>
                @enderror
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="Birth Date"> {{ __('profile.birth_date') }}</label>
                <div class="input-group date dateformat" id="date_of_birth" data-target-input="nearest">
                   <input type="text" value="{{isset($users->date_of_birth)?date('d-m-Y',strtotime($users->date_of_birth)):''}}" name="date_of_birth" class="form-control datetimepicker-input " data-target="#date_of_birth" readonly />
                   <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                   </div>
                </div>
             </div>
          </div>

          <div class="col-md-3">
             <div class="form-group">
                <label for="designation"> {{ __('profile.designation') }}</label>
                <input type="text" value="{{isset($users->designation)?$users->designation:''}}" class="form-control" id="designation" name="designation" placeholder="Designation" readonly>
             </div>
          </div>
        <div class="col-md-3 avatar-upload_block {{ (isset($isEdit) && $isEdit == 1) ? 'pt-5' : '' }}">
             <div class="avatar-upload">
                <div class="avatar-edit">
                   <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                   <label for="image"><i class="fas fa-upload"></i></label>
                </div>
                <div class="avatar-preview">
                   @if ($imageData)
                   <div id="imagePreview" style="background-image: url('data:image/jpeg;base64,{{ base64_encode($imageData) }}');"> </div>
                   @else
                   <div id="imagePreview" style="background-image: url('{{ asset('images/no-image.jpg') }}')"> </div>
                   @endif
                </div>
                <!-- Show file name below the upload button -->
                <div id="fileNameDisplay" class="file-name"></div>
             </div>

          </div>
       </div>


       <div class="row">
          <div class="col-md-3">
             <div class="form-group">
                <label for="Office"> {{ __('profile.office') }} <span class="error">*</span> </label>
                <input type="text" value="{{isset($users->office)?$users->office:''}}" class="form-control" id="office" name="office" placeholder="Enter office">
             </div>
          </div>

          <div class="col-md-3">
             <div class="form-group">
                <label for="Mobile No"> {{ __('profile.mobile_no') }}</label>
                <input type="text" value="{{isset($users->contact_no)?$users->contact_no:''}}" class="form-control" id="contact_no" name="contact_no" placeholder="Moblie No">
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="Email Id"> {{ __('profile.email_id') }}</label>
                <input type="email" value="{{isset($users->email)?$users->email:''}}" class="form-control" name="email_id" id="email_id" placeholder="email" readonly>
             </div>
          </div>
       </div>
       <div class="row">
          <div class="col-md-3">
             <div class="form-group">
                <label for="maratial_status">{{ __('profile.maratial_status') }} </label>
                <x-select
                   name="maratial_status"
                   :options="getMaratialstatus()"
                   :selected="$users->maratial_status"
                   class="form-control select2"
                   placeholder="Select Marital Status" />
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="is_dept_head"> {{ __('profile.is_head') }} <span class="error">*</span></label>
                <x-select
                   name="is_dept_head"
                   :options="['' => 'Select An Option'] + getYesNo()"
                   :selected="$users->is_dept_head ?? ''"
                   class="form-control select2"
                   id="is_dept_head" />

             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="is_transferable"> {{ __('profile.is_transfer') }} <span class="error">*</span></label>
                <x-select
                   name="is_transferable"
                   :options="['' => 'Select An Option'] + getYesNo()"
                   :selected="$users->is_transferable ?? ''"
                   class="form-control select2"
                   id="is_transferable" />

             </div>
          </div>
       </div>
       <div class="row">
          <div class="col-md-3">
             <div class="form-group">
                <label for="office_email_id">{{ __('profile.office_email') }}<span class="error">*</span> </label>
                <input type="text" value="{{isset($users->office_email_id)?$users->office_email_id:''}}" class="form-control" id="office_email_id" name="office_email_id" placeholder="Office Email Id">
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="is_police_staff"> {{ __('profile.is_police') }} <span class="error">*</span></label>
                <x-select
                   name="is_police_staff"
                   :options="getYesNo()"
                   :selected="$users->is_police_staff ?? ''"
                   class="form-control select2"
                   id="is_police_staff"
                   placeholder="Select An Option" />

             </div>
             <label id="is_police_staff-error" class="error" for="is_police_staff"></label>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="is_fix_pay_staff"> {{ __('profile.is_fix_pay') }} <span class="error">*</span></label>
                <x-select
                   name="is_fix_pay_staff"
                   :options="getYesNo()"
                   :selected="$users->is_fix_pay_staff ?? ''"
                   class="form-control select2"
                   id="is_fix_pay_staff"
                   placeholder="Select An Option" />

             </div>
             <label id="is_fix_pay_staff-error" class="error" for="is_fix_pay_staff"></label>
          </div>

          <div class="col-md-3">
             <div class="form-group">
                <label for="appointment_date">{{ __('profile.appointment_date') }} <span class="error">*</span></label>
                <div class="input-group date dateformat" id="appointment_date" data-target-input="nearest">
                   <input type="text" value="{{ ($users->appointment_date)?date('d-m-Y',strtotime($users->appointment_date)):''}}" name="appointment_date" class="form-control datetimepicker-input" data-target="#appointment_date" />
                   <div class="input-group-append" data-target="#appointment_date" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="date_of_retirement"> {{ __('profile.retirement_date') }} <span class="error">*</span></label>
                <div class="input-group date dateformat" id="date_of_retirement" data-target-input="nearest">
                   <input type="text" value="{{isset($users->date_of_retirement)?date('d-m-Y',strtotime($users->date_of_retirement)):''}}" name="date_of_retirement" class="form-control datetimepicker-input" data-target="#date_of_retirement" />
                   <div class="input-group-append" data-target="#date_of_retirement" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="grade_pay"> {{ __('profile.matrix_pay') }} <span class="error">*</span></label>
                <x-select
                   name="grade_pay"
                   :options="getPayScale()"
                   :selected="$users->grade_pay ?? ''"
                   class="form-control select2"
                   id="grade_pay" />

             </div>
          </div>
          <!-- Container to display salary slab details -->
          <div class="col-md-3">
             <div class="form-group">
                <label for="salary_slab"> {{ __('profile.salary_slab') }} <span class="error">*</span></label>
                <input type="text" value="{{isset($users->salary_slab)?$users->salary_slab:''}}" class="form-control" id="salary_slab" name="salary_slab" placeholder="Salary Slab Details" readonly>
                <!-- <div id="salary_slab_details" style=" background-color: #f8f9fa;border: 1px solid #ced4da; border-radius: 3px;padding: 8px;margin-top: 0px;color: #495057;font-size: 15px;font-family: inherit; word-wrap: break-word; "></div> -->
             </div>
          </div>

          <!-- <div class="col-md-3">
                     <div class="form-group">
                        <label for="salary_slab"> {{ __('profile.salary_slab') }} <span class="error">*</span></label>

                       <x-select 
                        name="salary_slab"
                        :options="getSalarySlab()"
                        :selected="$users->salary_slab ?? ''"
                        class="form-control select2"
                        id="salary_slab"
                     />

                     </div>
                  </div> -->

          <!-- <div class="col-md-3">
                     <div class="form-group">
                        <label for="grade_pay">{{ __('profile.matrix_pay') }} <span class="error">*</span></label>
                        <input type="text" class="form-control" id="grade_pay" value="{{isset($users->grade_pay)?$users->grade_pay:''}}" name="grade_pay" placeholder="Enter grade pay">
                     </div>
                  </div> -->
          <div class="col-md-3">
             <div class="form-group">
                <label for="actual_salary">{{ __('profile.axtual_salary') }} <span class="error">*</span></label>
                <input type="text" class="form-control" value="{{isset($users->actual_salary)?$users->actual_salary:''}}" name="actual_salary" id="actual_salary" placeholder="Enter Actual Salary">
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="basic_pay">{{ __('profile.basic_pay') }} <span class="error">*</span></label>
                <input type="text" class="form-control" value="{{isset($users->basic_pay)?$users->basic_pay:''}}" id="basic_pay" name="basic_pay" placeholder="Enter Basic pay">
             </div>
          </div>

          <div class="col-md-3">
             <div class="form-group">
                <label for="gpfnumber">{{ __('profile.gps_no') }} </label>
                <input type="text" class="form-control" value="{{isset($users->gpfnumber)?$users->gpfnumber:''}}" id="gpfnumber" name="gpfnumber" placeholder="Enter GPF Number">
             </div>
          </div>
          <div class="col-md-3">
             <div class="form-group">
                <label for="panno">{{ __('profile.panno') }} </label>
                <input type="text" class="form-control" value="{{isset($users->pancard)?$users->pancard:''}}" id="pancard" name="pancard" placeholder="Enter PAN Number">
             </div>
          </div>
          <div class="row">

             <div class="col-md-3">
                <div class="form-group">
                   <label for="is_judge"> {{ __('profile.is_judge') }} <span class="error">*</span></label>
                   <x-select
                      name="is_judge"
                      :options="['' => 'Select An Option'] + getYesNo()"
                      :selected="$users->is_judge ?? ''"
                      class="form-control select2"
                      id="is_judge" />
                </div>
             </div>
             <div class="col-md-3">
                <div class="form-group">
                   <label for="is_phy_dis"> {{ __('profile.is_phy_dis') }} <span class="error">*</span></label>
                   <x-select
                      name="is_phy_dis"
                      :options="['' => 'Select An Option'] + getYesNo()"
                      :selected="$users->is_phy_dis ?? ''"
                      class="form-control select2"
                      id="is_phy_dis" />

                </div>
             </div>
             <div class="col-md-3" id='dis_per_yes' style="display:none">
                <div class="form-group">
                   <label for="dis_per">{{ __('profile.dis_per') }} <span class="error">*</span></label>
                   <input type="text" class="form-control" value="{{isset($users->dis_per)?$users->dis_per:0}}" id="dis_per" placeholder="Enter..." name="dis_per">

                </div>
             </div>
          </div>
          <div class="row">
             <div class="col-md-3">
                <div class="form-group">
                   <label for="office_phone">{{ __('profile.office_phone') }} <span class="error">*</span></label>
                   <input type="text" class="form-control" value="{{isset($users->office_phone)?$users->office_phone:''}}" id="office_phone" placeholder="Enter Office Phone" name="office_phone">
                </div>
             </div>
             <div class="col-md-3">
                <div class="form-group">
                   <label for="office_address">{{ __('profile.office_address') }} <span class="error">*</span></label>
                   <textarea class="form-control" id="office_address" name="office_address" placeholder="Enter Office Address">{{ isset($users->office_address)?$users->office_address:''}}</textarea>

                </div>
             </div>
             <div class="col-md-3">
                <div class="form-group">
                   <label for="Address">{{ __('profile.native_address') }} <span class="error">*</span> </label>
                   <textarea class="form-control" id="address" name="address" placeholder="Enter Native Address">{{ isset($users->address)?$users->address:''}}</textarea>
                </div>
             </div>
             <div class="col-md-3">
                <div class="form-group">
                   <label for="current_address">{{ __('profile.current_address') }} <span class="error">*</span> </label>
                   <textarea class="form-control" id="current_address" name="current_address" placeholder="Enter Current Address">{{ isset($users->current_address)?$users->current_address:''}}</textarea>
                </div>
             </div>
          </div>

       </div>
       <!-- /.card-body -->
       <div class="mt-4">
          <button type="submit" class="btn btn-primary"> {{ ($isEdit ?? false) ? __('common.next') : __('common.submit') }}</button>
       </div>
       <div class="mt-4">
          <span class="text-danger">Fields marked with * are mandatory to fill. </span>
       </div>
    </div>
 </form>

 @push('footer-script')

 <script type="text/javascript">
    $(function() {
       $('#is_phy_dis').trigger('change');
       // Bootstrap DateTimePicker v4
       $('.dateformat').datetimepicker({
          format: 'DD-MM-YYYY'
       });
    
    $('.numeric').keypress(function(event) {
       return numF(event);
    });
    $('.alfanumaric').keypress(function(event) {
       return anFS(event);
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
          "is_judge": "required",
          "is_phy_dis": "required",
          "is_transferable": "required",
          "office_email_id": {
             "required": true,
             "validEmail": true,
          },
          is_police_staff: {
             "required": true,

          },
          is_fix_pay_staff: {
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

                   if (salarySlab.payscale_to == null) {
                      salarySlab.payscale_to = 'above';
                   }
                   var salaryRange = salarySlab.payscale_from + " - " + salarySlab.payscale_to;

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
    });
 </script>
 @endpush