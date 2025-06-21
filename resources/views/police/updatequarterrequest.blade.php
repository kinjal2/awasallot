@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<style>
    .dg_allotment_row {
        display: none;
    }
</style>
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
                        <table border="1" style="text-align: left !important; border-collapse:collapse; " width="100%" align="left">
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
                                <th colspan="6" style="text-align: center;">ગાંધીનગર માં સરકારી વસવાટ મેળવવા માટે સરકારી કર્મચારી કે અધિકારી એ કરવા ની અરજી</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>ક્વાર્ટર કેટેગરી </th>
                                <td colspan="4">
                                    {{ isset($quarterrequest->requesttype)?$quarterrequest->requesttype:'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>યુઝર નંબર </th>
                                <td colspan="4">
                                    {{ isset($quarterrequest->uid)?$quarterrequest->uid:'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>1</th>
                                <th>નામ(પુરેપુરૂ)</th>
                                <td colspan="4"> {{ isset($quarterrequest->usermaster->name)?$quarterrequest->usermaster->name:'N/A' }} </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( અ ) હોદ્દો</th>
                                <td colspan="4">{{ isset($quarterrequest->usermaster->designation)?$quarterrequest->usermaster->designation:'N/A' }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>(બ ) પોતે કચેરી/વિભાગ ના વડા છે કે કેમ?</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest->usermaster->is_dept_head)?$quarterrequest->usermaster->is_dept_head:'N/A'}}
                                </td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <th>( અ ) જે વિભાગ/કચેરીમાં કામ કરતા હોય તેનુ નામ</th>
                                <td colspan="4">{{ isset($quarterrequest->usermaster->Office)?$quarterrequest->usermaster->Office:'N/A'}}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( બ ) જ્યાંથી બદલી થઈ ને આવ્યા હોય /પ્રતિનિયુક્તિ ઉપર આવ્યા હોય ત્યાંનો હોદ્દો અને કચેરી નું નામ</th>
                                <td><strong>હોદ્દો</strong></td>
                                <td>{{ isset($quarterrequest->old_designation)?$quarterrequest->old_designation:'N/A'}} </td>
                                <td><strong>કચેરી નું નામ</strong></td>
                                <td>{{ isset($quarterrequest->old_office)?$quarterrequest->old_office:"N/A"}}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ક ) ગાંધીનગર ખાતે હાજર થયા તારીખ</th>
                                <td colspan="4">{{ isset($quarterrequest->deputation_date)?date('d-m-Y',strtotime($quarterrequest->deputation_date)):'N/A'}}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ડ ) વતન નું સરનામું</th>
                                <td colspan="4">{{ isset($quarterrequest->address)?$quarterrequest->address:'N/A'}}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th> (ઇ) જન્મ તારીખ</th>
                                <td colspan="4">{{ isset($quarterrequest->date_of_birth)?date('d-m-Y',strtotime($quarterrequest->date_of_birth)):'N/A' }}

                                </td>
                            </tr>

                            <tr>
                                <th></th>
                                <th>( ઈ ) નિવ્રૂત્તિ ની તારીખ</th>
                                <td colspan="4">{{ isset($quarterrequest->date_of_retirement)?date('d-m-Y',strtotime($quarterrequest->date_of_retirement)):'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ફ ) જી.પી.એફ. ખાતા નંબર</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest->gpfnumber)?$quarterrequest->gpfnumber:'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <th>સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ્ </th>
                                <td colspan="4"> {{ isset($quarterrequest->appointment_date)?date('d-m-Y',strtotime($quarterrequest->appointment_date)):'N/A' }}

                                </td>
                            </tr>

                            <tr>
                                <th>4</th>
                                <th>( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો) </th>
                                <td colspan="4">{{ isset($quarterrequest->salary_slab)?$quarterrequest->salary_slab:"N/A" }} </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( બ ) ખરેખર મળતો પગાર</th>
                                <td colspan="4"> {{ isset($quarterrequest->actual_salary)? $quarterrequest->actual_salary:'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૧ ) મૂળ પગાર</th>
                                <td colspan="4">{{ isset($quarterrequest->basic_pay)? $quarterrequest->basic_pay:'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૨ ) પર્સનલ પગાર</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest->personal_salary)?$quarterrequest->personal_salary:'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૩ ) સ્પેશ્યલ પગાર</th>
                                <td colspan="4">
                                    {{ isset($quarterrequest->special_salary)?$quarterrequest->special_salary:'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>( ૪ ) પ્રતિનિયુક્તિ ભથ્થું</th>
                                <td colspan="4"> {{ isset($quarterrequest->deputation_allowance)?$quarterrequest->deputation_allowance:'N/A' }}

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
                                <td colspan="4">{{ isset($quarterrequest->maratial_status)?$quarterrequest->maratial_status:'N/A' }} </td>
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
                                <td> {{ isset($quarterrequest->prv_area_name)? $quarterrequest->prv_area_name:"N/A" }}
                                </td>
                                <td><strong>( બ ) વસવાટ નો ક્વાર્ટર નંબર</strong></td>
                                <td>{{ isset($quarterrequest->prv_building_no)?$quarterrequest->prv_building_no:'N/A' }} </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <td><strong>( ક-૧ )વસવાટ ની કેટેગરી</strong></td>
                                <td> {{ isset($quarterrequest->prv_quarter_type)?$quarterrequest->prv_quarter_type:'N/A' }}

                                </td>
                                <td><strong>(ક-૨) માસીક ભાડું</strong></td>
                                <td> {{ isset($quarterrequest->prv_rent)?$quarterrequest->prv_rent:'N/A' }}

                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <td><strong>( ડ ) મકાન મળતાં ઉપર દર્શાવેલ મકાન સરકારને તુરત પાછું આપવામાં આવશે કે કેમ્?</strong></td>
                                <td colspan="3">{{ isset($quarterrequest->prv_handover)?$quarterrequest->prv_handover:'N/A' }}

                                </td>
                            </tr>
                            <Tr>
                                <th>7</th>
                                <th>અગાઉ ગાંધીનગર માં મકાન મેળવવા અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ છે?</th>
                                <td> {{ isset($quarterrequest->have_old_quarter)?$quarterrequest->have_old_quarter:'N/A' }}


                                </td>
                                <td><strong>તારીખ, નંબર, બ્લોક વિગેરે વિગત </strong></td>
                                <td colspan="2"> {{ isset($quarterrequest->old_quarter_details)? $quarterrequest->old_quarter_details:'N/A' }}

                                </td>
                            </Tr>
                            <Tr>
                                <th>8</th>
                                <th>શિડ્યુલ કાસ્ટ અથવા શિડ્યુલ ટ્રાઈબ ના કર્મચારી હોય તો તેમણે વિગત આપવી તથા કચેરીનાં વડાનું પ્રમાણપત્ર સામેલ કરવું</th>
                                <td>


                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($quarterrequest->is_scst)?$quarterrequest->is_scst:'N/A' }}
                                </td>
                            </Tr>
                            <Tr>
                                <th>9</th>
                                <th>ગાંધીનગર ખાતે જો રહેતા હોય તો કોની સાથે, તેમની સાથે નો સંબંધ અને મકાન ની વિગત</th>
                                <td>
                                    {{ isset($quarterrequest->is_relative)?$quarterrequest->is_relative:'N/A' }}

                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2">
                                    {{ isset($quarterrequest->relative_details)?$quarterrequest->relative_details:'N/A' }}
                                </td>
                            </Tr>
                            <Tr>
                                <th>10</th>
                                <th>ગાંધીનગર ખાતે માતા/પિતા. પતિ/પત્ની વિગેરે લોહી ની સગાઈ જેવા સંબંધીને મકાન ફાળવેલ છે?</th>
                                <td> {{ isset($quarterrequest->is_relative_householder)?$quarterrequest->is_relative_householder :'N/A' }}


                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2"> {{ isset($quarterrequest->relative_house_details)?$quarterrequest->relative_house_details:'N/A' }}

                                </td>
                            </Tr>

                            <Tr>
                                <th>11</th>
                                <th>ગાંધીનગર શહેર ની હદ માં અથવા સચિવાલય થી ૧૦ કિલોમીટર ની હદ માં અથવા ગાંધીનગર ની હદ માં આવતા ગમડાં માં તેમના પિતા/પતિ/પત્ની કે કુટુંબ ના કોઈપણ સભ્યને નામે રહેણાંકનું મકાન છે?</th>
                                <td> {{ isset($quarterrequest->have_house_nearby)?$quarterrequest->have_house_nearby:'N/A' }}

                                </td>
                                <td><strong>વિગત </strong></td>
                                <td colspan="2"> {{ isset($quarterrequest->nearby_house_details)?$quarterrequest->nearby_house_details:'N/A' }}

                                </td>
                            </Tr>

                            <Tr>
                                <th>12</th>
                                <th colspan="3">જો બદલી થઈ ને ગાંધીનગર આવેલ હોય તો પોતે જે કક્ષા નું વસવાટ મેળવવાને પાત્ર હોય તે મળે ત્યાં સુધી તરત નીચી કક્ષાનું વસવાટ ફાળવી આપવા વિનંતી છે?</th>
                                <td colspan="2">
                                    {{ isset($quarterrequest->downgrade_allotment)?$quarterrequest->downgrade_allotment:'N/A' }}

                                </td>

                            </Tr>
                            <Tr>
                                <th>13</th>
                                <th colspan="3">સરકારશ્રી મકાન ફાળવણી અંગે જે સૂચનાઓ નિયમો બહાર પાડે તેનું પાલન કરવા હું સંમત છુ?</th>
                                <td colspan="2">હા</td>
                            </Tr>
                            <Tr>
                                <th>14</th>
                                <th colspan="3">મારી બદલી થાય તો તે અંગે ની જાણ તુરત કરીશ</th>
                                <td colspan="2">હા</td>
                            </Tr>
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
                    <div class="card-header">
                        <h3 class="card-title">Review</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('savepoliceapplication') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="Name">Status</label>
                                        <x-select
                                            name="status"
                                            :options="['' => __('common.select')] + getupdatestatus()"
                                            :selected="''"
                                            class="form-control select2"
                                            id="status" />


                                    </div>

                                    <div class="container mt-3">
                                        <div class="row dg_allotment_row">
                                            <div class="col-12">
                                                <strong>Remarks ?</strong>
                                            </div>
                                        </div>
                                        @foreach($remarks as $rem)
                                        <div class="row dg_allotment_row">
                                            <div class="col-12 d-flex align-items-center">
                                                <input type="checkbox" name="remarksArr[]" id="{{ $rem->remark_id }}" onclick="SelectRemarks(this);" />
                                                <span class="ml-2">{{ $rem->description }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="row dg_allotment_row">
                                            <div class="col-12 d-flex align-items-center">
                                                <input type="checkbox" name="remarksArr[]" id="O" onclick="SelectRemarks(this);" />
                                                <input type="text" name="other_remarks" id="other_remarks" class="form-control ml-2" style="flex-grow: 1;" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input type="hidden" name="requestid" value="{{ isset($quarterrequest->requestid)?$quarterrequest->requestid:'' }}" />
                                        <input type="hidden" name="rv" value="{{ isset($quarterrequest->rivision_id)?$quarterrequest->rivision_id:'' }}" />
                                        <input type="hidden" name="dgr" value="{{ isset($quarterrequest->dgrid)?$quarterrequest->dgrid:'' }}" />
                                        <input type="hidden" name="uid" value="{{ base64_encode($quarterrequest->uid);}}" />
                                        <input type="hidden" name="remarks" id="remarks" />

                                        <button type="submit" class="btn btn-primary">Save & Next</button>
                                    </div>
                                </div>
                            </div>
                        </form>

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
                                        <a href="{{ url('/download/'.$file->doc_id) }}" target="_blank">
                                            <img src="{{ URL::asset('images/pdf.png') }}" class="export-icon" />
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

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
                                    <label for="Name"> </label>

                                    <a href="{{ url('/download/'.$request->doc_id)  }}"><img src="{{ URL::asset('images/archive.png') }}" class="export-icon" /> </i></a>
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
                $('#status').change(function() {

                    if (this.value == 1) {

                        $('.dg_allotment_row').hide();
                    } else if (this.value == 0) {

                        $('.dg_allotment_row').show().addClass('required');
                    }
                });

                $("#front_annexurea").validate({
                    rules: {
                        status: "required",
                        dg_allotment: "required",

                    }
                });

                function SelectRemarks(obj) {
                    var remarks = "";
                    if (obj.id == 'O' && obj.checked) {
                        $("#other_remarks").removeAttr('disabled');
                    } else if (obj.id == 'O' && !obj.checked) {
                        $("#other_remarks").attr('disabled', true);
                    }

                    $("input[name='remarksArr[]']:checked").each(function() {
                        remarks += $(this).attr('id') + ",";
                    }); //alert(remarks);
                    $('#remarks').attr('value', remarks);
                }
            </script>
            @endpush