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

                <div class="ml-auto">
                    <a href="{{ asset('sample/draw_sample.xlsx') }}"
                        class="btn btn-info btn-sm">
                        <i class="fa fa-download"></i> Sample Excel Format
                    </a>
                </div>


            </div>


            <div class="card-body">

                @include(Config::get('app.theme').'.template.severside_message')
                @include(Config::get('app.theme').'.template.validation_errors')

                <div class="row">

                    {{-- Upload Section --}}
                    <div class="col-md-8">

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

                                        <input type="date" name="draw_date" class="form-control" required oninvalid="this.setCustomValidity('Please select the draw date')"
                                            oninput="this.setCustomValidity('')"   onclick="this.showPicker()">

                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Batch Title&nbsp;<span class="text-danger">*</span></label>

                                        <input type="text"
                                            name="batch_title"
                                            id="batch_title"
                                            class="form-control"
                                            required
                                            minlength="5"
                                            oninvalid="validateBatchTitle(this)"
                                            oninput="this.setCustomValidity('')">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label>Select Excel File&nbsp;<span class="text-danger">*<br></span><span class="text-info">Excel file format must exactly match with sample format provided </span></label>

                                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required oninvalid="this.setCustomValidity('Please select excel file')"
                                            oninput="this.setCustomValidity('')">
                                        <label>File Name must contain only alphabets,digits,underscore(_),hypen(-)</label>

                                    </div>

                                    <span class="text-danger">Fields marked with * are mandatory to fill. </span><br>
                                    <!-- <span class="text-danger">If any error after upload, please download sample excel format. </span> -->
                                    <!-- <a href="{{ asset('sample/draw_sample.xlsx') }}"
                                            class="btn btn-info w-100 mb-2">
                                            <i class="fa fa-download"></i> Download Sample Excel Format
                                        </a> -->

                                    <button type="submit"
                                        class="btn btn-success w-100 mb-2"

                                        {{--  @if($status=='verified' || $status=='uploaded' ) disabled @endif --}}>
                                        {{-- @if($status == 'verified' || $status == 'final') disabled @endif> --}}


                                        <i class="fa fa-upload"></i> Upload Excel

                                    </button>


                                </form>
                            </div>
                        </div>
                    </div>

                   
                </div>

            </div>



          
       
        </div>
    </div>
</div>

@endsection


@push('footer-script')

<script>
    /* batch title validation starts here */
    function validateBatchTitle(input) {

    if (input.value.trim() === '') {
        input.setCustomValidity('Please enter the batch title');
    }
    else if (input.value.trim().length < 5) {
        input.setCustomValidity('Batch title must be at least 5 characters');
    }
    else {
        input.setCustomValidity('');
    }

}
/* batch title validation starts here */
    $(document).ready(function() {
        function setModalQuarterType() {
            let qt = $('#quartertype').val();
            $('#modalDemoQuarter').val(qt);
            $('#modalFinalQuarter').val(qt);
        }

        // Call on page load
        setModalQuarterType();

        // Update if dropdown changes
        $('#quartertype').on('change', function() {
            setModalQuarterType();
        });
        // Only trigger if draw table exists
        if ($('#applicant_list').length > 0) {

            // 30 seconds delay
            setTimeout(function() {
                var drawModal = new bootstrap.Modal(document.getElementById('drawInfoModal'));
                drawModal.show();
            }, 10000); // 30000ms = 30s

        }

        /* for date validation starts here */
        // let today = new Date().toISOString().split('T')[0];

        // let maxDate = new Date();
        // maxDate.setMonth(maxDate.getMonth() + 3);
        // maxDate = maxDate.toISOString().split('T')[0];

        // $('input[name="draw_date"]').attr('min', today);
        // $('input[name="draw_date"]').attr('max', maxDate);

        /* for date validation starts here */

        let today = new Date().toISOString().split('T')[0];

        let maxDate = new Date();
        maxDate.setMonth(maxDate.getMonth() + 3);
        maxDate = maxDate.toISOString().split('T')[0];

        let drawDateInput = $('input[name="draw_date"]');

        drawDateInput.attr('min', today);
        drawDateInput.attr('max', maxDate);

        // Disable Sunday and 2nd & 4th Saturday
        drawDateInput.on('change', function() {
            let selectedDate = new Date($(this).val());
            let day = selectedDate.getDay(); // 0 = Sunday, 6 = Saturday
            let date = selectedDate.getDate();

            // Find which Saturday of the month
            let weekNumber = Math.ceil(date / 7);

            if (day === 0 || (day === 6 && (weekNumber === 2 || weekNumber === 4))) {
                alert("Sundays and 2nd & 4th Saturdays are not allowed.");
                $(this).val('');
            }
        });


        /* for date validation ends here */
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
            // debugger;

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