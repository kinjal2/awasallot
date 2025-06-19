@extends(\Config::get('app.theme').'.master') @section('title', $page_title) @section('content') <div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('request.new_request') }}</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('common.home') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('request.new_request') }} </li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="row">
        <div class=" col-md-12">
            <div class="card  card-head">
                <div class="card-header">
                    <h3 class="card-title"> {{ __('request.request_details') }}</h3>
                </div>
                <div class="card-body">

                        @include(Config::get('app.theme').'.template.severside_message')
                        @include(Config::get('app.theme').'.template.validation_errors')
                        <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('savenewrequest') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="cardex_no" name="cardex_no" value="{{session('cardex_no')}}" />
                            <input type="hidden" id="ddo_code" name="ddo_code" value="{{session('ddo_code')}}" />
                            <input type="hidden" id="page" name="page" value="new_request" />
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <div class="form-group">
                                            <label class="question_bg mb-3"> {{ __('request.Quarter_category') }} </label>
                                            <x-select 
                                                name="quartertype"
                                                :options="[null => __('common.select')] + getBasicPay()"
                                                :selected="old('quartertype', '')"
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
                                                <input type="text" value="" name="deputation_date"
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
                                                <input type="radio" id="deputation_y" name="deputation_yn" value="Y">
                                                <label for="deputation_y">{{ __('common.yes') }}
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="deputation_n" name="deputation_yn" value="N">
                                                <label for="deputation_n">{{ __('common.no') }}
                                                </label>
                                            </div>
                                            <label id="deputation_yn-error" class="error" for="deputation_yn"></label>
                                        </div>
                                        <div class="row transfer sm-block">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Office">{{ __('common.designation') }}</label>
                                                    <input class="form-control" name="old_desg" id="old_desg" type="text"
                                                        style="width:100%">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Office">{{ __('request.office_name') }}</label>
                                                    <input class="form-control" type="text" name="old_office" id="old_office"
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
                                                <input type="radio" id="old_allocation_y" name="old_allocation_yn" value="Y">
                                                <label for="old_allocation_y">{{ __('common.yes') }}
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="old_allocation_n" name="old_allocation_yn" value="N">
                                                <label for="old_allocation_n">{{ __('common.no') }}
                                                </label>
                                            </div>
                                            <label id="old_allocation_yn-error" class="error" for="old_allocation_yn"></label>
                                        </div>
                                        <div class="row place sm-block">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('request.monthly_rate')}}</label>
                                                    <input class="form-control" name="prv_rent" id="prv_rent" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('request.quarter_number_habitar')}}</label>
                                                    <input class="form-control" name="prv_building_no" id="prv_building_no"
                                                        type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('request.colony _name')}}</label>
                                                    <input class="form-control" type="text" name="prv_area_name"
                                                        id="prv_area_name" style="width:100%">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="mb-4 pb-2">{{ __('request.quarter_type')}}</label>
                                                    <x-select 
                                                    name="prv_quarter_type"
                                                    :options="[null => __('common.select')] + getBasicPay()"
                                                    :selected="old('prv_quarter_type', '')"
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
                                                        :selected="old('prv_handover', '')"
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
                                                    <input type="radio" id="have_old_quarter_y" name="have_old_quarter_yn"
                                                        value="Y">
                                                    <label for="have_old_quarter_y">{{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="have_old_quarter_n" name="have_old_quarter_yn"
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
                                                        id="old_quarter_details"></textarea>
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
                                                    <input type="radio" id="is_relative_y" name="is_relative_yn" value="Y">
                                                    <label for="is_relative_y">{{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="is_relative_n" name="is_relative_yn" value="N">
                                                    <label for="is_relative_n">{{ __('common.no') }}
                                                    </label>
                                                </div>
                                                <label id="is_relative_yn-error" class="error" for="is_relative_yn"></label>
                                            </div>
                                        </div>
                                        <div class="row at_gandhinager sm-block">
                                            <div class="form-group">
                                                <label>જેની સાતે રહો ચો તેણી સાતે કોઈ સંબધ આને મકાન ની વિગત</label>
                                                <textarea class="form-control" name="relative_details"
                                                    id="relative_details"></textarea>
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
                                                    <input type="radio" id="is_stsc_y" name="is_stsc_yn" value="Y">
                                                    <label for="is_stsc_y">{{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="is_stsc_n" name="is_stsc_yn" value="N">
                                                    <label for="is_stsc_n">{{ __('common.no') }}
                                                    </label>
                                                </div>
                                                <label id="is_stsc_yn-error" class="error" for="is_stsc_yn"></label>
                                            </div>
                                        </div>
                                        <div class="row schedule sm-block">
                                            <div class="form-group">
                                                <label>સરકારશ્રી મકાન ફાળવણી અંગે જે સૂચનાઓ નિયમો બહાર પાડે તેનું પાલન કરવા હું
                                                    સંમત છુ.</label>
                                                <textarea class="form-control" name="scst_details" id="scst_details"></textarea>
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
                                                    <input type="radio" id="is_relative_house_y" name="is_relative_house_yn"
                                                        value="Y">
                                                    <label for="is_relative_house_y">{{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="is_relative_house_n" name="is_relative_house_yn"
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
                                                <label>વિગત</label>
                                                <textarea class="form-control" id="relative_house_details"
                                                    name="relative_house_details"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lg-block">
                                        <label class="question_bg mb-3">{{ __('request.rearea', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ])}}</label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline p-3">
                                                <input type="radio" id="have_house_nearby_y" name="have_house_nearby_yn"
                                                    value="Y">
                                                <label for="have_house_nearby_y">{{ __('common.yes') }}
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="have_house_nearby_n" name="have_house_nearby_yn"
                                                    value="N">
                                                <label for="have_house_nearby_n">{{ __('common.no') }}
                                                </label>
                                            </div>
                                            <label id="have_house_nearby_yn-error" class="error"
                                                for="have_house_nearby_yn"></label>
                                        </div>
                                        <div class="row limit sm-block">
                                            <div class="form-group">
                                                <label>વિગત</label>
                                                <textarea class="form-control" id="nearby_house_details"
                                                    name="nearby_house_details"></textarea>
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
                                                        selected=""
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
                                                        :selected="''"
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
                                                        :selected="''"
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
                                        :selected="old('downgrade_allotment', '')"
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
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    <!-- </div> -->
                  </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</div> @endsection @push('page-ready-script') @endpush @push('footer-script') <script
    src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ URL::asset(Config::get('app.theme_path').'/plugins/jquery-validation/additional-methods.min.js')}}">
</script>
<script type="text/javascript">
    $(function() {
        // Bootstrap DateTimePicker v4
        $('.dateformat').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    });
    $(document).ready(function() {
        updateChoiceOptions();
        $('.transfer').hide();
        $('.place').hide();
        $('.house').hide();
        $('.at_gandhinager').hide();
        $('.schedule').hide();
        $('.with_parents').hide();
        $('.limit').hide();
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


</script> @endpush
