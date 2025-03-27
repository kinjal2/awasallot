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
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-11 p-4">
                    <ul class="flexlist">
                        <li class="flexlist-item"><span>{{ __('Department/Office Name') }} </span> : {{ $name }}</li>
                        <li class="flexlist-item"><span>{{ __('Designation') }} </span> : {{ $designation }}</li>
                        <li class="flexlist-item"><span>{{ __('Department/Office Name') }} </span> : {{ $officename }}</li>
                        <li class="flexlist-item"><span>{{ __('Is Department Head?') }} </span> : {{ Form::select('is_dept_head', getYesNo(), $users->is_dept_head ?? '', ['id' => 'is_dept_head', 'class' => ' ', 'disabled' => 'disabled']) }} </span></li>   
                        <li class="flexlist-item"><span>{{ __('Original Appointment Date in Government') }} </span> : {{ $appointment_date }}</li>
                        <li class="flexlist-item"><span>{{ __('Native Address') }} </span> : {{ $address }}</li>
                        <li class="flexlist-item"><span>{{ __('Retirement Date') }} </span> : {{ $retirement_date }}</li>
                        <li class="flexlist-item"><span>{{ __('GPF Account Number') }} </span> : {{ $gpfnumber }}</li>
                        <li class="flexlist-item"><span>{{ __('Marital Status') }} </span> : <select class="form_input_contact disabled" disabled>{!! $maratialstatusopt !!}</select></li>
                        <li class="flexlist-item"><span>{{ __('Salary Slab') }} </span> : {{ $salary_slab }}</li>
                        <li class="flexlist-item"><span>{{ __('Actual Salary') }} </span> : {{ $actual_salary }}</li>
                        <li class="flexlist-item"><span>{{ __('Basic Salary') }} </span> : {{ $basicpay }}</li>
                        <li class="flexlist-item"><span>{{ __('Personal Salary') }} </span> : {{ $personalpay }}</li>
                        <li class="flexlist-item"><span>{{ __('Special Salary') }} </span> : {{ $specialpay }}</li>
                        <li class="flexlist-item"><span>{{ __('Deputation Allowance') }} </span> : {{ $deputationpay }}</li>
                        <li class="flexlist-item"><span>{{ __('Total Salary') }} </span> : {{ $totalpay }}</li>              
                    </ul>
                    </div>
                    <div class="col-md-1 py-4 request_user text-center">
                        @php
                            $img = $image ? $image : 'noimg.jpeg';
                        @endphp
                        <img src="data:image/jpeg;base64,{{ base64_encode($imageData) }}"  alt="CouchDB Image" height="100" width="100">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 px-3">
        <!-- general form elements -->
        <div class="card card-head m-0">
            <div class="card-header">
                <h3 class="card-title">Request Details</h3>                
            </div>
        </div>
        <div class="card-body card">
            <form action="{{ url('/change-quarter-request') }}" method="POST">
                @csrf
                
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Name">ક્વાર્ટર કેટેગરી</label>
                                {{ Form::select('quartertype', [null => __('common.select')] + getBasicPay(), '', ['id' => 'quartertype', 'class' => 'form-control select2']) }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="quater_bdr">
                                    <div class="quater_head">હાલ ના વસવાટ ની વિગત</div>
                                        <div class="row p-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">વસવાટ નો પ્રકાર</label>
                                                    <select id="cur_quartertype" class="form-control" name="cur_quartertype" {{ $currentReadonly }}>
                                                        {!! $quartertypeopt !!}
                                                    </select>
                                                    <input type="hidden" class="form-control" name="current_qaid" value="{{ $cur_qaid }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">સેકટર</label>
                                                    <select id="cur_areacode" class="form-control" name="cur_areacode" {{ $currentReadonly }}>
                                                        {!! $areaopt !!}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">બ્લોક</label>
                                                    <input type="text" class="form_input_contact form-control" id="cur_block_no" name="cur_block_no" value="{{ $cur_blockno }}" {{ $currentReadonly }} />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">યુનિટ</label>
                                                    <input type="text" class="form_input_contact form-control" id="cur_unit_no" name="cur_unit_no" value="{{ $cur_unitno }}" {{ $currentReadonly }} />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">પઝેશન લીધા તારીખ</label>
                                                    <input type="text" class="form_input_contact date1 form-control" id="cur_possesion_date" name="cur_possesion_date" value="{{ $possesiondate }}" {{ $currentReadonly }} />
                                                </div>
                                            </div>   
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="quater_bdr">
                                    <div class="quater_head">મકાન નો કબજો સંભાળ્યા વિના બદલી અરજી કરી હોય તો તેને વિગત</div>
                                        <div class="row p-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">કક્ષા</label>
                                                    <select id="wo_quartertype" class="form-control" name="wo_quartertype" {{ $allottedReadonly }}>
                                                        {!! $woqtypeopt !!}
                                                    </select>
                                                    <input type="hidden" name="wo_qaid" value="{{ $wo_qaid }}" />
                                                </div>
                                            </div>   
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">સેકટર નંબર</label>
                                                    <select id="wo_areacode" class="form-control" name="wo_areacode" {{ $allottedReadonly }}>
                                                    {!! $woareaopt !!}
                                                    </select>
                                                </div>
                                            </div>   
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">બ્લોક નંબર</label>
                                                    <input type="text" class="form_input_contact form-control" id="wo_block_no" name="wo_block_no" value="{{ $wo_blockno }}" {{ $allottedReadonly }} />
                                                </div>
                                            </div>   
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Name">યુનીટ નંબર</label>
                                                    <input type="text" class="form_input_contact form-control" id="wo_unit_no" name="wo_unit_no" value="{{ $wo_unitno }}" {{ $allottedReadonly }} />
                                                </div>
                                            </div>   
                                        </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mt-4">
                            <div class="form-group">
                                <label for="Name">વસવાટ બદલવા અંગે ના વિશિષ્ટ કારણો</label>
                                <textarea id="reason" name="reason" class="form-control required">{{ old('reason') }}</textarea>
                                    @error('reason')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>   

                        <div class="clearfix"></div>

                        <div class="col-md-6 mt-4">
                            <div class="quater_bdr">
                                <div class="quater_head">જે સેકટરમાં વસવાટ બદલવાની માંગણી હોય તે વિગત</div>
                                <div class="row p-3">
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="Name">સેકટર</label>
                                            <select id="areacode" name="areacode" class="form-control required">
                                                {!! $areaopt !!}
                                            </select>
                                            @error('areacode')
                                            <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>   
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label for="Name">માળ ની વિગત</label>
                                            <select id="floor" name="floor" class=" form-control required">
                                                <option value="">-- Select --</option>
                                                <option value="0" {{ old('floor') == 0 ? 'selected' : '' }}>ભોયતળિયું</option>
                                                <option value="1" {{ old('floor') == 1 ? 'selected' : '' }}>પહેલો માળ</option>
                                                <option value="2" {{ old('floor') == 2 ? 'selected' : '' }}>બીજો માળ</option>
                                            </select>
                                            @error('floor')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                    <button type="submit" class="btn btn-primary mt-3 px-2">Submit</button>
            </form>
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
