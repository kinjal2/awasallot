@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Quarter Request (Normal)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quarter Request (Normal)</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-head ">
              <div class="card-header">
                <h3 class="card-title">Quarter Request (Normal)</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

	<div class="card-body">

<div class="table-responsive p-4">

			<table class="table table-bordered table-hover custom_table dataTable" id="normalquarterlist">
                  <thead>
                    <tr>
                      <th>Request Type</th>
                      <th>Quarter <br/>Type</th>
                      <th>Cardex No. / DDO Code</th>
                      <th>Inward No</th>
                      <th>Inward Date</th>
                      <th>Name</th>
                      <th>Office</th>
                      <th>Contact No.</th>
                      <th>Email ID</th>
                      <th>Request Date</th>
                       <th>DDO Approved At</th>
                        <th>Updated At</th>
                      <th>Action</th>
                      
                    <!--  <th></th>-->
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
		<!-- /.card-body -->
		</div>
	</div>

            </div>
            <!-- /.card -->




@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script type="text/javascript">

 var table = $('#normalquarterlist').DataTable({ 
        processing: true,
        serverSide: true,
        lengthMenu: [[ 25, 50, 100, -1], [ 25, 50, 100, "All"]],
        ajax: {
          headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
      url: "{{ route('normalquarter-list') }}",
      'type': 'POST',
  },


        columns: [
            {data: 'requesttype'},
            {data: 'quartertype'},
            {data: 'cardex_ddo'},
            {data: 'inward_no'},
            {data: 'inward_date'},
            {data: 'name'},
            {data: 'office'},
            {data: 'contact_no'},
            {data: 'email'},
            {data: 'request_date'},
            {data: 'ddo_approved_at'},
            {data: 'updated_at'},
             {data: 'action'},
           
          //  {data: 'delete'},
         ]
    });


    </script>
</script>
@endpush
