@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')

<div class="content">

    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Draw Excel Upload</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Draw Upload</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h3 class="card-title mb-0">Upload Draw Excel File</h3>

                <a href="{{ asset('sample/draw_sample.xlsx') }}"
                    class="btn btn-info btn-sm">
                    <i class="fa fa-download"></i> Download Sample Excel Format
                </a>

            </div>


            <div class="card-body">

                @include(Config::get('app.theme').'.template.severside_message')
                @include(Config::get('app.theme').'.template.validation_errors')

                <div class="row">

                    {{-- Upload Section --}}
                    <div class="col-md-6">

                        <div class="card shadow-sm border-0">

                            <div class="card-header bg-light">
                                <strong>Upload Draw Excel File</strong>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('draw.upload') }}" method="POST" enctype="multipart/form-data" name="uploadExcelForm" id="uploadExcelForm">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label>Quarter Type &nbsp;<span class="text-danger">*</span></label>

                                        <!-- <x-select
                                                name="quartertype"
                                                :options="$quartertype"
                                                id="quartertype"
                                                class="form-control select2"
                                                :selected="$selectedQuarter"
                                                /> -->
                                        <select name="quartertype" id="quartertype" class="form-control select2">
                                            <option value="J" selected>J</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Draw Date&nbsp;<span class="text-danger">*</span></label>

                                        <input type="date" name="draw_date" class="form-control" required>

                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Batch Title&nbsp;<span class="text-danger">*</span></label>

                                        <input type="text"
                                            name="batch_title"
                                            class="form-control"

                                            required>

                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Select Excel File&nbsp;<span class="text-danger">*</span></label>

                                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>

                                    </div>

                                    <span class="text-danger">Fields marked with * are mandatory to fill. </span>
                                    <!-- <a href="{{ asset('sample/draw_sample.xlsx') }}"
                                            class="btn btn-info w-100 mb-2">
                                            <i class="fa fa-download"></i> Download Sample Excel Format
                                        </a> -->

                                    <button type="submit"
                                        class="btn btn-success w-100 mb-2"

                                        @if($status=='verified' ) disabled @endif>
                                        {{-- @if($status == 'verified' || $status == 'final') disabled @endif> --}}


                                        <i class="fa fa-upload"></i> Upload Excel

                                    </button>


                                </form>



                                {{-- VERIFY BUTTON --}}
                                <form method="POST" action="{{ route('draw.verify.preview') }}" id="verifyForm">

                                    @csrf

                                    <input type="hidden" name="quartertype" id="verify_quartertype">

                                    <button type="button"
                                        id="verifyBtn"
                                        class="btn btn-warning w-100"
                                        @if($status=='verified' ) disabled @endif>
                                        {{-- @if($status == 'verified' || $status == 'final') disabled @endif> --}}

                                        <i class="fa fa-check"></i> Verify Data

                                    </button>

                                </form>


                            </div>
                        </div>
                    </div>

                    @if($status== 'verified' )

                    {{-- DRAW ACTIONS --}}
                    <div class="col-md-6">

                        <div class="card shadow-sm border-0">

                            <div class="card-header bg-light">
                                <strong>Draw Actions</strong>
                            </div>

                            <div class="card-body">
                                @if(isset($batch) && $batch)

                                <div class="alert alert-info">
                                    Demo Run Used: {{ $batch->demo_run_count }} / 3
                                </div>

                                @endif

                                @if($status == 'verified' && $batch->demo_run_count < 3)

                                    {{-- DEMO DRAW --}}
                                    <form action="{{ route('draw.demo') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="quartertype" id="demo_quartertype">

                                    <button type="submit" class="btn btn-info w-100 mb-2">
                                        <i class="fa fa-play"></i> Demo Draw
                                    </button>

                                    </form>
                                    @endif
                                    @if($status == 'verified' )

                                    {{-- FINAL DRAW --}}
                                    <form action="{{ route('draw.final') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="quartertype" id="final_quartertype">

                                        <button type="submit" class="btn btn-danger w-100 mb-3">
                                            <i class="fa fa-lock"></i> Final Draw
                                        </button>

                                    </form>

                                    @endif



                                    @if($status == 'final')

                                    <div class="alert alert-success">
                                        Final Draw Completed. Entries Frozen.
                                    </div>

                                    @endif

                                    {{-- @if(Session::has('batch_id') && Session::has('quartertype'))  --}}
                                    @if($status == 'verified')

                                    <a href="{{ route('draw.full.pdf',['batch_id'=>Session::has('batch_id')]) }}"
                                        class="btn btn-outline-danger w-100 mb-2">

                                        <i class="fa fa-file-pdf"></i> Download Full Draw PDF

                                    </a>


                                    <a href="{{ route('draw.export.excel',['batch_id'=>Session::has('batch_id')]) }}"
                                        class="btn btn-outline-success w-100">

                                        <i class="fa fa-file-excel"></i> Download Excel

                                    </a>
                                    @endif

                                    <a href="{{ route('draw.history') }}"
                                        class="btn btn-dark mt-2">
                                        <i class="fa fa-history"></i> Draw History
                                    </a>
                                    <div class="card-tools">

                                        <a href="{{ route('draw.reset') }}" class="btn btn-sm btn-danger">
                                            <i class="fa fa-refresh"></i> Reset
                                        </a>

                                        @endif
                                    </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>



            {{-- RESULT TABLE --}}
            @if(isset($results) && $results->count() > 0 && $status=='verified')

            <div class="table-responsive p-4">

                <table id="applicant_list"
                    class="table table-bordered table-hover custom_table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Premise No</th>
                            <th>Applicant Name</th>
                            <th>Draw Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($results as $index => $row)

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->premise_no }}</td>
                            <td>{{ $row->appln_name }}</td>
                            <td>{{ $row->draw_date }}</td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @endif


        </div>
    </div>
