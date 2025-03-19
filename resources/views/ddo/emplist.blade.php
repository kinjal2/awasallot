@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$page_title}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{$page_title}}</li>
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
        <h3 class="card-title">Employees List</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->

      <div class="card-body">

        <div class="table-responsive p-4">

          <table class="table table-bordered table-hover custom_table dataTable" id="emplist">
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No.</th>
                <th>Office Name</th>
                <th>Designation</th>
                <th>Appointment Date</th>
                <th>Retirement Date</th>
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
      var table = $('#emplist').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('ddo-show-emp-list') }}",
          'type': 'POST',
        },



        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'name'
          },
          {
            data: 'email'
          },
          {
            data: 'contact_no'
          },
          {
            data: 'office'
          },
          {
            data: 'designation'
          },
          {
            data: 'appointment_date'
          },
          {
            data: 'date_of_retirement'
          },
          {
            data: 'action'
          },

        ]
      });
    </script>
    </script>
    @endpush