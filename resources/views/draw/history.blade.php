@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')
<!-- <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.css') }}"> -->
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
<th>Final PDF</th>
<th>Demo PDF</th>
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

{{-- DEMO RUN BUTTON --}}
@if($batch->draw_status=='verified' && ($batch->demo_run_count) < 3)

<form action="{{ route('draw.demo') }}" method="POST">
@csrf

<input type="hidden" name="quartertype" value="{{ $batch->quarter_type }}">
<input type="hidden" name="batch_id" value="{{ $batch->id }}">
<input type="hidden" name="page_title" value="Demo Preview">

<button type="submit" class="btn btn-sm btn-info">
<i class="fa fa-play"></i>
Initiate Demo Run {{ $batch->demo_run_count + 1 }} / 3
</button>

</form>

{{-- FINAL DRAW BUTTON --}}
@elseif($batch->draw_status=='verified' && $batch->demo_run_count == 3)

<form action="{{ route('draw.final') }}" method="POST"
class="confirm-action"
data-title="Proceed Final Draw?"
data-text="This process cannot be reverted. Proceed with Final Draw?"
data-confirm="Yes, Proceed">

@csrf

<input type="hidden" name="quartertype" value="{{ $batch->quarter_type }}">
<input type="hidden" name="batch_id" value="{{ $batch->id }}">

<button type="submit" class="btn btn-danger btn-sm">
<i class="fa fa-lock"></i> Proceed for Final Draw
</button>

</form>

@endif


{{-- VERIFY DATA BUTTON --}}
@if($batch->draw_status=='uploaded')

<form method="POST" action="{{ route('draw.verify.preview') }}">
@csrf

<input type="hidden" name="quartertype" value="{{ $batch->quarter_type }}">
<input type="hidden" name="batch_id" value="{{ $batch->id }}">

<button type="submit" class="btn btn-sm btn-warning">
<i class="fa fa-check"></i> Verify Data
</button>

</form>

@endif

</td>


{{-- FINAL PDF COLUMN --}}
<td>

@if($batch->draw_status == 'final')

<a href="{{ route('draw.batch.pdf',['batchId'=>$batch->id,'type'=>'final']) }}"
class="btn btn-sm btn-danger">
<i class="fa fa-file-pdf"></i> Final PDF
</a>

@else
-
@endif

</td>


{{-- DEMO PDF COLUMN --}}
<td>

@if($batch->demo_run_count > 0)

@for($i = 1; $i <= $batch->demo_run_count; $i++)
<a href="{{ route('draw.batch.pdf',['batchId'=>$batch->id,'type'=>'demo','run'=>$i]) }}"
class="btn btn-warning btn-sm mb-1">
<i class="fa fa-file-pdf"></i> Demo {{ $i }}
</a>
@endfor

@else
-
@endif

</td>


{{-- DELETE OPTION --}}
<td>

@if($batch->draw_status != 'final')

<form action="{{ route('draw.delete') }}" method="POST"
class="confirm-action"
data-title="Proceed To Delete?"
data-text="This process cannot be reverted. Proceed with Delete?"
data-confirm="Yes, Delete">

@csrf

<input type="hidden" name="quartertype" value="{{ $batch->quarter_type }}">
<input type="hidden" name="batch_id" value="{{ $batch->id }}">

<button type="submit" class="btn btn-sm btn-danger">
<i class="fa fa-trash"></i> Delete Draw
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
 <!-- <script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>  -->
<script>


  $(document).ready(function() {

  $('.confirm-action').on('submit', function(e){

    e.preventDefault();

    confirmSubmit(this);

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