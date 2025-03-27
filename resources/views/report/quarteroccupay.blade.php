@extends(\Config::get('app.theme').'.master') @section('title', $page_title) @section('content') <div class="content">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Occupay Quarter List</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item active">Occupay Quarter List</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-head">
      <div class="card-header">
        <h3 class="card-title">Occupay Quarter List</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered table-hover custom_table dataTable" id="occupaylist">
            <thead>
              <tr>
                <th>Area</th>
                <th>Quartertype</th>
                <th>Building No</th>
                <th>Name Of Allottee</th>
                <th>Allotment Date</th>
                <th>Occupancy Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <!-- /.card --> @endsection @push('page-ready-script') @endpush @push('footer-script') <script type="text/javascript">
      $(document).ready(function() {
        var table = $('#occupaylist').DataTable({
          processing: true,
          serverSide: true,
          dom: 'Bfrtip',
          buttons: ['excel', ],
          ajax: {
            url: "{{ route('quarter.occupancy.list') }}",
            'type': 'POST',
          },
          columns: [{
            data: 'areaname',
            name: 'areaname'
          }, {
            data: 'building_no',
            name: 'building_no'
          }, {
            data: 'name',
            name: 'name'
          }, {
            data: 'quartertype',
            name: 'quartertype'
          }, {
            data: 'allotment_date',
            name: 'allotment_date'
          }, {
            data: 'occupancy_date',
            name: 'occupancy_date'
          }, {
            data: 'image',
            name: 'image'
          }],
          initComplete: function() {
            this.api().columns().every(function() {
              var column = this;
              var input = document.createElement("input");
              $(input).appendTo($(column.footer()).empty()).on('change', function() {
                column.search($(this).val()).draw();
              });
            });
          },
        });
      });
    </script> @endpush