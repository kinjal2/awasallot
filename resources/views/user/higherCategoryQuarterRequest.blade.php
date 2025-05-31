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
	<div class="row px-3">
        <div class="col-md-12">
            <div class="card  card-head">
                <div class="card-header">
                  <h3 class="card-title">{{ __('menus.Higher Category Quarter') }}</h3>
                </div>
                <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div><br />
                            @endif
                            <form method="POST" name="annexurea" id="annexurea" action="{{ url('saveHigherCategoryReq') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="cardex_no" name="cardex_no" value="{{session('cardex_no')}}" />
                                <input type="hidden" id="ddo_code" name="ddo_code" value="{{session('ddo_code')}}" />
                                <input type="hidden" id="page" name="page" value="higher_request" />
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quartertype">{{  __('request.Quarter_category') }}</label> <span class="error">*</span>
                                               <x-select  
                                                    name="quartertype"
                                                    :options="[null => __('common.select')] + getBasicPay()"
                                                    :selected="''"
                                                    id="quartertype"
                                                    class="form-control select2"
                                                />

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
                                                        :selected="''"
                                                        id="choice1"
                                                        class="form-control"
                                                        onchange="updateChoiceOptions()"
                                                    />

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
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
                                                <div class="col-md-3">
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

                                    <div class="mt-3">
                                        <div class="card-header">
                                           
                                            <h3 class="card-title"> {{ __('request.presentaddressdata', ['location' => ucfirst(strtolower(getDistrictByCode(Session::get('dcode')))) ]) }} </h3> <span class="error">*</span>
                                        </div>
                                        <div class="card-body border_light">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="prv_quarter_type">{{  __('request.quarter_type') }}</label>  <span class="error">*</span>
                                                        <x-select  
                                                            name="prv_quarter_type"
                                                            :options="[null => __('common.select')] + getlowerquatercategory()"
                                                            :selected="''"
                                                            id="prv_quarter_type"
                                                            class="form-control select2"
                                                        />

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                    <label for="prv_area">{{  __('request.area') }} </label>  <span class="error">*</span>
                                                    <x-select  
                                                        name="prv_area"
                                                        :options="[null => __('common.select')] + getAreaDetails()"
                                                        :selected="''"
                                                        id="prv_area"
                                                        class="form-control select2"
                                                    />

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                    <label for="prv_blockno">{{  __('request.blockno') }} </label>  <span class="error">*</span>
                                                    <input type="text" value=""  class="form-control" id="prv_blockno" name="prv_blockno" placeholder="Enter Block No ">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                    <label for="prv_unitno">{{  __('request.unitno') }} </label>  <span class="error">*</span>
                                                    <input type="text" value=""  class="form-control" id="prv_unitno" name="prv_unitno" placeholder="Enter Unit No">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label for="prv_allotment_details">{{  __('request.allotment_details') }}</label>  <span class="error">*</span>
                                                    <input type="text" value=""  class="form-control"  name="prv_allotment_details" id="prv_allotment_details" placeholder="Allotment Details">
                                                    </div>
                                                </div>
                                                    <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label for="prv_possession_date">{{  __('request.possession_date') }}</label>  <span class="error">*</span>
                                                        <div class="input-group date dateformat" id="prv_possession_date" data-target-input="nearest">
                                                            <input type="text" value="" name="prv_possession_date"  class="form-control datetimepicker-input" data-target="#prv_possession_date"/>
                                                            <div class="input-group-append" data-target="#prv_possession_date" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>

                                                        </div>	<label id="prv_possession_date-error" class="error" for="prv_possession_date"></label>
                                                            </div>
                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <label class="card-title mb-3"> અગાઉ ઉચ્ચ કક્ષાનું વસવાટ ફાળવવામાં આવેલ હતું કે કેમ ?  <span class="error">*</span> &nbsp;</label>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="have_hc_quarter_y" name="have_hc_quarter_yn" 	value="Y">
                                                            <label for="have_hc_quarter_y">{{  __('common.yes') }}</label>
                                                        </div> &nbsp;&nbsp;
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="have_hc_quarter_n" name="have_hc_quarter_yn" value="N">
                                                            <label for="have_hc_quarter_n">{{  __('common.no') }}</label>
                                                        </div>
                                                        <label id="have_hc_quarter_yn-error" class="error" for="have_hc_quarter_yn"></label>
                                                    </div>
                                            </div>
                                            <div class="row have_hc_quarter transfer sm-block" >
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="hc_quarter_type">{{  __('request.quarter_type') }}</label>  <span class="error">*</span>
                                                       <x-select  
                                                            name="hc_quarter_type"
                                                            :options="[null => __('common.select')] + getlowerquatercategory()"
                                                            :selected="''"
                                                            id="hc_quarter_type"
                                                            class="form-control select2"
                                                        />

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="hc_area">{{  __('request.area') }} </label>  <span class="error">*</span>
                                                        <x-select  
                                                            name="hc_area"
                                                            :options="[null => __('common.select')] + getAreaDetails()"
                                                            :selected="''"
                                                            id="hc_area"
                                                            class="form-control select2"
                                                        />

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="hc_blockno">{{  __('request.blockno') }} </label>  <span class="error">*</span>
                                                        <input type="text" value=""  class="form-control" id="hc_blockno" name="hc_blockno" placeholder="Enter Block No">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="hc_unitno">{{  __('request.unitno') }} </label>  <span class="error">*</span>
                                                        <input type="text" value=""  class="form-control" id="hc_unitno" name="hc_unitno" placeholder="Enter Unit No">
                                                    </div>
                                                </div>
                                                <div class="have_hc_quarter">
                                                    <div class="form-group">
                                                        <label for="Address">કયા નંબર, તારીખના ફાળવણી આદેશથી ઉપરોકત વસવાટ ફાળવવામાં આવેલ હતું.</label>  <span class="error">*</span>
                                                        <textarea class="form-control" id="hc_allotment_details" name="hc_allotment_details" placeholder="Enter Allotment Detail"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="">
                                                    <div class="mt-3">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="agree_rules" name="agree_rules" >
                                                            <label for="agree_rules"></label>
                                                        </div>
                                                        <label for="office_address">આ સાથે સામેલ રાખેલ ઉચ્ચગ કક્ષાનું વસવાટ મેળવવાને લગતી સૂચનાઓ મેં વાંચી છે અને તે તથા સરકારશ્રી વખતો વખત આ અંગે સૂચનાઓ બહાર પાડે તેનું પાલન કરવા હું સંમત છું.</label> <span class="error">*</span>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            
                                            <div class="row">
                                                <div class="">
                                                    <div class="mt-3">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="declaration" name="declaration">
                                                            <label for="declaration"></label>
                                                            <label style="padding: 0px !important;"> હું, &nbsp;<span style="border-bottom: 1px dotted; text-decoration: none;">{{ $name }}</span>  &nbsp;ખાતરીપૂર્વક જાહેર કરૂ છું કે ઉપર જણાવેલ વિગતો મારી જાણ મુજબ સાચી છે અને જો તેમાં કોઇ વિગત ખોટી હશે તો તે અંગે આવાસ ફાળવણીના નિયમો બંધનકર્તા રહેશે.</label>
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
        $('.have_hc_quarter').hide();
        $('input[name=have_hc_quarter_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.have_hc_quarter').show();
            }
            else if (this.value == 'N') {
                $('.have_hc_quarter').hide();
            }
        });
        jQuery.validator.addMethod("cdate",
            function (value, element)
            {
            return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
            },
            "Please specify the date in DD-MM-YYYY format"
        );

        $("#annexurea").validate({
            rules : {

                quartertype		:	"required",
                prv_quarter_type	:	"required",
                prv_area		:	"required",
                prv_blockno		:	{required:true,number:true},
                prv_unitno		:	{required:true,number:true},
                prv_allotment_details	:	"required",
                prv_possession_date	:	{required:true,cdate:true},
                have_hc_quarter_yn	:	"required",
                hc_quarter_type		:	"required",
                hc_area			:	"required",
                hc_blockno		:	{required:true,number:true},
                hc_unitno		:	{required:true,number:true},
                hc_allotment_details	:	"required",
                agree_rules:	"required",
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
                    console.log(data);  // Check the actual response data from the server
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
@endpush
