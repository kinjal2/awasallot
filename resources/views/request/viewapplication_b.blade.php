@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
@if(isset($quarterrequest->usermaster) && $quarterrequest->usermaster)
@php
$usermasterData = $quarterrequest->usermaster;
@endphp
@else
@php
$usermasterData = null;
@endphp

@endif
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
            <div class="col-md-7">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title ">Employee Details - Rivision Id - {{ $quarterrequest['rivision_id'] }}</h3>
                    </div>
                    <!-- /.card-header -->
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
                                                                <h6 class="mb-0">5) {{ ucfirst(strtolower(getDistrictByCode(Session::get('districtcode'),'gn','gn'))) }} માં અત્યારે જે કક્ષાના વસવાટમાં રહેતા હો તેની માહિતી નીચે પ્રમાણે આપવી.</h6>
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
                                                                <h6 class="mb-0 ms-4">( ચ) કયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.<span>:</span></h6>
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
                                                           <div class="col-sm-8">
                                                            <h6 class="mb-0">7) આપ કયા વિસ્તારમાં સરકારી આવાસ મેળવવા ઇચ્છો છો ? (શક્ય હોય તો ફાળવવામાં આવશે.)<span>:</span></h6>
                                                           </div>
                                                            <div class="col-sm-4"> <p class="m-0"> Choice 1 : {{ getAreaDetailsByCode($quarterrequest['choice1']) }} <br> Choice 2 : {{ getAreaDetailsByCode($quarterrequest['choice2']) }} <br> Choice 3 : {{ getAreaDetailsByCode($quarterrequest['choice3']) }}</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row user_details_view1">
                                                            <div class="col-sm-10">
                                                                <h6 class="mb-0">8) આ સાથે સામેલ રાખેલ ઉચ્ચ કક્ષાનું વસવાટ મેળવવાને લગતી સૂચનાઓ મેં વાંચી છે અને તે તથા સરકારશ્રી વખતો વખત આ અંગે સૂચનાઓ બહાર પાડે તેનું પાલન કરવા હું સંમત છું.<span>:</span></h6>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <p class="m-0"> હા </p>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-sm-12">
                                                                <h6 class="mb-0">9) હું, &nbsp;<span style="border-bottom: 1px dotted; text-decoration: none;"><b>{{ isset($quarterrequest) ? $quarterrequest['name'] : 'N/A' }}</b></span> &nbsp;ખાતરીપૂર્વક જાહેર કરૂ છું કે ઉપર જણાવેલ વિગતો મારી જાણ મુજબ સાચી છે અને જો તેમાં કોઇ વિગત ખોટી હશે તો તે અંગે આવાસ ફાળવણીના નિયમો બંધનકર્તા રહેશે.</label></h6>
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


                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
            <div class="col-md-5">
                <!-- Form Element sizes -->

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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <?php if (!empty($remarks) && count($remarks) > 0): ?>
                    <div class="card card-danger mt-3">
                        <div class="card-header">
                            <strong>Remarks</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Sr. No.</th>
                                        <th scope="col">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $co = 1; ?>
                                    <?php foreach ($remarks as $rem): ?>
                                        <tr>
                                            <td><?php echo $co++; ?></td>
                                            <td><?php echo htmlspecialchars($rem->description); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>



            </div>



            @endsection
            @push('page-ready-script')

            @endpush
            @push('footer-script')
            <script type="text/javascript">
                $('#status').change(function() {
                    if (this.value == 1) {
                        $('.yesno_status').show();
                    } else if (this.value == 0) {
                        $('.yesno_status').hide();
                    }
                });
                $("#front_annexurea").validate({
                    rules: {
                        status: "required",
                        dg_allotment: "required",

                    }
                });
            </script>
            @endpush