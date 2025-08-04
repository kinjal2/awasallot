

                        @include(Config::get('app.theme').'.template.severside_message')
                        @include(Config::get('app.theme').'.template.validation_errors')
                        <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('savenewrequest') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="cardex_no" name="cardex_no" value="{{session('cardex_no')}}" />
                            <input type="hidden" id="ddo_code" name="ddo_code" value="{{session('ddo_code')}}" />
                            <input type="hidden" id="page" name="page" value="new_request" />
                              @if( isset($quarterequesta['requestid']) && !empty($quarterequesta['requestid']))
                                <input type="hidden" id="requestid" name="requestid" value="{{$quarterequesta['requestid']}}" />
                                <input type="hidden" id="option" name="option" value="edit" />
                                 @if(  $quarterequesta['app_admin']==1)
                                    <input type="hidden" id="edit_type" name="edit_type" value="app_admin" />
                                    @endif
                                    @if( $quarterequesta['app_ddo']==1)
                                    <input type="hidden" id="edit_type" name="edit_type" value="app_ddo" />
                                    @endif
                             @endif
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group">
                                            <label class="question_bg mb-3"> {{ __('request.Quarter_category') }} </label>
                                            <x-select 
                                                name="quartertype"
                                                :options="[null => __('common.select')] + getBasicPay()"
                                                :selected="$quarterequesta['quartertype'] ?? null"
                                                class="form-control"
                                                id="quartertype"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group">
                                            <label class="question_bg mb-3">{{ __('request.deputation_date', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ] ) }}</label>
                                            <div class="input-group date dateformat" id="deputation_date"
                                                data-target-input="nearest">
                                                <input type="text" value="{{$quarterequesta['deputation_date'] ?? null }}" name="deputation_date"
                                                    class="form-control datetimepicker-input" data-target="#deputation_date" />
                                                <div class="input-group-append" data-target="#deputation_date"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <label id="deputation_date-error" class="error" for="deputation_date"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group">
                                            <label class="question_bg">{{ __('request.cometransfer') }}</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="icheck-primary d-inline px-3">
                                                <input type="radio" id="deputation_y" name="deputation_yn" value="Y" @if (!empty($quarterequesta['old_designation']) || !empty($quarterequesta['old_office']) ) checked @endif>
                                                <label for="deputation_y">{{ __('common.yes') }}
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="deputation_n" name="deputation_yn" value="N" @if (empty($quarterequesta['old_designation']) && empty($quarterequesta['old_office']) ) checked @endif>
                                                <label for="deputation_n">{{ __('common.no') }}
                                                </label>
                                            </div>
                                            <label id="deputation_yn-error" class="error" for="deputation_yn"></label>
                                        </div>
                                        <div class="row transfer sm-block">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Office">{{ __('common.designation') }}</label>
                                                    <input class="form-control" name="old_desg" id="old_desg" type="text" value="{{$quarterequesta['old_designation'] ?? null }}"
                                                        style="width:100%">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Office">{{ __('request.office_name') }}</label>
                                                    <input class="form-control" type="text" name="old_office" id="old_office"  value="{{$quarterequesta['old_office'] ?? null }}"
                                                        style="width:100%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group ">
                                            <label class="question_bg"> {{ __('request.beforerecidant') }}</label>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline px-3">
                                                <input type="radio" id="old_allocation_y" name="old_allocation_yn" value="Y" @if (!empty($quarterequesta['prv_rent']) || !empty($quarterequesta['prv_building_no'])  || !empty($quarterequesta['prv_area_name']) || !empty($quarterequesta['prv_quarter_type']) || !empty($quarterequesta['prv_handover'])) checked @endif>
                                                <label for="old_allocation_y">{{ __('common.yes') }}
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="old_allocation_n" name="old_allocation_yn" value="N" @if (empty($quarterequesta['prv_rent']) && empty($quarterequesta['prv_building_no']) && empty($quarterequesta['prv_area_name'])  && empty($quarterequesta['prv_quarter_type']) && empty($quarterequesta['prv_handover'])) checked @endif>
                                                <label for="old_allocation_n">{{ __('common.no') }}
                                                </label>
                                            </div>
                                            <label id="old_allocation_yn-error" class="error" for="old_allocation_yn"></label>
                                        </div>
                                        <div class="row place sm-block">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('request.monthly_rate')}}</label>
                                                    <input class="form-control" name="prv_rent" id="prv_rent" type="text" value="{{$quarterequesta['prv_rent'] ?? null }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('request.quarter_number_habitar')}}</label>
                                                    <input class="form-control" name="prv_building_no" id="prv_building_no" value="{{$quarterequesta['prv_building_no'] ?? null }}"
                                                        type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('request.colony _name')}}</label>
                                                    <input class="form-control" type="text" name="prv_area_name" value="{{$quarterequesta['prv_area_name'] ?? null }}"
                                                        id="prv_area_name" style="width:100%">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="mb-4 pb-2">{{ __('request.quarter_type')}}</label>
                                                    <x-select 
                                                    name="prv_quarter_type"
                                                    :options="[null => __('common.select')] + getBasicPay()"
                                                    :selected="$quarterequesta['prv_quarter_type'] ?? null"
                                                    class="form-control"
                                                    id="prv_quarter_type"
                                                />

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('request.will_above')}}</label>
                                                    <x-select 
                                                        name="prv_handover"
                                                        :options="getYesNo()"
                                                        :selected="$quarterequesta['prv_handover'] ?? null"
                                                        class="form-control"
                                                        id="prv_handover"
                                                    />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group ">
                                            <label class="question_bg mb-3">{{ __('request.beforeallot', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ] )}} </label>
                                            <div class="form-group">
                                                <div class="icheck-primary d-inline p-3">
                                                    <input type="radio" id="have_old_quarter_y" name="have_old_quarter_yn"  @if (!empty($quarterequesta['have_old_quarter']) && $quarterequesta['have_old_quarter']=='Y' ) checked @endif
                                                        value="Y">
                                                    <label for="have_old_quarter_y">{{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="have_old_quarter_n" name="have_old_quarter_yn" @if (!empty($quarterequesta['have_old_quarter']) && $quarterequesta['have_old_quarter']=='N' ) checked @endif
                                                        value="N">
                                                    <label for="have_old_quarter_n">{{ __('common.no') }}
                                                    </label>
                                                </div>
                                                <label id="have_old_quarter_yn-error" class="error"
                                                    for="have_old_quarter_yn"></label>
                                            </div>
                                        </div>
                                        <div class="row house sm-block">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>{{ __('request.details')}}</label>
                                                    <textarea class="form-control" name="old_quarter_details" 
                                                        id="old_quarter_details">{{$quarterequesta['old_quarter_details'] ?? null }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="lg-block">
                                        <div class="form-group">
                                            <label class="question_bg mb-3">{{ __('request.lives', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ])}}</label>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline p-3">
                                                    <input type="radio" id="is_relative_y" name="is_relative_yn" value="Y" @if (!empty($quarterequesta['is_relative']) && $quarterequesta['is_relative']=='Y' ) checked @endif>
                                                    <label for="is_relative_y">{{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="is_relative_n" name="is_relative_yn" value="N"  @if (!empty($quarterequesta['is_relative']) && $quarterequesta['is_relative']=='N' ) checked @endif>
                                                    <label for="is_relative_n">{{ __('common.no') }}
                                                    </label>
                                                </div>
                                                <label id="is_relative_yn-error" class="error" for="is_relative_yn"></label>
                                            </div>
                                        </div>
                                        <div class="row at_gandhinager sm-block">
                                            <div class="form-group">
                                                <label>{{ __('request.living_details') }}</label>
                                                <textarea class="form-control" name="relative_details"
                                                    id="relative_details">{{$quarterequesta['relative_details'] ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group">
                                            <label class="question_bg mb-3">{{ __('request.schedualcast', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ])}}</label>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline p-3">
                                                    <input type="radio" id="is_stsc_y" name="is_stsc_yn" value="Y" @if (!empty($quarterequesta['is_scst']) && $quarterequesta['is_scst']=='Y' ) checked @endif>
                                                    <label for="is_stsc_y">{{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="is_stsc_n" name="is_stsc_yn" value="N" @if (!empty($quarterequesta['is_scst']) && $quarterequesta['is_scst']=='N' ) checked @endif>
                                                    <label for="is_stsc_n">{{ __('common.no') }}
                                                    </label>
                                                </div>
                                                <label id="is_stsc_yn-error" class="error" for="is_stsc_yn"></label>
                                            </div>
                                        </div>
                                        <div class="row schedule sm-block">
                                            <div class="form-group">
                                                <label>{{ __('request.details')}}</label>
                                                <textarea class="form-control" name="scst_details" id="scst_details">{{$quarterequesta['scst_info'] ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group">
                                            <label class="question_bg mb-3">{{ __('request.relative', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ])}}</label>
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline p-3">
                                                    <input type="radio" id="is_relative_house_y" name="is_relative_house_yn"  @if (!empty($quarterequesta['is_relative_householder']) && $quarterequesta['is_relative_householder']=='Y' ) checked @endif
                                                        value="Y">
                                                    <label for="is_relative_house_y">{{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="is_relative_house_n" name="is_relative_house_yn"  @if (!empty($quarterequesta['is_relative_householder']) && $quarterequesta['is_relative_householder']=='N' ) checked @endif
                                                        value="N">
                                                    <label for="is_relative_house_n">{{ __('common.no') }}
                                                    </label>
                                                </div>
                                                <label id="is_relative_house_yn-error" class="error"
                                                    for="is_relative_house_yn"></label>
                                            </div>
                                        </div>
                                        <div class="with_parents sm-block">
                                            <div class="form-group">
                                                <label>{{ __('request.details')}}</label>
                                                <textarea class="form-control" id="relative_house_details"
                                                    name="relative_house_details">{{$quarterequesta['relative_house_details'] ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <label class="question_bg mb-3">{{ __('request.rearea', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ])}}</label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline p-3">
                                                <input type="radio" id="have_house_nearby_y" name="have_house_nearby_yn" @if (!empty($quarterequesta['have_house_nearby']) && $quarterequesta['have_house_nearby']=='Y' ) checked @endif
                                                    value="Y">
                                                <label for="have_house_nearby_y">{{ __('common.yes') }}
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="have_house_nearby_n" name="have_house_nearby_yn"  @if (!empty($quarterequesta['have_house_nearby']) && $quarterequesta['have_house_nearby']=='N' ) checked @endif
                                                    value="N">
                                                <label for="have_house_nearby_n">{{ __('common.no') }}
                                                </label>
                                            </div>
                                            <label id="have_house_nearby_yn-error" class="error"
                                                for="have_house_nearby_yn"></label>
                                        </div>
                                        <div class="row limit sm-block">
                                            <div class="form-group">
                                                <label>{{ __('request.details')}}</label>
                                                <textarea class="form-control" id="nearby_house_details"
                                                    name="nearby_house_details">{{$quarterequesta['nearby_house_details'] ?? null }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group ">
                                            <label class="question_bg"> {{ __('request.area_choice')}}</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="mb-4 pb-2">Choice 1</label>
                                                
                                                   <x-select 
                                                        name="choice1"
                                                        :options="[null => __('common.select')] + qCategoryAreaMapping($quartertype)"
                                                        :selected="$quarterequesta['choice1'] ?? null"
                                                        id="choice1"
                                                        class="form-control"
                                                        onchange="updateChoiceOptions()"
                                                    />

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="mb-4 pb-2">Choice 2</label>
                                                    <x-select 
                                                        name="choice2"
                                                        :options="[null => __('common.select')] + qCategoryAreaMapping($quartertype)"
                                                        :selected="$quarterequesta['choice2'] ?? null"
                                                        id="choice2"
                                                        class="form-control"
                                                        onchange="updateChoiceOptions()"
                                                    />

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="mb-4 pb-2">Choice 3</label>
                                                    <x-select 
                                                        name="choice3"
                                                        :options="[null => __('common.select')] + qCategoryAreaMapping($quartertype)"
                                                        :selected="$quarterequesta['choice3'] ?? null"
                                                        id="choice3"
                                                        class="form-control"
                                                        onchange="updateChoiceOptions()"
                                                    />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="mb-1">
                                            <label class="question_bg mb-3">{{ __('request.transeringandinagar', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ])}}</label>
                                            <x-select 
                                        name="downgrade_allotment"
                                        :options="getYesNo()"
                                        :selected="$quarterequesta['downgrade_allotment'] ?? null"
                                        class="form-control"
                                        id="downgrade_allotment"
                                    />
                                   
                                                                        

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">

                                    <div class="form-group icheck-primary d-inline question_bg mb-3 px-3">
                                        <input type="checkbox" id="agree_rules" name="agree_rules">
                                        <label for="agree_rules"></label>
                                        <label style="padding: 0px !important;">{{ __('request.govallotment', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ])}}</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="form-group icheck-primary d-inline question_bg mb-3 px-3">
                                        <input type="checkbox" id="agree_transfer" name="agree_transfer">
                                        <label for="agree_transfer"></label>
                                        <label style="padding: 0px !important;">{{ __('request.iftranser', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ])}}</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="form-group icheck-primary d-inline question_bg mb-3 px-3">
                                        <input type="checkbox" id="declaration" name="declaration">
                                        <label for="declaration"></label>
                                        <label style="padding: 0px !important;"> હું, &nbsp;<span style="border-bottom: 1px dotted; text-decoration: none;">{{ $name }}</span>  &nbsp;ખાતરીપૂર્વક જાહેર કરૂ છું કે ઉપર જણાવેલ વિગતો મારી જાણ મુજબ સાચી છે અને જો તેમાં કોઇ વિગત ખોટી હશે તો તે અંગે આવાસ ફાળવણીના નિયમો બંધનકર્તા રહેશે.</label>
                                    </div>
                                </div>
                               
                            </div>
                           @if( isset($quarterequesta['requestid']) && !empty($quarterequesta['requestid']))

                        <input type="hidden" id="requestid" name="requestid" value="{{$quarterequesta['requestid']}}" />
                        <input type="hidden" id="rivision_id" name="rivision_id" value="{{$quarterequesta['rivision_id']}}" />
                        <input type="hidden" id="option" name="option" value="edit" />
                                @if(  $quarterequesta['app_admin']==1)
                               <input type="hidden" id="edit_type" name="edit_type" value="admin" />
                                @endif
                                @if( $quarterequesta['app_ddo']==1)
                                <input type="hidden" id="edit_type" name="edit_type" value="ddo" />
                                @endif
                                <input type="hidden" value="{{ count($document_list) }}" id="document_list" name="document_list">
                                <div class="mt-4">
                                @if(  $document_list->count()  > 0)
                                   <input type="hidden" value="{{ $isEdit ?? 0 }}" id="isEdit" name="isEdit">
                                <button type="submit" class="btn btn-primary" value="next" name="submit" id="submit">Next</button>
                                @else
                                <button type="submit" class="btn btn-primary" value="save" name="submit" id="submit">Save Application</button>
                                @endif
                        </div>
                       @else
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" value="submit" name="submit" id="submit">Submit</button>
                        </div>
                         @endif																				  

                        </form>
 @push('footer-script') <script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script type="text/javascript">
    $(function() {
        // Bootstrap DateTimePicker v4
        $('.dateformat').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    });
    $(document).ready(function() {
        updateChoiceOptions();
       // $('.transfer').hide();
       // Initial show/hide on page load
        var deputationValue = $('input[name=deputation_yn]:checked').val();
        if (deputationValue === 'Y') {
            $('.transfer').show();
        } else {
            $('.transfer').hide();
        }
         var allocationValue = $('input[name=old_allocation_yn]:checked').val();
        if (allocationValue === 'Y') {
            $('.place').show();
        } else {
            $('.place').hide();
        }
         var have_old_quarter_Value = $('input[name=have_old_quarter_yn]:checked').val();
        if (have_old_quarter_Value === 'Y') {
            $('.house').show();
        } else {
            $('.house').hide();
        }
         var is_relativeValue = $('input[name=is_relative_yn]:checked').val();
        if (is_relativeValue === 'Y') {
            $('.at_gandhinager').show();
        } else {
            $('.at_gandhinager').hide();
        }
          var is_scstValue = $('input[name=is_stsc_yn]:checked').val();
        if (is_scstValue === 'Y') {
            $('.schedule').show();
        } else {
            $('.schedule').hide();
        }
           
            var is_relative_houseValue = $('input[name=is_relative_house_yn]:checked').val();
        if (is_relative_houseValue === 'Y') {
            $('.with_parents').show();
        } else {
            $('.with_parents').hide();
        }
         var have_house_near_byValue = $('input[name=have_house_nearby_yn]:checked').val();
        if (have_house_near_byValue === 'Y') {
            $('.limit').show();
        } else {
            $('.limit').hide();
        }
       // $('.place').hide();
        //$('.house').hide();
        //$('.at_gandhinager').hide();
      //  $('.schedule').hide();
       // $('.with_parents').hide();
       // $('.limit').hide();
        $('input[name=deputation_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.transfer').show();
            } else if (this.value == 'N') {
                $('.transfer').hide();
            }
        });
        $('input[name=old_allocation_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.place').show();
            } else if (this.value == 'N') {
                $('.place').hide();
            }
        });
        $('input[name=have_old_quarter_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.house').show();
            } else if (this.value == 'N') {
                $('.house').hide();
            }
        });
        $('input[name=is_relative_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.at_gandhinager').show();
            } else if (this.value == 'N') {
                $('.at_gandhinager').hide();
            }
        });
        $('input[name=is_stsc_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.schedule').show();
            } else if (this.value == 'N') {
                $('.schedule').hide();
            }
        });
        $('input[name=is_relative_house_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.with_parents').show();
            } else if (this.value == 'N') {
                $('.with_parents').hide();
            }
        });
        $('input[name=have_house_nearby_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.limit').show();
            } else if (this.value == 'N') {
                $('.limit').hide();
            }
        });
        jQuery.validator.addMethod("cdate", function(value, element) {
            return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
        }, "Please specify the date in DD-MM-YYYY format");
        $("#front_annexurea").validate({
            rules: {
                deputation_date: {
                    cdate: true
                },
                quartertype: "required",
                deputation_yn: "required",
                old_allocation_yn: "required",
                have_old_quarter_yn: "required",
                is_relative_yn: "required",
                is_stsc_yn: "required",
                is_relative_house_yn: "required",
                have_house_nearby_yn: "required",
                agree_rules: "required",
                agree_transfer: "required",
                choice1: "required",
                choice2: "required",
                choice3: "required",
                declaration : "required",
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
            errorPlacement: function (error, element) {
                error.appendTo(element.closest('.form-group'));
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element, errorClass, validClass) {
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
                  

