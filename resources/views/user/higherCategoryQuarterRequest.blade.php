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
    <!-- Nav tabs -->

<ul class="nav nav-tabs" id="quarterTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link  {{ session('active_tab') != 'tab2' ? 'active' : '' }}" id="request-tab" data-bs-toggle="tab" data-bs-target="#request" type="button" role="tab" aria-controls="request" aria-selected="true" class="nav-link" >
            Employee Details
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link {{ session('active_tab') == 'tab2' ? 'active' : '' }}" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false" >
            Request Form
        </button>
    </li>
</ul>
<!-- nav tabs over here -->
 <!-- Tab content -->
  
<div class="tab-content mt-3" id="quarterTabContent">
    <div class="tab-pane fade {{ session('active_tab') != 'tab2' ? 'show active' : '' }}" id="request" role="tabpanel" aria-labelledby="request-tab" >
        {{-- Tab 1 content: New Request --}}
        <!-- <p>Here you can place your form or inputs for a new request.</p> -->
           <div class="card card-head">
         <div class="card-header">
            <h3 class="card-title">{{ __('profile.user_detail') }}</h3>
         </div>
         @include(Config::get('app.theme').'.template.severside_message')
         @include(Config::get('app.theme').'.template.validation_errors')
         <!-- /.card-header -->
         <!-- form start -->
         <form method="POST" action="{{ url('profiledetails') }}" enctype="multipart/form-data" name='frm' id="frm">
            @csrf
            <input type="hidden" id="request_form" name="request_form" value="request_form">
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
                  <div class="col-md-3 avatar-upload_block">
                       
                     <div class="avatar-upload">
                        <div class="avatar-edit">
                           <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                           <label for="image"><i class="fas fa-upload"></i></label>
                        </div>
                        <div class="avatar-preview">
                           @if ($imageData)
                           <div id="imagePreview" style="background-image: url('data:image/jpeg;base64,{{ base64_encode($imageData) }}');"> </div>
                           @else
                           <div id="imagePreview" style="background-image: url('images/no-image.jpg');"> </div>
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
                        placeholder="Select Marital Status"
                     />
                     </div>
                  </div>
                  <!-- <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="exampleInputFile"> {{  __('profile.upload_photo') }}</label>
                        <div class="input-group">
                           <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image" name="image">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                           <div class="input-group-append">
                              <span class="input-group-text" id="">Upload</span>
                           </div>
                        </div>
                     </div>
                  </div>
              
                  
                  </div> -->
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="is_dept_head"> {{ __('profile.is_head') }} <span class="error">*</span></label>
                        <x-select 
                        name="is_dept_head"
                        :options="['' => 'Select An Option'] + getYesNo()"
                        :selected="$users->is_dept_head ?? ''"
                        class="form-control select2"
                        id="is_dept_head"
                     />

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
                           id="is_transferable"
                        />

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
                        placeholder="Select An Option"
                     />

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
                           placeholder="Select An Option"
                        />

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
                           id="grade_pay"
                        />

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
                              id="is_judge"
                           />
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
                              id="is_phy_dis"
                           />

                        </div>
                     </div>
                     <div class="col-md-3" id='dis_per_yes' style="display:none">
                        <div class="form-group">
                           <label for="dis_per">{{ __('profile.dis_per') }} <span class="error">*</span></label>
                           <input type="text" class="form-control" value="{{isset($users->dis_per)?$users->dis_per:0}}" id="dis_per" placeholder="Enter..." name="dis_per">
                          
                        </div>
                     </div>
                    <!-- <div class="col-md-3" id='dis_per_certi_yes' style="display:none">
                        <div class="form-group">
                           <label for="dis_per_certi">{{ __('profile.dis_per_certi') }} <span class="error">*</span></label>
                           <input type="text" class="form-control" value="{{ isset($users->dis_per_certi)?$users->dis_per_certi:'' }}" id="dis_per_certi" placeholder="Enter..." name="dis_per_certi" readonly>
                           <input type="file" name="dis_certi" id="dis_certi">


                        </div>
                     </div>-->

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
                  <button type="submit" class="btn btn-primary"> Next</button>
               </div>
               <div class="mt-4">
                  <span class="text-danger">Fields marked with *  are mandatory to fill. </span>
               </div>
            </div>
         </form>
      </div>
    </div>
    <div class="tab-pane fade {{ session('active_tab') == 'tab2' ? 'show active' : '' }}" id="history" role="tabpanel" aria-labelledby="history-tab" >
        {{-- Tab 2 content: Request History --}}
        <!-- <p>Here you can display a table or list of previous requests.</p> -->
         <div class="row px-3">
        <div class="col-md-12">
            <div class="card  card-head">
                <div class="card-header">
                    <h3 class="card-title">{{ __('menus.Higher Category Quarter') }}</h3>
                </div>
                <div class="card-body">
                     @include(Config::get('app.theme').'.template.severside_message')
                                        @include(Config::get('app.theme').'.template.validation_errors')
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                    @endif
                    @php
                    //print_r($quarterequestb);
                    //echo $quarterequestb['uid'];
                    @endphp
                    <form method="POST" name="annexurea" id="annexurea" action="{{ url('saveHigherCategoryReq') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="cardex_no" name="cardex_no" value="{{session('cardex_no')}}" />
                        <input type="hidden" id="ddo_code" name="ddo_code" value="{{session('ddo_code')}}" />
                        @if( isset($quarterequestb['requestid']) && !empty($quarterequestb['requestid']))
                        <input type="hidden" id="requestid" name="requestid" value="{{$quarterequestb['requestid']}}" />
                        <input type="hidden" id="option" name="option" value="edit" />
                        @if(  $quarterequestb['app_admin']==1)
                        <input type="hidden" id="edit_type" name="edit_type" value="app_admin" />
                        @endif
                         @if( $quarterequestb['app_ddo']==1)
                        <input type="hidden" id="edit_type" name="edit_type" value="app_ddo" />
                        @endif
                        @endif
                        <input type="hidden" id="page" name="page" value="higher_request" />
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quartertype">{{ __('request.Quarter_category') }}</label> <span class="error">*</span>
                                        <x-select
                                            name="quartertype"
                                            :options="[null => __('common.select')] + getBasicPay()"
                                            :selected="$quarterequestb['quartertype'] ?? null"
                                            id="quartertype"
                                            class="form-control select2" />

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="lg-block">
                                    <div class="form-group ">
                                        <label class="question_bg"> {{ __('request.area_choice')}}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="mb-4 pb-2">Choice 1</label>
                                                <x-select
                                                    name="choice1"
                                                    :options="[null => __('common.select')] + qCategoryAreaMapping($quartertype)"
                                                    :selected="$quarterequestb['choice1'] ?? null"
                                                    id="choice1"
                                                    class="form-control"
                                                    onchange="updateChoiceOptions()" />

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="mb-4 pb-2">Choice 2</label>
                                                <x-select
                                                    name="choice2"
                                                    :options="[null => __('common.select')] + qCategoryAreaMapping($quartertype)"
                                                    :selected="$quarterequestb['choice2'] ?? null"
                                                    id="choice2"
                                                    class="form-control"
                                                    onchange="updateChoiceOptions()" />


                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="mb-4 pb-2">Choice 3</label>
                                                <x-select
                                                    name="choice3"
                                                    :options="[null => __('common.select')] + qCategoryAreaMapping($quartertype)"
                                                    :selected="$quarterequestb['choice3'] ?? null"
                                                    id="choice3"
                                                    class="form-control"
                                                    onchange="updateChoiceOptions()" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="card-header">

                                    <h3 class="card-title"> {{ __('request.presentaddressdata', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ]) }} </h3> <span class="error">*</span>
                                </div>
                                <div class="card-body border_light">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="prv_quarter_type">{{ __('request.quarter_type') }}</label> <span class="error">*</span>
                                                <x-select
                                                    name="prv_quarter_type"
                                                    :options="[null => __('common.select')] + getlowerquatercategory()"
                                                    :selected="$quarterequestb['prv_quarter_type'] ?? null"
                                                    id="prv_quarter_type"
                                                    class="form-control select2" />

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="prv_area">{{ __('request.area') }} </label> <span class="error">*</span>
                                                <x-select
                                                    name="prv_area"
                                                    :options="[null => __('common.select')] + getAreaDetails()"
                                                    :selected="$quarterequestb['prv_area'] ?? null"
                                                    id="prv_area"
                                                    class="form-control select2" />

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="prv_blockno">{{ __('request.blockno') }} </label> <span class="error">*</span>
                                                <input type="text" value="{{ $quarterequestb['prv_blockno'] }}" class="form-control" id="prv_blockno" name="prv_blockno" placeholder="Enter Block No ">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="prv_unitno">{{ __('request.unitno') }} </label> <span class="error">*</span>
                                                <input type="text" value="{{ $quarterequestb['prv_unitno'] }}" class="form-control" id="prv_unitno" name="prv_unitno" placeholder="Enter Unit No">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="prv_allotment_details">{{ __('request.allotment_details') }}</label> <span class="error">*</span>
                                                <input type="text" value="{{ $quarterequestb['prv_details'] }}" class="form-control" name="prv_allotment_details" id="prv_allotment_details" placeholder="Allotment Details">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="prv_possession_date">{{ __('request.possession_date') }}</label> <span class="error">*</span>
                                                <div class="input-group date dateformat" id="prv_possession_date" data-target-input="nearest">
                                                    <input type="text" value="{{ $quarterequestb['prv_possession_date'] }}" name="prv_possession_date" class="form-control datetimepicker-input" data-target="#prv_possession_date" />
                                                    <div class="input-group-append" data-target="#prv_possession_date" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>

                                                </div> <label id="prv_possession_date-error" class="error" for="prv_possession_date"></label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row form-group">
                                        <label class="card-title mb-3"> {{ __('request.higher_allotment')}} <span class="error">*</span> &nbsp;</label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="have_hc_quarter_y" name="have_hc_quarter_yn" value="Y" @if (!empty($quarterequestb['is_hc']) && $quarterequestb['is_hc']=='1' ) checked @endif>
                                                <label for="have_hc_quarter_y">{{ __('common.yes') }}</label>
                                            </div> &nbsp;&nbsp;
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="have_hc_quarter_n" name="have_hc_quarter_yn" value="N" @if (!empty($quarterequestb['is_hc']) && $quarterequestb['is_hc']=='0' ) checked @endif>
                                                <label for="have_hc_quarter_n">{{ __('common.no') }}</label>
                                            </div>
                                            <label id="have_hc_quarter_yn-error" class="error" for="have_hc_quarter_yn"></label>
                                        </div>
                                    </div>
                                    <div class="row have_hc_quarter transfer sm-block">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hc_quarter_type">{{ __('request.quarter_type') }}</label> <span class="error">*</span>
                                                <x-select
                                                    name="hc_quarter_type"
                                                    :options="[null => __('common.select')] + getlowerquatercategory()"
                                                    :selected="$quarterequestb['hc_quarter_type'] ?? null"
                                                    id="hc_quarter_type"
                                                    class="form-control select2" />

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hc_area">{{ __('request.area') }} </label> <span class="error">*</span>
                                                <x-select
                                                    name="hc_area"
                                                    :options="[null => __('common.select')] + getAreaDetails()"
                                                    :selected="$quarterequestb['hc_area'] ?? null"
                                                    id="hc_area"
                                                    class="form-control select2" />

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hc_blockno">{{ __('request.blockno') }} </label> <span class="error">*</span>
                                                <input type="text" value="{{ $quarterequestb['hc_blockno'] ?? null }}" class="form-control" id="hc_blockno" name="hc_blockno" placeholder="Enter Block No">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hc_unitno">{{ __('request.unitno') }} </label> <span class="error">*</span>
                                                <input type="text" value="{{ $quarterequestb['hc_unitno'] ?? null }}" class="form-control" id="hc_unitno" name="hc_unitno" placeholder="Enter Unit No">
                                            </div>
                                        </div>
                                        <div class="have_hc_quarter">
                                            <div class="form-group">
                                                <label for="Address">{{ __('request.allotment_details')}}</label> <span class="error">*</span>
                                                <textarea class="form-control" id="hc_allotment_details" name="hc_allotment_details" placeholder="Enter Allotment Detail" >{{ $quarterequestb['hc_details'] ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="">
                                            <div class="mt-3">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="agree_rules" name="agree_rules">
                                                    <label for="agree_rules"></label>
                                                </div>
                                                <label for="office_address">આ સાથે સામેલ રાખેલ ઉચ્ચ કક્ષાનું વસવાટ મેળવવાને લગતી સૂચનાઓ મેં વાંચી છે અને તે તથા સરકારશ્રી વખતો વખત આ અંગે સૂચનાઓ બહાર પાડે તેનું પાલન કરવા હું સંમત છું.</label> <span class="error">*</span>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="">
                                            <div class="mt-3">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="declaration" name="declaration">
                                                    <label for="declaration"></label>
                                                    <label style="padding: 0px !important;"> હું, &nbsp;<span style="border-bottom: 1px dotted; text-decoration: none;">{{ $name }}</span> &nbsp;ખાતરીપૂર્વક જાહેર કરૂ છું કે ઉપર જણાવેલ વિગતો મારી જાણ મુજબ સાચી છે અને જો તેમાં કોઇ વિગત ખોટી હશે તો તે અંગે આવાસ ફાળવણીના નિયમો બંધનકર્તા રહેશે.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    </div>
</div>
<!-- tab content over here-->

   
</div>


@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
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