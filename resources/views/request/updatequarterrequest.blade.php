@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
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
                                        <div class="card-header custom-header">Basic Details <div class="sub_div"> (ક્વાર્ટર કેટેગરી: <span>{{ isset($quarterrequest) ? $quarterrequest['quartertype'] : 'N/A' }}</span>) (યુઝર નંબર: <span>{{ isset($quarterrequest) ? $quarterrequest['uid'] : 'N/A' }}</span>)</div>
                                        </div>
                                        <div class="">
                                            <div class="col-lg-12 p-0">
                                                <div class="card_user px-3 py-4">
                                                    <div class="user_details_block">
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">1) નામ(પુરેપુરૂ)<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['name'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4"> ( અ ) હોદ્દો <span>:</span></h6>
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
                                                                <h6 class="mb-0">2) ( અ ) જે વિભાગ/કચેરીમાં કામ કરતા હોય તેનુ નામ <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['officename'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( બ ) જ્યાંથી બદલી થઈ ને આવ્યા હોય /પ્રતિનિયુક્તિ ઉપર આવ્યા હોય ત્યાંનો હોદ્દો અને કચેરી નું નામ<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['old_office']  : 'N/A' }} </p>
                                                                <p class="m-0"> {{ isset($quarterrequest) ?  $quarterrequest['old_designation'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ક ) {{ ucfirst(strtolower(getDistrictByCode(Session::get('districtcode'),'gn','gn'))) }} ખાતે હાજર થયા તારીખ <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['deputation_date'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ડ ) વતન નું સરનામું <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['address'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">(ઇ) જન્મ તારીખ <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['date_of_birth'] : 'N/A' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ફ ) નિવ્રૂત્તિ ની તારીખ <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['date_of_retirement'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( જ ) જી.પી.એફ. ખાતા નંબર <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['gpfnumber'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">3) સરકારી નોકરીમાં મૂળ નિમણુંક તારીખ્<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['appointment_date'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">4) ( અ ) પગાર નો સ્કેલ (વિગતવાર આપવો) <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['salary_slab'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( બ ) ખરેખર મળતો પગાર <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['actual_salary'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ૧ ) મૂળ પગાર <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['basic_pay'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ૨ ) પર્સનલ પગાર<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['personal_salary'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ૩ ) સ્પેશ્યલ પગાર <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['special_salary'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ૪ ) પ્રતિનિયુક્તિ ભથ્થું<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['deputation_allowance'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0"> કુલ પગાર રૂ.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> @php $total = $quarterrequest['basic_pay'] + $quarterrequest['personal_salary'] + $quarterrequest['special_salary'] + $quarterrequest['deputation_allowance'] @endphp {{ $total }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">5) ( અ ) પરણિત/અપરણિત <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['maratial_status'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">6) આ પહેલા ના સ્થ્ળે સરકારશ્રીએ વસવાટ ની સવલત આપી હોય તો <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( અ ) કોલોની નું નામ/રીક્વીઝીશન કરેલ મકાન ની વિગત <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_area_name'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( બ ) વસવાટ નો ક્વાર્ટર નંબર <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_building_no'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ક ) વસવાટ ની કેટેગરી <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_quarter_type'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">(ક-૨) માસીક ભાડું <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_rent'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0 ms-4">( ડ ) મકાન મળતાં ઉપર દર્શાવેલ મકાન સરકારને તુરત પાછું આપવામાં આવશે કે કેમ્?<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['prv_handover'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <!-- <h6 class="mb-0">7) અગાઉ ગાંધીનગર માં મકાન મેળવવા અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ છે? <span>:</span></h6> -->
                                                                <h6 class="mb-0">7) અગાઉ {{ ucfirst(strtolower(getDistrictByCode(Session::get('districtcode'),'gn','gn'))) }} માં મકાન મેળવવા, અરજી કરવા માં આવી છે અથવા મકાન ફાળવેલ હોય તો તારીખ, નંબર, બ્લોક વિગેરેની સંદર્ભ માહિતી આપવી.(લાગુ ન પડતુ હોય ત્યાં “ના” લખવુ) <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest) ? $quarterrequest['have_old_quarter'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">8) શિડ્યુલ કાસ્ટ અથવા શિડ્યુલ ટ્રાઈબ ના કર્મચારી હોય તો તેમણે વિગત આપવી તથા કચેરીનાં વડાનું પ્રમાણપત્ર સામેલ કરવું<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['is_scst']) ? $quarterrequest['is_scst'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">-- વિગત <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['is_scst']) ? $quarterrequest['is_scst'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">9) {{ ucfirst(strtolower(getDistrictByCode(Session::get('districtcode'),'gn','gn'))) }} ખાતે જો રહેતા હોય તો કોની સાથે, તેમની સાથે નો સંબંધ અને મકાન ની વિગત <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['is_relative']) ? $quarterrequest['is_relative'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">-- વિગત <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['relative_details']) ? $quarterrequest['relative_details'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">10) {{ ucfirst(strtolower(getDistrictByCode(Session::get('districtcode'),'gn','gn'))) }} ખાતે માતા/પિતા. પતિ/પત્ની વગેરે લોહી ની સગાઈ જેવા સંબંધીને મકાન ફાળવેલ છે? <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['is_relative_householder']) ? $quarterrequest['is_relative_householder'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">-- વિગત<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['relative_house_details']) ? $quarterrequest['relative_house_details'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">11) {{ ucfirst(strtolower(getDistrictByCode(Session::get('districtcode'),'gn','gn'))) }} શહેર ની હદ માં અથવા સચિવાલય થી ૧૦ કિલોમીટર ની હદ માં અથવા {{ ucfirst(strtolower(getDistrictByCode(Session::get('districtcode'),'gn','gn'))) }} ની હદ
                                                                    માં આવતા ગમડાં માં તેમના પિતા/પતિ/પત્ની કે કુટુંબ ના કોઈપણ સભ્યને નામે રહેણાંકનું
                                                                    મકાન છે? <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['have_house_nearby']) ? $quarterrequest['have_house_nearby'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">-- વિગત<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['nearby_house_details']) ? $quarterrequest['nearby_house_details'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
														 <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">12) જો જાહેરહિતાર્થે બદલી થઈ ને {{ ucfirst(strtolower(getDistrictByCode(Session::get('districtcode'),'gn','gn'))) }} આવેલ હોય તો પોતે જે કક્ષા નું વસવાટ મેળવવાને પાત્ર હોય તે મળે ત્યાં સુધી તરત નીચલી કક્ષાનું વસવાટ મેળવવા માંગો છો?<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> {{ isset($quarterrequest['downgrade_allotment']) ? $quarterrequest['downgrade_allotment'] : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">13) આપ કયા વિસ્તારમાં સરકારી આવાસ મેળવવા ઇચ્છો છો ? (શક્ય હોય તો ફાળવવામાં આવશે.) <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                 <p class="m-0">
                                                                    Choice 1 : {{ isset($quarterrequest['choice1']) ? getAreaDetailsByCode($quarterrequest['choice1']) : 'N/A' }} <br> Choice 2 : {{ isset($quarterrequest['choice2']) ? getAreaDetailsByCode($quarterrequest['choice2']) : 'N/A' }} <br> Choice 3 : {{ isset($quarterrequest['choice3']) ? getAreaDetailsByCode($quarterrequest['choice3']) : 'N/A' }} </p>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0"> 14) સરકારશ્રી મકાન ફાળવણી અંગે જે સૂચનાઓ નિયમો બહાર પાડે તેનું પાલન કરવા
                                                                    હું સંમત છુ?<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> હા </p>
                                                            </div>
                                                        </div>
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-8">
                                                                <h6 class="mb-0">15) મારી બદલી થાય તો તે અંગે ની જાણ તુરત કરીશ <span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <p class="m-0"> હા </p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-sm-12">

                                                                <h6 class="mb-0">16) હું, &nbsp;<span style="border-bottom: 1px dotted; text-decoration: none; "><b>{{ isset($quarterrequest) ? $quarterrequest['name'] : 'N/A' }}</b></span> &nbsp;ખાતરીપૂર્વક જાહેર કરૂ છું કે ઉપર જણાવેલ વિગતો મારી જાણ મુજબ સાચી છે અને જો તેમાં કોઇ વિગત ખોટી હશે તો તે અંગે આવાસ ફાળવણીના નિયમો બંધનકર્તા રહેશે. </h6>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="row user_details_view">
                                    <div class="col-sm-8">
                                    <h6 class="mb-0"> તારીખ, નંબર, બ્લોક વિગેરે વિગત <span>:</span></h6>
                                    </div>
                                    <div class="col-sm-4">
                                    <p class="m-0">  {{ isset($quarterrequest) ? $quarterrequest['old_quarter_details'] : 'N/A' }} </p>
                                    </div>
                                </div> -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <!-- --------------------------------------- -->


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
                        <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('saveapplication') }}" enctype="multipart/form-data">
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
                                        <div class="col-12 yesno_status" id="yesno_status1">
                                            <div class="form-group">
                                                <label for="Name">Is Downgrade Allotment Allowed ?</label>
                                                <x-select
                                                    name="dg_allotment"
                                                    :options="[null => __('common.select')] + getYesNo()"
                                                    :selected="''"
                                                    id="dg_allotment"
                                                    class="form-control select2" />


                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <input type="hidden" name="requestid" value="{{ isset($quarterrequest['requestid'])?$quarterrequest['requestid']:'' }}" />
                                            <input type="hidden" name="rv" value="{{ isset($quarterrequest['rivision_id'])?$quarterrequest['rivision_id']:'' }}" />
                                            <input type="hidden" name="dgr" value="{{ isset($quarterrequest['dgrid'])?$quarterrequest['dgrid']:'' }}" />
                                            <input type="hidden" name="status" value="1" />

                                            <button type="submit" class="btn btn-primary" id="submit_doc" name="submit_doc">Save & Next</button>
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

                                        <input type="checkbox" class="file-checkbox" id="files[{{ $file->doc_id }}]" name="files[{{ $file->doc_id }}]" />
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
                                    @if($request->is_varified == 3)
                                    @php
                                    $url = url('/viewapplication/'.(base64_encode($request->requestid)).'/'.(base64_encode($request->rivision_id)).'/'.(base64_encode('a')));
                                    @endphp
                                    <a href="{{ $url }}">
                                        <img src="{{ URL::asset('images/archive.png') }}" class="export-icon" />
                                    </a>


                                    @if($request->rivision_id == 0)
                                    {{ "Application" }}
                                    @else
                                    {{ "Rivision ".$request->rivision_id }}
                                    @endif
                                    <br>
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
                            $('#adm_remarks').show(); // Show the remarks text input for "Other"
                        } else {
                            $('#adm_remarks').hide(); // Hide the remarks text input if "Other" is not selected
                        }
                    });

                    // Ensure the text box is hidden if no option is selected initially (or if "Other" is not selected)
                    var selectedValues = $('#admin_remarks').val();
                    if (!selectedValues || !selectedValues.includes('other')) {
                        $('#adm_remarks').hide(); // Hide remarks text input initially if "Other" is not selected
                    }
                });

                $("#front_annexurea").validate({
                    rules: {

                        dg_allotment: "required",

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