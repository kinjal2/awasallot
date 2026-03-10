@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')

<div class="content">

    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Demo Draw </h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Demo Draw</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Demo Run Preview</h3>
            </div>


            <div class="card-body">

                @include(Config::get('app.theme').'.template.severside_message')
                @include(Config::get('app.theme').'.template.validation_errors')
                <div class="mb-3">

    <!-- ACTION BUTTONS -->
    <div class="d-flex align-items-center  mb-2">
        
         <p>Choose an action after this draw:</p>
         <br>
        @php // dd($batch->draw_status) @endphp
        @if(($batch->demo_run_count + 1 ) <= 3 && $batch->draw_status=='verified')
        <form action="{{ route('draw.demo') }}" method="POST" class="mr-2 mb-2">
            @csrf
           {{--  <input type="hidden" name="quartertype" value="{{ request('quartertype') }}"> --}}
              <input type="hidden" name="quartertype" value="{{ $batch->quarter_type }}">
                <input type="hidden" name="batch_id" value="{{ $batch->id }}">

            <button type="submit" class="btn btn-info">
                <i class="fa fa-play"></i>Please Run Demo {{ $batch->demo_run_count + 1 }} / 3
            </button>
        </form>

        <span class="mx-2 mb-2">OR</span>

         <form action="{{ route('draw.final') }}" method="POST" class="mb-2">
            @csrf
          {{--   <input type="hidden" name="quartertype" value="{{ request('quartertype') }}"> --}}
            <input type="text" name="quartertype" value="{{ $batch->quarter_type }}">
    <input type="text" name="batch_id" value="{{ $batch->id }}">
            <button type="submit" class="btn btn-danger">
                <i class="fa fa-lock"></i> I am satisfied with demo draw, please proceed for Final Draw
            </button>
        </form>

        @elseif($batch->draw_status != 'final')

        <form action="{{ route('draw.final') }}" method="POST" class="mb-2">
            @csrf
          {{--   <input type="hidden" name="quartertype" value="{{ request('quartertype') }}"> --}}
            <input type="text" name="quartertype" value="{{ $batch->quarter_type }}">
    <input type="text" name="batch_id" value="{{ $batch->id }}">
            <button type="submit" class="btn btn-danger">
                <i class="fa fa-lock"></i> I am satisfied with demo draw, please proceed for Final Draw
            </button>
        </form>

        @endif


        @if($batch->status=='final')

        <div class="alert alert-success mb-2 py-2 px-3">
            Final entries are frozen.
           Go Back to <a href="{{ route('draw.history') }}" class="ml-1">Draw History</a>
        </div>

        
        @endif

    </div>


    <!-- DOWNLOAD BUTTONS -->
    <div class="d-flex align-items-center flex-wrap">

        
        <a href="{{ route('draw.batch.pdf',$batch->id) }}"
                    class="btn btn-outline-danger mr-2 mb-2">
                    <i class="fa fa-file-pdf"></i>Download PDF
                  </a>

       
        {{--  <a href="{{ route('draw.batch.excel',$batch->id) }}"
                    class="btn btn-outline-success mb-2">
                    <i class="fa fa-file-excel"></i>Download Excel
                  </a> --}}

    </div>

</div>                <div class="row">

                    {{-- Upload Section --}}
                    <div class="col-md-12">

                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>


                </div>

            </div>



            {{-- RESULT TABLE --}}
            @if(isset($results) && $results->count() > 0 )

            <div class="table-responsive p-4">

                <table id="applicant_list"
                    class="table table-bordered table-hover custom_table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Premise No</th>
                            <th>Applicant Name</th>
                            <th>Demo Draw Date & Time</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($results as $index => $row)

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->premise_no }}</td>
                            <td>{{ $row->appln_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->draw_date)->format('d-m-Y H:i:s') }}</td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @endif

            <!-- Draw Info Modal -->
            {{-- <div class="modal fade" id="drawInfoModal" tabindex="-1" aria-labelledby="drawInfoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="drawInfoModalLabel">Draw Actions</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body text-center">
                            <p>Choose an action after this draw:</p>

                            <!-- Demo Run Button -->
                             
                            @if(($batch->demo_run_count ) <= 3)
                            <form id="modalDemoForm" action="{{ route('draw.demo') }}" method="POST" style="display:inline-block;">
            @csrf
            <input type="hidden" name="quartertype" id="modalDemoQuarter" value="{{$batch->quarter_type }}">
             <input type="text" name="batch_id" id="batch_id" value="{{ $batch->id }}">
            <button type="submit" class="btn btn-info mx-2">
                <i class="fa fa-play"></i> Please Run Demo {{ $batch->demo_run_count + 1  }} / 3
            </button>
            </form>
            <br> Or <br>
            @endif
            @if($batch->status=='final')
            <div class="alert alert-success mt-2">
                Final entries are frozen. <br>
                Go to <a href="{{ route('draw.history') }}">Draw History</a> to download results.
            </div>
            @else
            <!-- Final Draw Button -->
            <form id="modalFinalForm" action="{{ route('draw.final') }}" method="POST" style="display:inline-block;">
                @csrf
                <input type="hidden" name="quartertype" id="modalFinalQuarter" value="{{$batch->quarter_type }}">
                 <input type="hidden" name="batch_id" id="batch_id" value="{{ $batch->id }}">
                <button type="submit" class="btn btn-danger mx-2">
                    <i class="fa fa-lock"></i> I am satisfied with demo draw, please proceed for Final Draw
                </button>
            </form>
            @endif
            <a href="{{ route('draw.full.pdf',['batch_id'=> $batch->id ]) }}"
                class="btn btn-outline-danger w-100 mb-2">

                <i class="fa fa-file-pdf"></i> Download Full Draw PDF

            </a>


            <a href="{{ route('draw.export.excel',['batch_id'=> $batch->id ]) }}"
                class="btn btn-outline-success w-100">

                <i class="fa fa-file-excel"></i> Download Excel

            </a>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>

    </div>
</div>
</div> --}}
<!-- draw modal closes here -->
</div>
</div>
</div>

@endsection


@push('footer-script')

<script>
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
            debugger;

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