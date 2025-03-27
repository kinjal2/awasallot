@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)
@section('content')

<div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Update Quarter details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quarter Request (Normal)</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-7">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">New Quarter Request Rivision : 1</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table border="1" style="text-align: left !important; border-collapse:collapse; "
                            width="100%" align="left">
                            <colgroup>
                                <col width="5%" />
                                <col width="35%" />
                                <col width="10%" />
                                <col width="25%" />
                                <col width="10%" />
                                <col width="25%" />
                            </colgroup>
                            <tr>
                                <th colspan="6" style="text-align: center;">પરિશિષ્ટ - અ</th>
                            </tr>
                            <tr>
                                <th colspan="6" style="text-align: center;">{{ $officesname }}ગાંધીનગર માં સરકારી વસવાટ મેળવવા માટે
                                    સરકારી કર્મચારી કે અધિકારી એ કરવા ની અરજી</th>
                                    <!-- 23-1-2025 -->
                            </tr>
                            <!-- <tr>
                                <th colspan="6" style="text-align: center;">ગાંધીનગર માં સરકારી વસવાટ મેળવવા માટે
                                    સરકારી કર્મચારી કે અધિકારી એ કરવા ની અરજી</th>
                            </tr> -->
                            <tr>
                                <th></th>
                                <th>ક્વાર્ટર કેટેગરી </th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['quartertype'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>યુઝર નંબર </th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['uid'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>1</th>
                                <th>નામ(પુરેપુરૂ)</th>
                                <td colspan="4"> {{ isset($quarterrequest) ? $quarterrequest['name'] : 'N/A' }} </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( અ ) હોદ્દો</th>
                                <td colspan="4">{{ isset($quarterrequest) ? $quarterrequest['designation'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>(બ ) પોતે કચેરી/વિભાગ ના વડા છે કે કેમ?</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['is_dept_head'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <th>( અ ) જે વિભાગ/કચેરીમાં કામ કરતા હોય તેનુ નામ</th>
                                <td colspan="4">{{ isset($quarterrequest) ? $quarterrequest['officename'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( બ ) જ્યાંથી બદલી થઈ ને આવ્યા હોય /પ્રતિનિયુક્તિ ઉપર આવ્યા હોય ત્યાંનો હોદ્દો અને
                                    કચેરી નું નામ</th>
                                <td><strong>હોદ્દો</strong></td>
                                <td>{{ isset($quarterrequest) ? $quarterrequest['old_desg'] : 'N/A' }} </td>
                                <td><strong>કચેરી નું નામ</strong></td>
                                <td>{{ isset($quarterrequest) ? $quarterrequest['old_office'] : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ક ) ગાંધીનગર ખાતે હાજર થયા તારીખ</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['deputation_date'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ડ ) વતન નું સરનામું</th>
                                <td colspan="4">{{ isset($quarterrequest) ? $quarterrequest['address'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th> (ઇ) જન્મ તારીખ</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['date_of_birth'] : 'N/A' }}

                                </td>
                            </tr>

                            <tr>
                                <th></th>
                                <th>( ઈ ) નિવ્રૂત્તિ ની તારીખ</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['date_of_retirement'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ફ ) જી.પી.એફ. ખાતા નંબર</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['gpfnumber'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <th>સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ્ </th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['appointment_date'] : 'N/A' }}

                                </td>
                            </tr>

                            <tr>
                                <th>4</th>
                                <th>( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો) </th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['salary_slab'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( બ ) ખરેખર મળતો પગાર</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['actual_salary'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૧ ) મૂળ પગાર</th>
                                <td colspan="4">{{ isset($quarterrequest) ? $quarterrequest['basic_pay'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૨ ) પર્સનલ પગાર</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['personal_salary'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૩ ) સ્પેશ્યલ પગાર</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['special_salary'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૪ ) પ્રતિનિયુક્તિ ભથ્થું</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['deputation_allowance'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; કુલ પગાર રૂ.</th>
                                <td colspan="4">

                                </td>
                            </tr>
                            <tr>
                                <th>5</th>
                                <th>( અ ) પરણિત/અપરણિત </th>
                                <td colspan="4">
                                    {{ isset($quarterrequest) ? $quarterrequest['maratial_status'] : 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <Th>6</Th>
                                <th>આ પહેલા ના સ્થ્ળે સરકારશ્રીએ વસવાટ ની સવલત આપી હોય તો </th>
                                <Td colspan="4"></Td>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <td><strong>( અ ) કોલોની નું નામ/રીક્વીઝીશન કરેલ મકાન ની વિગત</strong></td>
                                <td> {{ isset($quarterrequest) ? $quarterrequest['prv_area_name'] : 'N/A' }}
                                </td>
                                <td><strong>( બ ) વસવાટ નો ક્વાર્ટર નંબર</strong></td>
                                <td>{{ isset($quarterrequest) ? $quarterrequest['prv_building_no'] : 'N/A' }} </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <td><strong>( ક-૧ )વસવાટ ની કેટેગરી</strong></td>
                                <td> {{ isset($quarterrequest) ? $quarterrequest['prv_quarter_type'] : 'N/A' }}</td>
                                <td><strong>(ક-૨) માસીક ભાડું</strong></td>
                                <td> {{ isset($quarterrequest) ? $quarterrequest['prv_rent'] : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <td><strong>( ડ ) મકાન મળતાં ઉપર દર્શાવેલ મકાન સરકારને તુરત પાછું આપવામાં આવશે કે
                                        કેમ્?</strong></td>
                                <td colspan="3">
                                    {{ isset($quarterrequest) ? $quarterrequest['prv_handover'] : 'N/A' }}

                                </td>
                            </tr>
                            <Tr>
                                <th>7</th>
                                <th>અગાઉ ગાંધીનગર માં મકાન મેળવવા અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ છે?</th>
                                <td> {{ isset($quarterrequest) ? $quarterrequest['have_old_quarter'] : 'N/A' }}


                                </td>
                                <td><strong>તારીખ, નંબર, બ્લોક વિગેરે વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($quarterrequest) ? $quarterrequest['old_quarter_details'] : 'N/A' }}

                                </td>
                            </Tr>
                            <tr>
                                <th>8</th>
                                <th>શિડ્યુલ કાસ્ટ અથવા શિડ્યુલ ટ્રાઈબ ના કર્મચારી હોય તો તેમણે વિગત આપવી તથા કચેરીનાં
                                    વડાનું પ્રમાણપત્ર સામેલ કરવું</th>
                                <td>{{ isset($quarterrequest['is_scst']) ? $quarterrequest['is_scst'] : 'N/A' }}</td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($quarterrequest['is_scst']) ? $quarterrequest['is_scst'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>9</th>
                                <th>ગાંધીનગર ખાતે જો રહેતા હોય તો કોની સાથે, તેમની સાથે નો સંબંધ અને મકાન ની વિગત</th>
                                <td>{{ isset($quarterrequest['is_relative']) ? $quarterrequest['is_relative'] : 'N/A' }}
                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($quarterrequest['relative_details']) ? $quarterrequest['relative_details'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>10</th>
                                <th>ગાંધીનગર ખાતે માતા/પિતા. પતિ/પત્ની વગેરે લોહી ની સગાઈ જેવા સંબંધીને મકાન ફાળવેલ છે?
                                </th>
                                <td>{{ isset($quarterrequest['is_relative_householder']) ? $quarterrequest['is_relative_householder'] : 'N/A' }}
                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($quarterrequest['relative_house_details']) ? $quarterrequest['relative_house_details'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>11</th>
                                <th>ગાંધીનગર શહેર ની હદ માં અથવા સચિવાલય થી ૧૦ કિલોમીટર ની હદ માં અથવા ગાંધીનગર ની હદ
                                    માં આવતા ગમડાં માં તેમના પિતા/પતિ/પત્ની કે કુટુંબ ના કોઈપણ સભ્યને નામે રહેણાંકનું
                                    મકાન છે?</th>
                                <td>{{ isset($quarterrequest['have_house_nearby']) ? $quarterrequest['have_house_nearby'] : 'N/A' }}
                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($quarterrequest['nearby_house_details']) ? $quarterrequest['nearby_house_details'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>12</th>
                                <th colspan="3">જો બદલી થઈ ને ગાંધીનગર આવેલ હોય તો પોતે જે કક્ષા નું વસવાટ મેળવવાને
                                    પાત્ર હોય તે મળે ત્યાં સુધી તરત નીચી કક્ષાનું વસવાટ ફાળવી આપવા વિનંતી છે?</th>
                                <td colspan="2">
                                    {{ isset($quarterrequest['downgrade_allotment']) ? $quarterrequest['downgrade_allotment'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>13</th>
                                <th colspan="3">સરકારશ્રી મકાન ફાળવણી અંગે જે સૂચનાઓ નિયમો બહાર પાડે તેનું પાલન કરવા
                                    હું સંમત છુ?</th>
                                <td colspan="2">હા</td>
                            </tr>
                            <tr>
                                <th>14</th>
                                <th colspan="3">મારી બદલી થાય તો તે અંગે ની જાણ તુરત કરીશ</th>
                                <td colspan="2">હા</td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
            <div class="col-md-5">
                <!-- Form Element sizes -->
                <div class="card card-success">
                <form method="POST" name="ddo_submit_document_a" id="ddo_submit_document_a" action="{{route('ddo.editquarter.a.submitdocument')}}">
                @csrf
                    <!-- /.card -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Attachments</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $issue=0; ?>
                                    @foreach ($file_uploaded as $file)
                                    <tr>
                                        <td>{{ $file->document_name }}</td>
                                        <td>
                                            <a href="{{ url('/download_file/' . $file->doc_id) }}" target="_blank">
                                                <img src="{{ URL::asset('images/pdf.png') }}" class="export-icon" />
                                            </a>
                                        </td>
                                        <td>
                                            
                                            <input type="checkbox" class="file-checkbox" id="files[{{ $file->doc_id }}]"   name="files[{{ $file->doc_id }}]"  {{ $file->is_file_ddo_verified == 1 ? 'checked' : $issue=1 }}  />
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-12 mt-20 pt-4">
                                <div class="form-group">
                                    <!-- <form action="" method="post" name="doc_form" id="doc_form">
                                        @csrf
                                        <input type="hidden" name="reqid" id="reqid"
                                            value="{{ isset($requestid) ? base64_encode($requestid) : '' }}" />
                                        <input type="hidden" name="rvid" id="rvid"
                                            value="{{ isset($quarterrequest['rivision_id']) ? base64_encode($quarterrequest['rivision_id']) : '' }}" />
                                        <input type="hidden" name="uid" id="uid"
                                            value="{{ base64_encode($quarterrequest['uid']) }}">
                                        <input type="hidden" name="qttype" id="qttype"
                                            value="{{ isset($quarterrequest['quartertype']) ? base64_encode($quarterrequest['quartertype']) : '' }}" /> -->

                                        <!-- <button type="submit" class="btn btn-primary" id="submit_doc" name="submit_doc">Submit Documents</button> -->
                                    <!-- </form> -->
                                </div>
                                <div id="message-container_submitdoc" style="margin-top: 10px;"></div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>




                    <!-- /.card -->

                    <!-- for review 22-11-2024 -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Review</h3>
                        </div>
                        <div class="card-body">
                          
                                <div class="row">
                                    <div class="col-12">
                                  
                                        <!-- <div class="form-group">
                                            <label for="Name">Status</label>
                                            {{ Form::select('status', [null => __('common.select')] + getddoupdatestatus(), '', ['id' => 'status', 'class' => 'form-control select2']) }}

                                        </div> -->
                                        <!-- <div class="col-12 yesno_status" >

                                            <div class="form-group">
                                                <label for="Name">Add Remarks</label>
                                                <input type="text" name="ddo_remarks" id="ddo_remarks" class="form-control">
                                            </div>
                                        </div> -->
                            
                                       
                                        <div class="col-12" id="remarks">
                                            <div class="form-group">
                                                <label for="Name">Have Issue?</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="Name">Add Remarks</label>
                                                <input type="text" name="ddo_remarks" id="ddo_remarks" class="form-control">
                                            </div>
                                            <div class="form-group">


                                                <button type="submit" class="btn btn-primary" id="submit_issue"
                                                    name="submit_issue" value="submit_issue">Submit Review & Next</button>
                                            </div>
                                        </div>
                                       
                                        <div class="col-12 ">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" id="submit_doc"
                                                    name="submit_doc" style="display: none;">Verified & Next</button>
                                            </div>
                                            <div >
                                                <input type="hidden" name="reqid" id="reqid"
                                                    value="{{ isset($requestid) ? base64_encode($requestid) : '' }}" />
                                                <input type="hidden" name="rvid" id="rvid"
                                                    value="{{ isset($quarterrequest['rivision_id']) ? base64_encode($quarterrequest['rivision_id']) : '' }}" />
                                                <input type="hidden" name="uid" id="uid"
                                                    value="{{ base64_encode($quarterrequest['uid']) }}">
                                                <input type="hidden" name="qttype" id="qttype"
                                                    value="{{ isset($quarterrequest['quartertype']) ? base64_encode($quarterrequest['quartertype']) : '' }}" />


                                                <!-- <button type="submit" class="btn btn-primary" id="submit_doc"
                                                    name="submit_doc" style="display: none;">Submit Review & Next</button> -->

                                                @if (Session::has('message'))
                                                <div id="message" style="margin-top: 10px; color: green;">
                                                    {{ Session::get('message') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                    </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>



                @endsection
                @push('page-ready-script')
                @endpush
                @push('footer-script')
                <script type="text/javascript">
                    $('#status').change(function() {
                        if (this.value == 1) {

                            $('.yesno_status').hide();
                        } else if (this.value == 2) {
                            $('.yesno_status').show();
                        }
                    });
                    $("#ddo_submit_document_a").validate({
                        rules: {
                            ddo_remarks: "required",

                        }
                    });
                </script>
                <!-- <script>
                    document.getElementById('submit').addEventListener('click', function(event) {
                        const selectElement = document.getElementById('getpayslip_certificate');
                        const selectedValue = selectElement.value;
                        const fileInput = document.getElementById('image');
                        const file = fileInput.files[0]; // Get the first selected file

                        // Check if a document is selected
                        if (!selectedValue) {
                            event.preventDefault(); // Prevent form submission
                            alert('Please select a document to upload.'); // Show an alert
                            selectElement.focus(); // Set focus back to the select element
                            return; // Exit the function
                        }

                        // Check if a file is selected
                        if (!file) {
                            event.preventDefault(); // Prevent form submission
                            alert('Please upload a file.'); // Show an alert
                            fileInput.focus(); // Set focus back to the file input
                            return; // Exit the function
                        }

                        // Additional file type and size validation can be added here if needed
                    });
                </script> -->



                <script>
                    // Listen for change events on the select element
                    //      $('#getpayslip_certificate').on('change', function() {

                    //     var selectedOption = $(this).find('option:selected');
                    //     var selectedValue = selectedOption.val();


                    //     // Remove the selected option from the dropdown
                    //     if (selectedValue) {
                    //         selectedOption.remove();
                    //     }
                    // });


                    $('#submit').on('click', function(event) {
                        event.preventDefault(); // Prevent default form submission

                        const selectElement = $('#getpayslip_certificate');
                        const selectedValue = selectElement.val();
                        const fileInput = $('#image');
                        const file = fileInput[0].files[0]; // Get the first selected file

                        // Clear previous messages
                        $('#message-container').text('').removeClass('alert alert-danger alert-success');


                        // Validation checks
                        if (!selectedValue) {
                            //alert('Please select a document to upload.');
                            $('#message-container').addClass('alert alert-danger').text('Please select a document to upload.');
                            selectElement.focus();
                            return; // Exit the function
                        }

                        if (!file) {
                            //alert('Please upload a file.');
                            $('#message-container').addClass('alert alert-danger').text('Please select file to upload.');
                            fileInput.focus();
                            return; // Exit the function
                        }

                        // Prepare FormData for AJAX
                        const formData = new FormData();
                        formData.append('getpayslip_certificate', selectedValue);
                        formData.append('image', file);
                        formData.append('request_id', $('#request_id').val());
                        formData.append('uid', $('#uid').val());
                        formData.append('_token', '{{ csrf_token() }}'); // Include CSRF token

                        // AJAX request
                        $.ajax({
                            url: "{{ route('ddo.editquarter.a.savedocument') }}", // Update with your route name
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                                $('#message-container').addClass('alert alert-success').text(
                                    'File uploaded successfully!');

                                // Optionally, you can redirect or reset the form here
                            },
                            error: function(xhr) {
                                // Handle error response
                                if (xhr.status === 422) {
                                    const errors = xhr.responseJSON.errors;
                                    let errorMessages = '';
                                    $.each(errors, function(key, value) {
                                        errorMessages += value[0] + '\n'; // Concatenate error messages
                                    });
                                    $('#message-container').addClass('alert alert-danger').text(
                                        errorMessages); // Show error messages
                                } else {
                                    $('#message-container').addClass('alert alert-danger').text(
                                        'An error occurred. Please try again.');
                                }
                            }
                        });
                    });
                </script>
                <script>
                    document.querySelectorAll('.file-checkbox').forEach(function(checkbox) {
                        checkbox.addEventListener('change', function() {
                          // alert("test");
                         /*   let docId = checkbox.getAttribute('data-doc-id');
                            let isChecked = checkbox.checked ? 1 : 2; // 1 if checked, 2 if unchecked

                            // AJAX request to update file status
                            fetch("{{ route('updateFileStatus') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({
                                        doc_id: docId,
                                        is_file_ddo_verified: isChecked
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log(data.success);
                                    if (data.success) {
                                        console.log('File status updated');
                                    } else {
                                        console.log('Failed to update status');
                                    }
                                });*/
                                 // Call the toggleSubmitButton function to update button visibility
                                toggleSubmitButton();
                        });
                    });


                    function toggleSubmitButton() {
                        //alert("Toggle Submit button");
                        // Get all checkboxes
                        const checkboxes = document.querySelectorAll('.file-checkbox');

                        // Check if all checkboxes are checked
                        const allChecked = [...checkboxes].every(checkbox => checkbox.checked);

                        // Find the submit button
                        const submitButton = document.getElementById('submit_doc');
                        var remakrs = document.getElementById('remarks');

                        // Show the submit button if all checkboxes are checked
                        if (allChecked) {
                            submitButton.style.display = 'inline'; // Show button
                            remakrs.style.display = 'none';
                        } else {
                           
                            submitButton.style.display = 'none'; // Hide button
                            remakrs.style.display = 'inline';
                        }
                    }
                    $(document).ready(function() {
                        toggleSubmitButton(); // Call the toggleSubmitButton function
                    });

                </script>
                @endpush
