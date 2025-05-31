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
                                    {{ isset($userDetail) ? $userDetail['quartertype'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>યુઝર નંબર </th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['uid'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>1</th>
                                <th>નામ(પુરેપુરૂ)</th>
                                <td colspan="4"> {{ isset($userDetail) ? $userDetail['name'] : 'N/A' }} </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( અ ) હોદ્દો</th>
                                <td colspan="4">{{ isset($userDetail) ? $userDetail['designation'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>(બ ) પોતે કચેરી/વિભાગ ના વડા છે કે કેમ?</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['is_dept_head'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <th>( અ ) જે વિભાગ/કચેરીમાં કામ કરતા હોય તેનુ નામ</th>
                                <td colspan="4">{{ isset($userDetail) ? $userDetail['officename'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( બ ) જ્યાંથી બદલી થઈ ને આવ્યા હોય /પ્રતિનિયુક્તિ ઉપર આવ્યા હોય ત્યાંનો હોદ્દો અને
                                    કચેરી નું નામ</th>
                                <td><strong>હોદ્દો</strong></td>
                                <td>{{ isset($userDetail) ? $userDetail['old_desg'] : 'N/A' }} </td>
                                <td><strong>કચેરી નું નામ</strong></td>
                                <td>{{ isset($userDetail) ? $userDetail['old_office'] : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ક ) ગાંધીનગર ખાતે હાજર થયા તારીખ</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['deputation_date'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ડ ) વતન નું સરનામું</th>
                                <td colspan="4">{{ isset($userDetail) ? $userDetail['address'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th> (ઇ) જન્મ તારીખ</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['date_of_birth'] : 'N/A' }}

                                </td>
                            </tr>

                            <tr>
                                <th></th>
                                <th>( ઈ ) નિવ્રૂત્તિ ની તારીખ</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['date_of_retirement'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ફ ) જી.પી.એફ. ખાતા નંબર</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['gpfnumber'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <th>સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ્ </th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['appointment_date'] : 'N/A' }}

                                </td>
                            </tr>

                            <tr>
                                <th>4</th>
                                <th>( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો) </th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['salary_slab'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( બ ) ખરેખર મળતો પગાર</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['actual_salary'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૧ ) મૂળ પગાર</th>
                                <td colspan="4">{{ isset($userDetail) ? $userDetail['basic_pay'] : 'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૨ ) પર્સનલ પગાર</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['personal_salary'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૩ ) સ્પેશ્યલ પગાર</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['special_salary'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૪ ) પ્રતિનિયુક્તિ ભથ્થું</th>
                                <td colspan="4">
                                    {{ isset($userDetail) ? $userDetail['deputation_allowance'] : 'N/A' }}

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
                                    {{ isset($userDetail) ? $userDetail['maratial_status'] : 'N/A' }}
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
                                <td> {{ isset($userDetail) ? $userDetail['prv_area_name'] : 'N/A' }}
                                </td>
                                <td><strong>( બ ) વસવાટ નો ક્વાર્ટર નંબર</strong></td>
                                <td>{{ isset($userDetail) ? $userDetail['prv_building_no'] : 'N/A' }} </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <td><strong>( ક-૧ )વસવાટ ની કેટેગરી</strong></td>
                                <td> {{ isset($userDetail) ? $userDetail['prv_quarter_type'] : 'N/A' }}</td>
                                <td><strong>(ક-૨) માસીક ભાડું</strong></td>
                                <td> {{ isset($userDetail) ? $userDetail['prv_rent'] : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <td><strong>( ડ ) મકાન મળતાં ઉપર દર્શાવેલ મકાન સરકારને તુરત પાછું આપવામાં આવશે કે
                                        કેમ્?</strong></td>
                                <td colspan="3">
                                    {{ isset($userDetail) ? $userDetail['prv_handover'] : 'N/A' }}

                                </td>
                            </tr>
                            <Tr>
                                <th>7</th>
                                <th>અગાઉ ગાંધીનગર માં મકાન મેળવવા અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ છે?</th>
                                <td> {{ isset($userDetail) ? $userDetail['have_old_quarter'] : 'N/A' }}


                                </td>
                                <td><strong>તારીખ, નંબર, બ્લોક વિગેરે વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($userDetail) ? $userDetail['old_quarter_details'] : 'N/A' }}

                                </td>
                            </Tr>
                            <tr>
                                <th>8</th>
                                <th>શિડ્યુલ કાસ્ટ અથવા શિડ્યુલ ટ્રાઈબ ના કર્મચારી હોય તો તેમણે વિગત આપવી તથા કચેરીનાં
                                    વડાનું પ્રમાણપત્ર સામેલ કરવું</th>
                                <td>{{ isset($userDetail['is_scst']) ? $userDetail['is_scst'] : 'N/A' }}</td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($userDetail['is_scst']) ? $userDetail['is_scst'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>9</th>
                                <th>ગાંધીનગર ખાતે જો રહેતા હોય તો કોની સાથે, તેમની સાથે નો સંબંધ અને મકાન ની વિગત</th>
                                <td>{{ isset($userDetail['is_relative']) ? $userDetail['is_relative'] : 'N/A' }}
                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($userDetail['relative_details']) ? $userDetail['relative_details'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>10</th>
                                <th>ગાંધીનગર ખાતે માતા/પિતા. પતિ/પત્ની વગેરે લોહી ની સગાઈ જેવા સંબંધીને મકાન ફાળવેલ છે?
                                </th>
                                <td>{{ isset($userDetail['is_relative_householder']) ? $userDetail['is_relative_householder'] : 'N/A' }}
                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($userDetail['relative_house_details']) ? $userDetail['relative_house_details'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>11</th>
                                <th>ગાંધીનગર શહેર ની હદ માં અથવા સચિવાલય થી ૧૦ કિલોમીટર ની હદ માં અથવા ગાંધીનગર ની હદ
                                    માં આવતા ગમડાં માં તેમના પિતા/પતિ/પત્ની કે કુટુંબ ના કોઈપણ સભ્યને નામે રહેણાંકનું
                                    મકાન છે?</th>
                                <td>{{ isset($userDetail['have_house_nearby']) ? $userDetail['have_house_nearby'] : 'N/A' }}
                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($userDetail['nearby_house_details']) ? $userDetail['nearby_house_details'] : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>12</th>
                                <th colspan="3">જો બદલી થઈ ને ગાંધીનગર આવેલ હોય તો પોતે જે કક્ષા નું વસવાટ મેળવવાને
                                    પાત્ર હોય તે મળે ત્યાં સુધી તરત નીચી કક્ષાનું વસવાટ ફાળવી આપવા વિનંતી છે?</th>
                                <td colspan="2">
                                    {{ isset($userDetail['downgrade_allotment']) ? $userDetail['downgrade_allotment'] : 'N/A' }}
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

                    <!-- /.card -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Applied For</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped" id="quarter_application">
                                <thead>
                                    <tr>
                                    <th>Request Type</th>
                                    <th>Quarter <br/>Type</th>
                                    <th>Inward No</th>
                                    <th>Inward Date</th>
                                    <th>Name</th>
                                    <th>Office</th>
                                    <th>Contact No.</th>
                                    <th>Email ID</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="col-12 mt-20 pt-4">
                                <div class="form-group">

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
                            <h3 class="card-title">Update DDO</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" name="ddo_submit_document_a" id="ddo_submit_document_a" action="{{route('ddo.editquarter.a.submitdocument')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <!-- <div class="form-group">
                                            <label for="Name">Status</label>
                                            <x-select 
                                                name="status"
                                                :options="['' => __('common.select')] + getddoupdatestatus()"
                                                :selected="''"
                                                class="form-control select2"
                                                id="status"
                                            />


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
                                            <div class="card-footer">
                                                <input type="hidden" name="reqid" id="reqid"
                                                    value="{{ isset($requestid) ? base64_encode($requestid) : '' }}" />
                                                <input type="hidden" name="rvid" id="rvid"
                                                    value="{{ isset($userDetail['rivision_id']) ? base64_encode($userDetail['rivision_id']) : '' }}" />
                                                <input type="hidden" name="uid" id="uid"
                                                    value="{{ base64_encode($userDetail['uid']) }}">
                                                <input type="hidden" name="qttype" id="qttype"
                                                    value="{{ isset($userDetail['quartertype']) ? base64_encode($userDetail['quartertype']) : '' }}" />


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
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');  // This assumes you have the CSRF token in the meta tag
                    var uid = "{{ $userDetail['id'] }}"; // Inject PHP variable into JS
                    var table = $('#quarter_application').DataTable({
                        processing: true,
                        serverSide: true,
                        data: {
                        uid: uid,
                        _token: csrfToken // Include CSRF token here
                    },
                        ajax: {
                            url: "{{ route('ddo.getUserQuarterApplication') }}",
                            'type': 'POST',
                        },


                        columns: [{
                                data: 'requesttype'
                            },
                            {
                                data: 'quartertype'
                            },
                            {
                                data: 'inward_no'
                            },
                            {
                                data: 'inward_date'
                            },
                            {
                                data: 'name'
                            },
                            {
                                data: 'office'
                            },
                            {
                                data: 'contact_no'
                            },
                            {
                                data: 'email'
                            },
                            {
                                data: 'request_date'
                            },
                            {
                                data: 'action'
                            },
                            //  {data: 'delete'},
                        ]
                    });
                </script>
                @endpush