@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Quarter Allotment List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quarter Allotment List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-head">
              <div class="card-header">
                <h3 class="card-title">Quarter Allotment List</h3>


              </div>
              <!-- /.card-header -->
              <!-- form start -->

	<div class="card-body">
  <div class="row">
			<div class="col-4">
				<div class="form-group">
				<label for="maratial_status">Quarter Type</label>
  {{ Form::select('quartertype[]',$quartertype ,'',['id'=>'quartertype','class'=>'form-control select2','multiple'=>"multiple"]) }}
	</div>
  </div>  </div>
<div  style="overflow-x:auto;">

			<table class="table table-bordered table-hover custom_table dataTable" id="waitinglist" name="waitinglist">
                  <thead>
                    <tr>
                    <th>Area Name</th>
                    <th>Quarter Type</th>
                    <th>Block No</th>
                    <th>Unit No</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Office</th>
                    <th>Possesion Date</th>
                    <th>Image</th>
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
<!-- <script type="text/javascript">
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#waitinglist').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('allotment-list') }}",
                type: "POST",
                // Sending additional data on the AJAX request
                data: function (d) {
                    d.quartertype = $('#quartertype').val(); // Get the current value of quartertype
                }
            },
            columns: [
                {data: 'requesttype', name: 'requesttype'},
                {data: 'quartertype', name: 'quartertype'},
                {data: 'tableof', name: 'tableof'},
                {data: 'inward_no', name: 'inward_no'},
                {data: 'inward_date', name: 'inward_date'},
                {data: 'name', name: 'name'},
                {data: 'designation', name: 'designation'},
                {data: 'office', name: 'office'},
                {data: 'office', name: 'office'}, // You might want to check if this is needed twice
            ]
        });

        // Reload DataTable when quartertype changes
        $('#quartertype').on('change', function (e) {
            table.ajax.reload(); // Reload the table with new data
        });
    });
</script> -->

<script type="text/javascript">
    // var visible_columns= false;
    // var hide_colunm = ["wno", "quartertype", "tableof","inward_no"];
    // console.log($.inArray( "designation", hide_colunm ));
 /*var table = $('#waitinglist').DataTable({
        processing: true,
        serverSide: true,
        type:"POST",
        ajax: {
      // url: "{{ route('allotment-list') }}",

      // data: function (d) {
      //   alert($('#quartertype').val());
      //           d.quartertype = $('#quartertype').val()

      //       }
  },
  /*columns: [
                {data: 'areacode', name: 'areacode'},
                {data: 'quartertype', name: 'quartertype'},
                {data: 'block_no', name: 'block_no'},
                {data: 'unitno', name: 'unitno'},
                {data: 'building_no', name: 'building_no'},
                {data: 'renttypeid', name: 'renttypeid'},
                {data: 'isoccupied', name: 'isoccupied'},
                {data: 'occupancy_date', name: 'occupancy_date'},
                {data: 'vacant_date', name: 'vacant_date'},
                {data: 'allotment_date', name: 'allotment_date'},
                {data: 'allotment_order_no', name: 'allotment_order_no'},
            ]*/
   // });
    $('#quartertype').on('change',function (e) {

      table.ajax.reload();

     });
    //  $('#btnReset').on('click',function (e)
    //  {
    //    $("#quartertype").val("").trigger("change");
    //   });


    </script>
@endpush
