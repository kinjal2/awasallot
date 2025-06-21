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
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-header card-new_head text-white">
                        <h3 class="card-title ">Employee Details</h3>
                    </div>
                    <div class="card-body">
                    <div class="">
                <div class="">
                    <div class="widget-signups">
                        <div class=" usr_hd">
                            <div class="card-header custom-header">Basic Details</div>
                            <div class="">
                                <div class="col-lg-12 p-0">
                                    <div class="card_user px-3 py-4">
                                    <div class="user_details_block">
                                        <div class="row user_details_view">
                                        <div class="col-sm-6">
                                            <h6 class="mb-0">ક્વાર્ટર કેટેગરી <span>:</span></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p> {{ isset($quarterrequest) ? $quarterrequest['quartertype'] : 'N/A' }} </p>
                                        </div>
                                        </div>
                                        <div class="row user_details_view">
                                        <div class="col-sm-6">
                                            <h6 class="mb-0">યુઝર નંબર<span>:</span></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p> {{ isset($quarterrequest) ? $quarterrequest['uid'] : 'N/A' }} </p>
                                        </div>
                                        </div> 
                                        <div class="row user_details_view">
                                        <div class="col-sm-6">
                                            <h6 class="mb-0">નામ(પુરેપુરૂ)<span>:</span></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p> {{ isset($quarterrequest) ? $quarterrequest['name'] : 'N/A' }} </p>
                                        </div>
                                        </div>
                                        <div class="row user_details_view">
                                        <div class="col-sm-6">
                                            <h6 class="mb-0">પરણિત/અપરણિત <span>:</span></h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p> {{ isset($quarterrequest) ? $quarterrequest['maratial_status'] : 'N/A' }} </p>
                                        </div>
                                    </div>
                                    <div class="row user_details_view">
                                        <div class="col-sm-6">
                                        <h6 class="mb-0">વતન નું સરનામું <span>:</span></h6>
                                        </div>
                                        <div class="col-sm-6">
                                        <p> {{ isset($quarterrequest) ? $quarterrequest['address'] : 'N/A' }} </p>
                                        </div>
                                    </div>
                                    <div class="row user_details_view">
                                    <div class="col-sm-6">
                                        <h6 class="mb-0">જન્મ તારીખ <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p>  {{ isset($quarterrequest) ? $quarterrequest['date_of_birth'] : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                <div class="col-sm-6">
                                    <h6 class="mb-0">હોદ્દો <span>:</span></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['designation'] : 'N/A' }} </p>
                                </div>
                            </div>
                                    <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">કચેરી નું નામ<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['officename'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                    </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- --------------------------------------- -->

                <div class="">
                <div class="widget-signups">
                    <div class=" usr_hd">
                        <div class="card-header custom-header">Official Details</div>
                        <div class="">
                        <div class="col-lg-12 p-0">
                            <div class="card_user px-3 py-4">
                                <div class="user_details_block">
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">જે વિભાગ/કચેરીમાં કામ કરતા હોય તેનુ નામ <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['officename'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0"> જ્યાંથી બદલી થઈ ને આવ્યા હોય /પ્રતિનિયુક્તિ ઉપર આવ્યા હોય ત્યાંનો હોદ્દો અને કચેરી નું નામ<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['old_office']  : 'N/A' }} </p>
                                     <p> {{ isset($quarterrequest) ?  $quarterrequest['old_designation'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                
                            <div class="row user_details_view">
                                <div class="col-sm-6">
                                    <h6 class="mb-0">પોતે કચેરી/વિભાગ ના વડા છે કે કેમ?	  <span>:</span></h6>
                                </div>
                                <div class="col-sm-6">
                                    <p>  {{ isset($quarterrequest) ? $quarterrequest['is_dept_head'] : 'N/A' }} </p>
                                </div>
                            </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">કચેરી નું નામ<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['officename'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">ગાંધીનગર ખાતે હાજર થયા તારીખ <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['deputation_date'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                
                                
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">નિવ્રૂત્તિ ની તારીખ <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p>  {{ isset($quarterrequest) ? $quarterrequest['date_of_retirement'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">જી.પી.એફ. ખાતા નંબર <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['gpfnumber'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                </div>  
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- --------------------------------------- -->

                <div class="">
                <div class="widget-signups">
                    <div class=" usr_hd">
                        <div class="card-header custom-header">Salary Details</div>
                        <div class="">
                        <div class="col-lg-12 p-0">
                            <div class="card_user px-3 py-4">
                                <div class="user_details_block">
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ્<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['appointment_date'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">પગાર નો સ્કેલ (વિગતવાર આપવો) <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['salary_slab'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">ખરેખર મળતો પગાર <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p>  {{ isset($quarterrequest) ? $quarterrequest['actual_salary'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">મૂળ પગાર <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['basic_pay'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">પર્સનલ પગાર<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['personal_salary'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0"> સ્પેશ્યલ પગાર <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['special_salary'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0">પ્રતિનિયુક્તિ ભથ્થું<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['deputation_allowance'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-6">
                                    <h6 class="mb-0"> કુલ પગાર રૂ.<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-6">
                                    <p> @php  $total = $quarterrequest['basic_pay'] + $quarterrequest['personal_salary'] +  $quarterrequest['special_salary'] +  $quarterrequest['deputation_allowance'] @endphp {{ $total }} </p>
                                    </div>
                                </div>
                                </div>  
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- --------------------------------------- -->

                <div class=" mb-4">
                <div class="widget-signups">
                    <div class=" usr_hd">
                        <div class="card-header custom-header">Government Quarters Details</div>
                        <div class="">
                        <div class="col-lg-12 p-0">
                            <div class="card_user px-3 py-4">
                                <div class="user_details_block">
                                
                                        
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">આ પહેલા ના સ્થ્ળે સરકારશ્રીએ વસવાટ ની સવલત આપી હોય તો <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p>  </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">કોલોની નું નામ/રીક્વીઝીશન કરેલ મકાન ની વિગત <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['prv_area_name'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">વસવાટ નો ક્વાર્ટર નંબર <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['prv_building_no'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">વસવાટ ની કેટેગરી <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['prv_quarter_type'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">મકાન મળતાં ઉપર દર્શાવેલ મકાન સરકારને તુરત પાછું આપવામાં આવશે કે કેમ્?<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['prv_handover'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">માસીક ભાડું <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['prv_rent'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">અગાઉ ગાંધીનગર માં મકાન મેળવવા અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ છે? <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest) ? $quarterrequest['have_old_quarter'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0"> તારીખ, નંબર, બ્લોક વિગેરે વિગત <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p>  {{ isset($quarterrequest) ? $quarterrequest['old_quarter_details'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0"> શિડ્યુલ કાસ્ટ અથવા શિડ્યુલ ટ્રાઈબ ના કર્મચારી હોય તો તેમણે વિગત આપવી તથા કચેરીનાં વડાનું પ્રમાણપત્ર સામેલ કરવું<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest['is_scst']) ? $quarterrequest['is_scst'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">વિગત <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest['is_scst']) ? $quarterrequest['is_scst'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">ગાંધીનગર ખાતે જો રહેતા હોય તો કોની સાથે, તેમની સાથે નો સંબંધ અને મકાન ની વિગત <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest['is_relative']) ? $quarterrequest['is_relative'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">વિગત <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p>  {{ isset($quarterrequest['relative_details']) ? $quarterrequest['relative_details'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">ગાંધીનગર ખાતે માતા/પિતા. પતિ/પત્ની વગેરે લોહી ની સગાઈ જેવા સંબંધીને મકાન ફાળવેલ છે? <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest['is_relative_householder']) ? $quarterrequest['is_relative_householder'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0"> વિગત<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest['relative_house_details']) ? $quarterrequest['relative_house_details'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">ગાંધીનગર શહેર ની હદ માં અથવા સચિવાલય થી ૧૦ કિલોમીટર ની હદ માં અથવા ગાંધીનગર ની હદ
                                        માં આવતા ગમડાં માં તેમના પિતા/પતિ/પત્ની કે કુટુંબ ના કોઈપણ સભ્યને નામે રહેણાંકનું
                                        મકાન છે? <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> {{ isset($quarterrequest['have_house_nearby']) ? $quarterrequest['have_house_nearby'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0"> વિગત<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p>  {{ isset($quarterrequest['nearby_house_details']) ? $quarterrequest['nearby_house_details'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">  જો જાહેરહિતાર્થે બદલી થઈ ને ગાંધીનગર આવેલ હોય તો પોતે જે કક્ષા નું વસવાટ મેળવવાને પાત્ર હોય તે મળે ત્યાં સુધી તરત નીચલી કક્ષાનું વસવાટ મેળવવા માંગો છો?<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p>  {{ isset($quarterrequest['downgrade_allotment']) ? $quarterrequest['downgrade_allotment'] : 'N/A' }} </p>
                                    </div>
                                </div>
                                
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0"> સરકારશ્રી મકાન ફાળવણી અંગે જે સૂચનાઓ નિયમો બહાર પાડે તેનું પાલન કરવા
                                        હું સંમત છુ?<span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> હા </p>
                                    </div>
                                </div>
                                <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0">મારી બદલી થાય તો તે અંગે ની જાણ તુરત કરીશ <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p> હા </p>
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
                <form method="POST" name="ddo_submit_document_a" id="ddo_submit_document_a" action="{{route('ddo.editquarter.a.submitdocument')}}">
                @csrf
                    <!-- /.card -->
                    <div class="card-success">
                        <div class="card-header card-new_head text-white">
                            <h3 class="card-title">Attachments</h3>
                        </div>
                        <div class="card-body p-2">
                            <table class="table table-bordered table-hover table-striped">
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
                                                <img src="{{ URL::asset('images/pdf.png') }}" class="export-icon" style="width: 30px;" />
                                            </a>
                                        </td>
                                        <td>
                                            
                                            <input type="checkbox" class="file-checkbox" id="files[{{ $file->doc_id }}]"   name="files[{{ $file->doc_id }}]"  />
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                        <!-- /.card-body -->
                    </div>




                    <!-- /.card -->

                    <!-- for review 22-11-2024 -->
                    
                </div>
                <div class="card card-success">
                        <div class="card-header card-new_head text-white">
                            <h3 class="card-title">Review</h3>
                        </div>
                        <div class="card-body p-2">
                          
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-12" id="remarks">
                                            <div class="form-group">
                                                <label for="Name">Have Issue?</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="Name">Add Remarks</label>
                                                <input type="text" name="ddo_remarks" id="ddo_remarks" class="form-control" value="{{ isset($quarterrequest['ddo_remarks']) ? $quarterrequest['ddo_remarks'] : '' }}">
                                            </div>
                                            <div class="form-group">
        
                                                <div id="remark-message" class="mt-2"></div>
                                                @include(Config::get('app.theme').'.template.severside_message')
                                                @include(Config::get('app.theme').'.template.validation_errors')
                                                <button type="submit" class="btn btn-primary" id="submit_issue"
                                                    name="submit_issue" value="submit_issue" onclick="return validate();">Submit Review & Next</button>
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
                 function validate() {
                        remarks = $('#ddo_remarks').val().trim();
                       
                        if (remarks === '' || remarks === '{"remarks":null}' || remarks === null) {
                            $('#remark-message').html(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Please add remarks before submitting.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);

                            setTimeout(() => {
                                $('#remark-message .alert').alert('close');
                            }, 3000);
                            return false; // prevent form submission
                        }

                    return true; // allow submission
                }
                </script>
                <script>
                    
                 
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
