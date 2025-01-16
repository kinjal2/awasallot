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
                </div><!-- /.col -->
                <div class="col-md-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Change Quarter Request</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="col-md-12 px-3">
        <!-- general form elements -->
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
            <!-- /.card-header -->
            <!-- form start -->
           
                <div class="card-body">
                   
            <legend>{{ __('User Details') }}</legend>
            <table class="table table-bordered">
                <tr>
                    <th>{{ __('Photo') }}</th>
                    <th>{{ __('Name (Full Name)') }}</th>
                    <td>
                        <input type="text" class="form_input_contact disabled" value="{{ $name }}" disabled />
                    </td>
                    <th>{{ __('Designation') }}</th>
                    <td>
                        <input type="text" class="form_input_contact disabled" value="{{ $designation }}" disabled />
                    </td>
                </tr>
                <tr>
                    <td rowspan="3">
                        @php
                            $img = $image ? $image : 'noimg.jpeg';
                        @endphp
                        <img src="data:image/jpeg;base64,{{ base64_encode($imageData) }}"  alt="CouchDB Image" height="100" width="100">
                    </td>
                    <th>{{ __('Department/Office Name') }}</th>
                    <td>
                        <input type="text" class="form_input_contact disabled" value="{{ $officename }}" disabled />
                    </td>
                    <th>{{ __('Is Department Head?') }}</th>
                    <td>
                      {{ Form::select('is_dept_head', getYesNo(), $users->is_dept_head ?? '', ['id' => 'is_dept_head', 'class' => 'form-control select2 disabled', 'disabled' => 'disabled']) }}
                   </td>
                </tr>
                <tr>
                    <th>{{ __('Original Appointment Date in Government') }}</th>
                    <td>
                        <input type="text" class="form_input_contact disabled" id="appointment_date" name="appointment_date" value="{{ $appointment_date }}" disabled />
                    </td>
                    <th rowspan="2">{{ __('Native Address') }}</th>
                    <td rowspan="2">
                        <textarea id="address" rows="2" name="address" class="disabled" disabled>{{ $address }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>{{ __('Retirement Date') }}</th>
                    <td>
                        <input type="text" class="form_input_contact disabled" id="retirement_date" name="retirement_date" value="{{ $retirement_date }}" disabled />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <th>{{ __('GPF Account Number') }}</th>
                    <td>
                        <input type="text" class="form_input_contact disabled" id="gpfno" name="gpfno" value="{{ $gpfnumber }}" disabled />
                    </td>
                    <th>{{ __('Marital Status') }}</th>
                    <td>
                        <select class="form_input_contact disabled" disabled>
                            {!! $maratialstatusopt !!}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table width="100%">
                            <tr>
                                <th>{{ __('Salary Slab') }}</th>
                                <th>{{ __('Actual Salary') }}</th>
                                <th>{{ __('Basic Salary') }}</th>
                                <th>{{ __('Personal Salary') }}</th>
                                <th>{{ __('Special Salary') }}</th>
                                <th>{{ __('Deputation Allowance') }}</th>
                                <th>{{ __('Total Salary') }}</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form_input_contact disabled salary" value="{{ $salary_slab }}" disabled />
                                </td>
                                <td>
                                    <input type="text" class="form_input_contact disabled salary" id="actual_salary" name="actual_salary" value="{{ $actual_salary }}" disabled />
                                </td>
                                <td>
                                    <input type="text" class="form_input_contact disabled salary" id="basicsalary" name="basicsalary" value="{{ $basicpay }}" disabled />
                                </td>
                                <td>
                                    <input type="text" class="form_input_contact disabled salary" id="personalsalary" name="personalsalary" value="{{ $personalpay }}" disabled />
                                </td>
                                <td>
                                    <input type="text" class="form_input_contact disabled salary" id="specialsalary" name="specialsalary" value="{{ $specialpay }}" disabled />
                                </td>
                                <td>
                                    <input type="text" class="form_input_contact disabled salary" id="deputationallowence" name="deputationallowence" value="{{ $deputationpay }}" disabled />
                                </td>
                                <td>
                                    <input type="text" class="form_input_contact disabled salary" id="totalsalary" name="totalsalary" value="{{ $totalpay }}" disabled />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
      
                </div>
       
        <!-- /.card-body -->

        <!-- Request Details -->
        <h3>Request Details</h3>
        <div>
          
                <legend>Quarter Request Details</legend>
                <form action="{{ url('/change-quarter-request') }}" method="POST">
                    @csrf
                    <table width="100%" border="1">
                        <colgroup>
                            <col width="30%" />
                            <col width="70%" />
                        </colgroup>
                        <tr>
                            <th>ક્વાર્ટર કેટેગરી</th>
                            <td>
                                {{ Form::select('quartertype', [null => __('common.select')] + getBasicPay(), '', ['id' => 'quartertype', 'class' => 'form-control select2']) }}
                            </td>
                        </tr>
                      
                      <!--  @ if( $currentReadonly != "")-->
                        <tr>
                            <td colspan="2">
                                <table border="1" width="100%" style="text-align: center;">
                                    <tr>
                                        <th colspan="5">હાલ ના વસવાટ ની વિગત</th>
                                    </tr>
                                    <tr>
                                        <td><strong>વસવાટ નો પ્રકાર</strong></td>
                                        <td><strong>સેકટર</strong></td>
                                        <td><strong>બ્લોક</strong></td>
                                        <td><strong>યુનિટ</strong></td>
                                        <td><strong>પઝેશન લીધા તારીખ</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select id="cur_quartertype" name="cur_quartertype" {{ $currentReadonly }}>
                                                {!! $quartertypeopt !!}
                                            </select>
                                            <input type="hidden" name="current_qaid" value="{{ $cur_qaid }}" />
                                        </td>
                                        <td>
                                            <select id="cur_areacode" name="cur_areacode" {{ $currentReadonly }}>
                                                {!! $areaopt !!}
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form_input_contact" id="cur_block_no" name="cur_block_no" value="{{ $cur_blockno }}" {{ $currentReadonly }} />
                                        </td>
                                        <td>
                                            <input type="text" class="form_input_contact" id="cur_unit_no" name="cur_unit_no" value="{{ $cur_unitno }}" {{ $currentReadonly }} />
                                        </td>
                                        <td>
                                            <input type="text" class="form_input_contact date1" id="cur_possesion_date" name="cur_possesion_date" value="{{ $possesiondate }}" {{ $currentReadonly }} />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                       <!-- @ endif -->

                      <!--  @ if ($allottedReadonly != "") -->
                        <tr>
                            <td colspan="2">
                                <table border="1" width="100%" style="text-align: center;">
                                    <tr>
                                        <th colspan="4">મકાન નો કબજો સંભાળ્યા વિના બદલી અરજી કરી હોય તો તેને વિગત</th>
                                    </tr>
                                    <tr>
                                        <td><strong>કક્ષા</strong></td>
                                        <td><strong>સેકટર નંબર</strong></td>
                                        <td><strong>બ્લોક નંબર</strong></td>
                                        <td><strong>યુનીટ નંબર</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select id="wo_quartertype" name="wo_quartertype" {{ $allottedReadonly }}>
                                                {!! $woqtypeopt !!}
                                            </select>
                                            <input type="hidden" name="wo_qaid" value="{{ $wo_qaid }}" />
                                        </td>
                                        <td>
                                            <select id="wo_areacode" name="wo_areacode" {{ $allottedReadonly }}>
                                                {!! $woareaopt !!}
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form_input_contact" id="wo_block_no" name="wo_block_no" value="{{ $wo_blockno }}" {{ $allottedReadonly }} />
                                        </td>
                                        <td>
                                            <input type="text" class="form_input_contact" id="wo_unit_no" name="wo_unit_no" value="{{ $wo_unitno }}" {{ $allottedReadonly }} />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                      <!--  @ endif--->

                        <table>
        <!-- Reason for changing residence section -->
        <tr>
            <th>વસવાટ બદલવા અંગે ના વિશિષ્ટ કારણો</th>
            <td>
                <textarea id="reason" name="reason" class="required">{{ old('reason') }}</textarea>
                @error('reason')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
        </tr>

        <!-- Section for sector and floor -->
        <tr>
            <td colspan="2">
                <table border="1" style="text-align: center;" width="100%">
                    <tr>
                        <th colspan="2">જે સેકટરમાં વસવાટ બદલવાની માંગણી હોય તે વિગત</th>
                    </tr>
                    <tr>
                        <td><strong>સેકટર</strong></td>
                        <td><strong>માળ ની વિગત</strong></td>
                    </tr>
                    <tr>
                        <td> 
                    <select id="areacode" name="areacode" class="required">
                    {!! $areaopt !!}
                    </select>
                            @error('areacode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>
                        <td>
                            <select id="floor" name="floor" class="required">
                                <option value="">-- Select --</option>
                                <option value="0" {{ old('floor') == 0 ? 'selected' : '' }}>ભોયતળિયું</option>
                                <option value="1" {{ old('floor') == 1 ? 'selected' : '' }}>પહેલો માળ</option>
                                <option value="2" {{ old('floor') == 2 ? 'selected' : '' }}>બીજો માળ</option>
                            </select>
                            @error('floor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

    </form>
   
        </div> 
    </div>

   
</div>
<!-- /.card -->
</div>
<!-- /.content -->

@endsection

@push('page-ready-script')

@endpush

@push('footer-script')
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('/bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script type="text/javascript">
    $(function() {
        // Bootstrap DateTimePicker v4
        $('.dateformat').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    });

    $(document).ready(function() {
        $('.have_hc_quarter').hide();
        $('input[name=have_hc_quarter_yn][type=radio]').change(function() {
            if (this.value == 'Y') {
                $('.have_hc_quarter').show();
            } else if (this.value == 'N') {
                $('.have_hc_quarter').hide();
            }
        });

        jQuery.validator.addMethod("cdate", function(value, element) {
            return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
        }, "Please specify the date in DD-MM-YYYY format");

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
            }
        });
    });
</script>
@endpush
