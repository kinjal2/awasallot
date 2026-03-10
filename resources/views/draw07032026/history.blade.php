@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')

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
      Draw Batch History
    </h3>
  </div>

  <div class="card-body">

    <div class="table-responsive">

      <table class="table table-bordered table-hover custom_table dataTable" id="batch_history_table">

        <thead>
          <tr>
            <th>#</th>
            <th>Batch Title</th>
            <th>Quarter</th>
            <th>Status</th>
            <th>PDF</th>
            <th>Excel</th>
          </tr>
        </thead>

        <tbody>

          @foreach($batches as $index => $batch)

          <tr>
            <td>{{ $index + 1 }}</td>

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
              <a href="{{ route('draw.batch.pdf',$batch->id) }}"
                 class="btn btn-sm btn-danger">
                 <i class="fa fa-file-pdf"></i> PDF
              </a>
            </td>

            <td>
              <a href="{{ route('draw.batch.excel',$batch->id) }}"
                 class="btn btn-sm btn-success">
                 <i class="fa fa-file-excel"></i> Excel
              </a>
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

<script>

$(document).ready(function(){

$('#batch_history_table').DataTable({

    pageLength:10,
    lengthChange:false,   // removes "entries per page"
    searching:true,
    ordering:true,
    responsive:true

});

});

</script>

@endpush
