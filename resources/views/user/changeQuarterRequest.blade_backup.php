@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h1 class="m-0 text-dark">Change Quarter Request</h1>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Change Quarter Request</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <div class="col-md-12 px-3">
        <div class="card card-head">
            <div class="card-header">
                <h3 class="card-title">User Details</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-11 p-4">
                        <ul class="flexlist">
                            <li class="flexlist-item"><span>{{ __('Department/Office Name') }}</span> : {{ $name }}</li>
                            <li class="flexlist-item"><span>{{ __('Designation') }}</span> : {{ $designation }}</li>
                            <li class="flexlist-item"><span>{{ __('Department/Office Name') }}</span> : {{ $officename }}</li>
                            <li class="flexlist-item"><span>{{ __('Is Department Head?') }}</span> :
                                <x-select name="is_dept_head" :options="getYesNo()" :selected="$users->is_dept_head ?? ''" id="is_dept_head" class="" disabled="disabled" />
                            </li>
                            <li class="flexlist-item"><span>{{ __('Original Appointment Date in Government') }}</span> : {{ $appointment_date }}</li>
                            <li class="flexlist-item"><span>{{ __('Native Address') }}</span> : {{ $address }}</li>
                            <li class="flexlist-item"><span>{{ __('Retirement Date') }}</span> : {{ $retirement_date }}</li>
                            <li class="flexlist-item"><span>{{ __('GPF Account Number') }}</span> : {{ $gpfnumber }}</li>
                            <li class="flexlist-item"><span>{{ __('Marital Status') }}</span> :
                                <select class="form_input_contact disabled" disabled>{!! $maratialstatusopt !!}</select>
                            </li>
                            <li class="flexlist-item"><span>{{ __('Salary Slab') }}</span> : {{ $salary_slab }}</li>
                            <li class="flexlist-item"><span>{{ __('Actual Salary') }}</span> : {{ $actual_salary }}</li>
                            <li class="flexlist-item"><span>{{ __('Basic Salary') }}</span> : {{ $basicpay }}</li>
                            <li class="flexlist-item"><span>{{ __('Personal Salary') }}</span> : {{ $personalpay }}</li>
                            <li class="flexlist-item"><span>{{ __('Special Salary') }}</span> : {{ $specialpay }}</li>
                            <li class="flexlist-item"><span>{{ __('Deputation Allowance') }}</span> : {{ $deputationpay }}</li>
                            <li class="flexlist-item"><span>{{ __('Total Salary') }}</span> : {{ $totalpay }}</li>
                        </ul>
                    </div>
                    <div class="col-md-1 py-4 request_user text-center">
                        @php $img = $image ? $image : 'noimg.jpeg'; @endphp
                        <img src="data:image/jpeg;base64,{{ base64_encode($imageData) }}" alt="User Image" height="100" width="100">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 px-3">
        <div class="card card-head m-0">
            <div class="card-header">
                <h3 class="card-title">Request Details</h3>
            </div>
        </div>

        <div class="card-body card">
            <form action="{{ url('/change-quarter-request') }}" method="POST">
                @csrf

                {{-- Quarter Category --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ક્વાર્ટર કેટેગરી</label>
                        <x-select name="quartertype" :options="[null => __('common.select')] + getBasicPay()" :selected="old('quartertype', '')" id="quartertype" class="form-control select2" />
                    </div>
                </div>

                <div class="row">

                    {{-- Current Residence Details --}}
                    <div class="col-md-6">
                        <div class="quater_bdr">
                            <div class="quater_head">હાલ ના વસવાટ ની વિગત</div>
                            <div class="row p-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>વસવાટ નો પ્રકાર</label>
                                        <select id="cur_quartertype" class="form-control" name="cur_quartertype" {{ $currentReadonly }}>
                                            {!! $quartertypeopt !!}
                                        </select>
                                        <input type="hidden" name="current_qaid" value="{{ $cur_qaid }}" />
                                        <input type="hidden" id="page" name="page" value="change_request" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>સેકટર</label>
                                        <select name="cur_areacode" id="cur_areacode" class="form-control select2">
                                            <option value="">{{ __('common.select') }}</option>
                                            @foreach (qCategoryAreaMapping($quartertype) as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>બ્લોક</label>
                                        <input type="text" class="form-control" id="cur_block_no" name="cur_block_no" value="{{ $cur_blockno }}" {{ $currentReadonly }} />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>યુનિટ</label>
                                        <input type="text" class="form-control" id="cur_unit_no" name="cur_unit_no" value="{{ $cur_unitno }}" {{ $currentReadonly }} />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>પઝેશન લીધા તારીખ</label>
                                        <input type="text" class="form-control date1" id="cur_possesion_date" name="cur_possesion_date" value="{{ $possesiondate }}" {{ $currentReadonly }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- YES/NO + Allotted Without Possession Section --}}
                    <div class="col-md-6">

                        {{-- YES / NO Question --}}
                        <div class="card border mb-3">
                            <div class="card-body py-3">
                                <label class="font-weight-bold mb-2">
                                    જો આપને હાલના વસવાટની કક્ષા કરતા ઉચ્ચ કક્ષાનુ આવાસ ફાળવણી થયેલ હોય અને તેનો કબજો સ્વિકાર્યા વગર બદલી "ક" ફોર્મ ભરવા માંગો છો કે કેમ?
                                </label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="have_hc_quarter_yn" id="hc_yes" value="Y"
                                            {{ old('have_hc_quarter_yn') == 'Y' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hc_yes">હા</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="have_hc_quarter_yn" id="hc_no" value="N"
                                            {{ old('have_hc_quarter_yn') == 'N' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hc_no">ના</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Allotted Without Possession Details (shown only when હા is selected) --}}
                        <div id="wo_possession_section" style="display: none;">
                            <div class="quater_bdr">
                                <div class="quater_head">મકાન નો કબજો સંભાળ્યા વિના બદલી અરજી કરી હોય તો તેને વિગત</div>
                                <div class="row p-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>કક્ષા</label>
                                            <select id="wo_quartertype" class="form-control" name="wo_quartertype" {{ $allottedReadonly }}>
                                                {!! $woqtypeopt !!}
                                            </select>
                                            <input type="hidden" name="wo_qaid" value="{{ $wo_qaid }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>સેકટર નંબર</label>
                                            <select id="wo_areacode" class="form-control" name="wo_areacode" {{ $allottedReadonly }}>
                                                {!! $woareaopt !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>બ્લોક નંબર</label>
                                            <input type="text" class="form-control" id="wo_block_no" name="wo_block_no" value="{{ $wo_blockno }}" {{ $allottedReadonly }} />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>યુનીટ નંબર</label>
                                            <input type="text" class="form-control" id="wo_unit_no" name="wo_unit_no" value="{{ $wo_unitno }}" {{ $allottedReadonly }} />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- End col-md-6 --}}

                </div>
                {{-- End row --}}

                {{-- Reason for change --}}
                <div class="col-md-6 mt-4">
                    <div class="form-group">
                        <label>વસવાટ બદલવા અંગે ના વિશિષ્ટ કારણો</label>
                        <textarea id="reason" name="reason" class="form-control required">{{ old('reason') }}</textarea>
                        @error('reason')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="clearfix"></div>

                {{-- Requested Sector Details --}}
                <div class="col-md-6 mt-4">
                    <div class="quater_bdr">
                        <div class="quater_head">જે સેકટરમાં વસવાટ બદલવાની માંગણી હોય તે વિગત</div>
                        <div class="row p-3">
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label>સેકટર</label>
                                    <select id="areacode" name="areacode" class="form-control required">
                                        {!! $areaopt !!}
                                    </select>
                                    @error('areacode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label>માળ ની વિગત</label>
                                    <select id="floor" name="floor" class="form-control required">
                                        <option value="">-- Select --</option>
                                        <option value="0" {{ old('floor') == '0' ? 'selected' : '' }}>ભોયતળિયું</option>
                                        <option value="1" {{ old('floor') == '1' ? 'selected' : '' }}>પહેલો માળ</option>
                                        <option value="2" {{ old('floor') == '2' ? 'selected' : '' }}>બીજો માળ</option>
                                    </select>
                                    @error('floor')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('page-ready-script')
@endpush

@push('footer-script')
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script type="text/javascript">
$(function () {

    // ── DateTimePicker ───────────────────────────────────────────────
    $('.date1').datetimepicker({
        format: 'DD-MM-YYYY'
    });

    // ── Show / Hide "wo_possession_section" based on Yes / No ────────
    function toggleWoPossession() {
        var selected = $('input[name="have_hc_quarter_yn"]:checked').val();
        if (selected === 'Y') {
            $('#wo_possession_section').slideDown(300);
        } else {
            $('#wo_possession_section').slideUp(300);
        }
    }

    // Run on page load to handle old() values after validation failure
    toggleWoPossession();

    // Run on every radio change
    $('input[name="have_hc_quarter_yn"]').on('change', function () {
        toggleWoPossession();
    });

    // ── jQuery Validation ────────────────────────────────────────────
    jQuery.validator.addMethod("cdate", function (value, element) {
        return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
    }, "Please specify the date in DD-MM-YYYY format");

    $("#annexurea").validate({
        rules: {
            quartertype:           "required",
            prv_quarter_type:      "required",
            prv_area:              "required",
            prv_blockno:           { required: true, number: true },
            prv_unitno:            { required: true, number: true },
            prv_allotment_details: "required",
            prv_possession_date:   { required: true, cdate: true },
            have_hc_quarter_yn:    "required",
            hc_quarter_type:       "required",
            hc_area:               "required",
            hc_blockno:            { required: true, number: true },
            hc_unitno:             { required: true, number: true },
            hc_allotment_details:  "required",
            agree_rules:           "required",
        }
    });

});
</script>
@endpush