</div>

@endsection


@push('footer-script')

<script>
    $(document).ready(function() {

        /* for date validation starts here */
        let today = new Date().toISOString().split('T')[0];

        let maxDate = new Date();
        maxDate.setMonth(maxDate.getMonth() + 3);
        maxDate = maxDate.toISOString().split('T')[0];

        $('input[name="draw_date"]').attr('min', today);
        $('input[name="draw_date"]').attr('max', maxDate);

        /* for date validation ends here */

        function setQuarter() {

            let qt = $('#quartertype').val();

            if (qt) {
                $('#verify_quartertype').val(qt);
                $('#demo_quartertype').val(qt);
                $('#final_quartertype').val(qt);
            }

        }

        /* Page load */
        setQuarter();

        /* Dropdown change */
        $('#quartertype').on('change', function() {
            setQuarter();
        });


        /* Verify Button */
        $('#verifyBtn').on('click', function() {

            let qt = $('#quartertype').val();

            if (!qt) {
                alert('Please select Quarter Type');
                return false;
            }

            $('#verify_quartertype').val(qt);

            $('#verifyForm').submit();

        });

        /* upload excel file type validation starts here */
        $('#uploadExcelForm').on('submit', function(e) {

            let fileInput = $('input[name="file"]')[0];

            if (fileInput.files.length === 0) {
                alert('Please select Excel file');
                e.preventDefault();
                return false;
            }

            let file = fileInput.files[0];
            let fileName = file.name.trim();
            let fileSize = file.size;
            let fileType = file.type;

            // 3️⃣ Extension validation
            let extension = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();

            if (extension !== 'xls' && extension !== 'xlsx') {
                alert('File extension should be .xls or .xlsx');
                e.preventDefault();
                return false;
            }

            // 1️⃣ File size validation (100KB)
            if (fileSize > 102400) {
                alert('File size must not exceed 100 KB');
                e.preventDefault();
                return false;
            }

            // 2️⃣ Prevent double dots
            if (fileName.includes("..")) {
                alert('File name should not contain consecutive dots');
                e.preventDefault();
                return false;
            }



            // 4️⃣ Prevent hidden extension (file.xlsx.exe)
            let dotCount = (fileName.match(/\./g) || []).length;
            if (dotCount !== 1) {
                alert('Invalid file name. Multiple extensions detected');
                e.preventDefault();
                return false;
            }

            // 5️⃣ File name validation
            let nameWithoutExt = fileName.substring(0, fileName.lastIndexOf('.'));
            let validName = /^[a-zA-Z0-9_-]+$/;

            if (!validName.test(nameWithoutExt)) {
                alert('File name contains invalid characters');
                e.preventDefault();
                return false;
            }

            // 6️⃣ MIME validation
            let allowedMime = [
                "application/vnd.ms-excel",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            ];

            if (fileType && !allowedMime.includes(fileType)) {
                alert('Invalid Excel file type');
                e.preventDefault();
                return false;
            }

        });

        /* upload excel file type validation ends here */
    });
</script>
@endpush