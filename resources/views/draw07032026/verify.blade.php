@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')

<div class="content">

  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$page_title}}</h1>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{$page_title}}</li>
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
          Verify Data - Quarter {{ $quartertype }}
        </h3>
      </div>

      <div class="card-body">

        <div class="row">

          <!-- Applications Table -->
          <div class="col-md-6">

            <h5 class="mb-3">Applications</h5>

            <div class="table-responsive">

              <table class="table table-bordered table-hover custom_table dataTable" id="applications_table">

                <thead>
                  <tr>
                    <th>Sr No</th>
                    <th>Applicant Name</th>
                  </tr>
                </thead>

                <tbody>

                  @foreach($applications as $app)
                  <tr>
                    <td>{{ $app->sono }}</td>
                    <td>{{ $app->appln_name }}</td>
                  </tr>
                  @endforeach

                </tbody>

              </table>

            </div>

          </div>


          <!-- Premises Table -->
          <div class="col-md-6">

            <h5 class="mb-3">Premises</h5>

            <div class="table-responsive">

              <table class="table table-bordered table-hover custom_table dataTable" id="premises_table">

                <thead>
                  <tr>
                    <th>Sr No</th>
                    <th>Premise No</th>
                  </tr>
                </thead>

                <tbody>

                  @foreach($premises as $pre)
                  <tr>
                    <td>{{ $pre->srno }}</td>
                    <td>{{ $pre->premise_no }}</td>
                  </tr>
                  @endforeach

                </tbody>

              </table>

            </div>

          </div>

        </div>


        <hr>

        <!-- Confirm Verify Button -->

        <form method="POST" action="{{ route('draw.verify.confirm') }}">

          @csrf

          <input type="hidden" name="quartertype" value="{{ $quartertype }}">

          <button class="btn btn-success">
           Confirm Data Is Correct
          </button>

        </form>

      </div>

    </div>

  </div>

</div>

@endsection


@push('footer-script')

<script>

$(document).ready(function(){

$('#applications_table').DataTable({
pageLength:10
});

$('#premises_table').DataTable({
pageLength:10
});

});

</script>

@endpush