@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.css') }}">
<div class="content">

  <!-- Content Header -->

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">


        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ $page_title }}</h1>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{ $page_title }}</li>
          </ol>
        </div>

      </div>
    </div>


  </div>
  <!-- /.content-header -->

  <div class="col-md-12">


    <div class="card card-head">

      <div class="card-header">
        <h3 class="card-title">
          Quarter Draw
        </h3>
      </div>

      <div class="card-body">
        @include(Config::get('app.theme').'.template.severside_message')
        @include(Config::get('app.theme').'.template.validation_errors')
        <div class="d-flex justify-content-between mb-3">

          <a class="btn btn-success" href="{{ route('draw.index') }}" id="createNewDraw">
            Create New Draw
          </a>

          <a href="{{ asset('sample/draw_sample.xlsx') }}" class="btn btn-info btn-sm">
            <i class="fa fa-download"></i> Sample Excel Format
          </a>

        </div>
        <div class="table-responsive">

          <table class="table table-bordered table-hover custom_table dataTable" id="batch_history_table">




            <thead>
              <tr>
                <th>#</th>
                <th>Batch Id</th>
                <th>Batch Title</th>
                <th>Quarter</th>
                <th>Status</th>
                <th>Actions Required</th>
                <th>PDF</th>
                <!-- <th>Excel</th> -->
                <th>Options</th>
              </tr>
            </thead>

            <tbody>

              @foreach($batches as $index => $batch)
              <tr>
                <td>{{ $index + 1 }}</td>
                
                <td>{{ $batch->batch_no }}</td>

                <td>{{ $batch->batch_title }}</td>

                <td>{{ $batch->quarter_type }}</td>

                <td>
                  @if($batch->draw_status == 'final')
                  <span class="badge badge-success">Final</span>

                  @elseif($batch->draw_status == 'verified')
                  <span class="badge badge-warning">Verified</span>

                  @else
                  <span class="badge badge-secondary">Uploaded</span>
                  @endif
                </td>
                <td>
                  @if($batch->draw_status=='verified' && ($batch->demo_run_count ) < 3 )
                    <form action="{{ route('draw.demo') }}" method="POST">
                    @csrf

                    <input type="hidden" name="quartertype" id="demo_quartertype" value="{{ $batch->quarter_type }}">
                    <input type="hidden" name="batch_id" id="batch_id" value="{{ $batch->id }}">
                    <input type="hidden" name="page_title" id="page_title" value="Demo Preview">

                    <button type="submit" class="btn btn-sm btn-info ">
                      <i class="fa fa-play"></i>&nbsp;Initiate Demo Run {{ $batch->demo_run_count + 1 }} / 3
                    </button>

                    </form>
                    @elseif($batch->draw_status=='verified' && ($batch->demo_run_count  == 3 ) )
                    <form action="{{ route('draw.final') }}" method="POST" class="mb-2" id="finalDrawForm" >
                      @csrf
                      {{-- <input type="hidden" name="quartertype" value="{{ request('quartertype') }}"> --}}
                      <input type="hidden" name="quartertype" value="{{ $batch->quarter_type }}">
                      <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                      <button type="submit" class="btn btn-danger">
                        <i class="fa fa-lock"></i>Proceed for Final Draw
                      </button>
                    </form>
                    @endif
                    @if($batch->draw_status=='uploaded')
                    <form method="POST" action="{{ route('draw.verify.preview') }}" id="verifyForm">
                      @csrf
                      <input type="hidden" name="quartertype" id="verify_quartertype" value="{{ $batch->quarter_type }}">
                      <input type="hidden" name="batch_id" id="batch_id" value="{{ $batch->id }}">
                      <button type="submit"
                        id="verifyBtn"
                        class="btn btn-sm btn-warning">
                        <i class="fa fa-check"></i> Verify Data
                      </button>
                    </form>
                    @endif
                </td>
                <td>
                  @if($batch->draw_status == 'final' || ($batch->draw_status =='verified' && $batch->demo_run_count >= 1 && $batch->demo_run_count < 3 ))
                  <a href="{{ route('draw.batch.pdf',$batch->id) }}"
                    class="btn btn-sm btn-danger">
                    <i class="fa fa-file-pdf"></i> PDF
                  </a>
                  @else
                  -
                  @endif
                </td>

                <!-- <td>
                   @if($batch->draw_status == 'final' || ($batch->draw_status =='verified' && $batch->demo_run_count >= 1 && $batch->demo_run_count < 3 ))
                  <a href="{{ route('draw.batch.excel',$batch->id) }}"
                    class="btn btn-sm btn-success">
                    <i class="fa fa-file-excel"></i> Excel
                  </a>
                  @else
                  -
                  @endif
                </td> -->
                <td>
                   @if($batch->draw_status != 'final'  )
                 <form action="{{ route('draw.delete') }}" method="POST" class="deleteForm d-inline" name="delDrawForm" id="delDrawForm">
                    @csrf
                     <input type="hidden" name="quartertype" id="verify_quartertype" value="{{ $batch->quarter_type }}">
                      <input type="hidden" name="batch_id" id="batch_id" value="{{ $batch->id }}">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </form>

                  @else
                  -
                  @endif
                </td>
              </tr>




              @endforeach



            </tbody>

          </table>

        </div>

      </div>

    </div>


  </div>

</div>

@endsection

@push('footer-script')
<script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>


  $(document).ready(function() {
  $('#finalDrawForm').on('submit', function(e){

    console.log("Form submit event triggered");

    e.preventDefault();

    let form = this;

    Swal.fire({
        title: 'Are you sure?',
        text: "This process cannot be reverted. Proceed with Final Draw?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed!'
    }).then(function(result){

        console.log("SweetAlert result:", result);

        if(result.value){

            console.log("User confirmed, submitting form");

            form.submit();

        }else{

            console.log("User cancelled");

        }

    });

});

$('#delDrawForm').on('submit', function(e){

    console.log("Form submit event triggered");

    e.preventDefault();

    let form = this;

    Swal.fire({
        title: 'Are you sure?',
        text: "This process cannot be reverted. Proceed with Delete?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed!'
    }).then(function(result){

        console.log("SweetAlert result:", result);

        if(result.value){

            console.log("User confirmed, submitting form");

            form.submit();

        }else{

            console.log("User cancelled");

        }

    });

});
    $('#batch_history_table').DataTable({

      pageLength: 10,
      lengthChange: false, // removes "entries per page"
      searching: false,
      ordering: true,
      responsive: true

    });

  });
</script>

@endpush