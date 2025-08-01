@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
<style>
    .user_details_block .user_details_view {
        width: 100%;
    }

    .user_details_view1:nth-child(odd) {
        background: #ebf2f1 !important;
        padding: 10px 0;
        border: 1px solid #e3e2e2;
        /* border-bottom: none; */
        width: 100%;
    }

    .user_details_view1:nth-child(even) {
        background: rgb(255, 255, 255) !important;
        padding: 10px 0;
        border: 1px solid #e3e2e2;
        /* border-bottom: none; */
        width: 100%;
    }

    .user_details_view1 h6 {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sub_div {
        position: absolute;
        right: 2%;
        top: 25%;
    }
</style>
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
             <!-- left column -->
             <div class="col-md-8">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-header card-new_head text-white">
                        <h3 class="card-title ">Employee Details </h3>
                    </div>
                    <div class="card-body">
                    <div class="">
                <div class="">
                   <div class="">
                            <div class="">
                                <div class="widget-signups">
                                    <div class=" usr_hd">
                                        <div class="card-header custom-header">Basic Details</div>
                                        <div class="">
                                            <div class="col-lg-12 p-0">
                                                <div class="card_user px-3 py-4">
                                                    <div class="user_details_block">
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">1) ( અ )નામ(પુરેપુરૂ)<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['name'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">(બ ) ક્વાર્ટર કેટેગરી <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['quartertype'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">(ક) જન્મ તારીખ <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['date_of_birth'] : 'N/A' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">2) ( અ ) હોદ્દો <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['designation'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">(બ ) પોતે કચેરી/વિભાગ ના વડા છે કે કેમ? <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['is_dept_head'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">(ક) કચેરી નું નામ<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['officename'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ડ ) કચેરી નું સરનામું<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['officeaddress'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">3) કચેરી ફોન નંબર<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['officephone'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">4) ( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો)<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['salary_slab'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4"><span>( બ ) અરજીની તારીખે મળતો મૂળ પગાર (As per 7 <sup>th</sup>)<span> <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['basic_pay'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">(ક) સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['appointment_date'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ડ ) નિવ્રૂત્તિ ની તારીખ<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['date_of_retirement'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ઇ ) જી.પી.એફ. ખાતા નંબર<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['gpfnumber'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-12">
                                                                <h6 class="mb-0">5) {{ ucfirst(strtolower(getDistrictByCode(Session::get('dcode'),'gn','gn'))) }} માં અત્યારે જે કક્ષાના વસવાટમાં રહેતા હો તેની માહિતી નીચે પ્રમાણે આપવી.</h6>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ક ) વસવાટની કક્ષા<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_quarter_type'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ખ ) સેકટર નં.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_area_name'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ગ ) બ્લોક નં.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_blockno'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ઘ ) યુનિટ<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_unitno'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ચ) સકયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_details'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( છ ) કઇ તારીખથી સદર વસવાટનો ઉપભોગ કરો છો ? (કબજો લીધા તારીખ)<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_possession_date'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-12">
                                                                <h6 class="mb-0">6) અગાઉ ઉચ્ચલ કક્ષાનું વસવાટ ફાળવવામાં આવેલ હતું કે કેમ ?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ક ) વસવાટની કક્ષા<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['hc_quarter_type'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ખ ) સેકટર નં.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['hc_area'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ગ ) બ્લોક નં.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['hc_blockno'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ઘ ) યુનિટ<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['hc_unitno'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ચ) કયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['hc_details'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-10">
                                                                <h6 class="mb-0">7) આ સાથે સામેલ રાખેલ ઉચ્ચ કક્ષાનું વસવાટ મેળવવાને લગતી સૂચનાઓ મેં વાંચી છે અને તે તથા સરકારશ્રી વખતો વખત આ અંગે સૂચનાઓ બહાર પાડે તેનું પાલન કરવા હું સંમત છું.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <p class="m-0"> હા </p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-sm-12">
                                                                <h6 class="mb-0">8) હું, &nbsp;<span style="border-bottom: 1px dotted; text-decoration: none;"><b>{{ isset($quarterrequest) ? $quarterrequest['name'] : 'N/A' }}</b></span> &nbsp;ખાતરીપૂર્વક જાહેર કરૂ છું કે ઉપર જણાવેલ વિગતો મારી જાણ મુજબ સાચી છે અને જો તેમાં કોઇ વિગત ખોટી હશે તો તે અંગે આવાસ ફાળવણીના નિયમો બંધનકર્તા રહેશે.</label></h6>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

        </div>
                    </div>
                    <!-- /.card-header -->
  
                </div>
            </div>
            <!-- /.card -->
            <div class="col-md-4">
                <!-- Form Element sizes -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Review</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('saveapplication_b') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                 
                                    <div class="col-12" id="remarks">
                                            <div class="form-group">
                                                <label for="Name">Have Issue?</label>
                                            </div>
                                          <input type="hidden" name="app_admin" id="app_admin" value="1">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" id="submit_issue"
                                                    name="submit_issue" value="submit_issue"> Add Remarks </button>
                                                    <!-- Submit Review & Next -->
                                            </div>
                                    </div>
                                    <div id="submit">
                                        <div class="col-12 yesno_status"  id="yesno_status1">
                                           
                                        </div>
                                        <div class="card-footer">
                                            <input type="hidden" name="requestid" value="{{ isset($quarterrequest['requestid'])?$quarterrequest['requestid']:'' }}" />
                                            <input type="hidden" name="rv" value="{{ isset($quarterrequest['rivision_id'])?$quarterrequest['rivision_id']:'' }}" />
                                            <input type="hidden" name="dgr" value="{{ isset($quarterrequest['dgrid'])?$quarterrequest['dgrid']:'' }}" />
                                            <input type="hidden" name="status" value="1" />
                                                
                                            <button type="submit" class="btn btn-primary" id="submit_doc" name="submit_doc" >Save & Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                    </div>
                    <!-- /.card-body -->
                </div>
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
                                @foreach($file_uploaded as $file)
                                <tr>
                                    <td>{{ $file->document_name }}</td>
                                    <td>
                                        <a href="{{ url('/download_file/'.$file->doc_id) }}" target="_blank">
                                            <img src="{{ URL::asset('images/pdf.png') }}" class="export-icon" />
                                        </a>
                                    </td>
                                    <td>
                                    <input type="checkbox" class="file-checkbox" id="files[{{ $file->doc_id }}]"   name="files[{{ $file->doc_id }}]"    />
                                    </td>
                                </tr>
                                @endforeach
                                 <tr>
                                            <td>Is Application Form Correct?</td>
                                            <td></td>
                                <td>
                                                <input class="file-checkbox" type="checkbox" id="app_admin_checkbox" name="app_admin_checkbox" value="1">
                                 </td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                </form>
                <!-- /.card -->
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">View old version(s)</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    @foreach($quarterrequest1 as $request)
                                    <label for="Name"></label>
                                    @php
                                    $url = url('/viewapplication/'.(base64_encode($request->requestid)).'/'.(base64_encode($request->rivision_id)).'/'.(base64_encode($quarterrequest['quartertype'])));
                                    @endphp
                                    <a href="{{ $url }}">
                                        <img src="{{ URL::asset('images/archive.png') }}" class="export-icon" />
                                    </a>


                                    @if($request->rivision_id == 0)
                                    {{ "Application" }}
                                    @else
                                    {{ "Rivision ".$request->rivision_id }}
                                    @endif


                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>



            @endsection
            @push('page-ready-script')

            @endpush
            @push('footer-script')
            <script type="text/javascript">
              $(document).ready(function() {
                // Initially hide the remarks text input
                $('#adm_remarks').hide();

                // Listen for changes on the select box
                $('#admin_remarks').change(function() {
                    // Get the selected values (an array of selected options)
                    var selectedValues = $(this).val();

                    // Check if "Other" is selected
                    if (selectedValues && selectedValues.includes('other')) {
                        $('#adm_remarks').show();  // Show the remarks text input for "Other"
                    } else {
                        $('#adm_remarks').hide();  // Hide the remarks text input if "Other" is not selected
                    }
                });

                // Ensure the text box is hidden if no option is selected initially (or if "Other" is not selected)
                var selectedValues = $('#admin_remarks').val();
                if (!selectedValues || !selectedValues.includes('other')) {
                    $('#adm_remarks').hide();  // Hide remarks text input initially if "Other" is not selected
                }
            });
                // $('#status').change(function() {
                //     if (this.value == 1) {
                //         $('.yesno_status').show();
                //     } else if (this.value == 0) {
                //         $('.yesno_status').hide();
                //     }
                // });
                $("#front_annexurea").validate({
                    rules: {
                        // status: "required",
                       // dg_allotment: "required",

                    }
                });
            </script>
            <script>
                    document.querySelectorAll('.file-checkbox').forEach(function(checkbox) {
                        checkbox.addEventListener('change', function() {
                       
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
                        const submitButton = document.getElementById('submit');
                        var remarks = document.getElementById('remarks');

                        // Show the submit button if all checkboxes are checked
                        if (allChecked) {
                            submitButton.style.display = 'inline'; // Show button
                            remarks.style.display = 'none';
                        } else {
                           
                            submitButton.style.display = 'none'; // Hide button
                            remarks.style.display = 'inline';
                        }
                    }
                    $(document).ready(function() {
                        toggleSubmitButton(); // Call the toggleSubmitButton function
                    });

                </script>
                 <script>
                    document.getElementById('app_admin_checkbox').addEventListener('change', function() {
                        // When checked, set value to 0; when unchecked, set to 1
                        document.getElementById('app_admin').value = this.checked ? '0' : '1';
                    });
                </script>
            @endpush