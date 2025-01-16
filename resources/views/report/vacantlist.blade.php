@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')

<div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vacant Quarter List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vacant Quarter List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-head ">
              <div class="card-header">
                <h3 class="card-title">Vacant Quarter List</h3>
			
			
              </div>
              <!-- /.card-header -->
              <!-- form start -->
          
	<div class="card-body"> 
  <div><button type="submit" class="btn btn-success vacantquarter mb-3">Vacant Quarters</button></div>
<div class="table-responsive">

			<table class="table table-bordered table-hover custom_table dataTable" id="vacantlist">
                  <thead>                  
                    <tr>
                    <th style="width: 2%;"></th>
                    <th>Quarter Type</th>
                    <th>Block No</th>
                     <th>Unit No</th>
                     <th>Building No</th>
                     <th>Floor</th>
                     <th>Area</th>
                     <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                  <tfoot>
                  <th> </th>
                    <th>Quarter Type</th>
                    <th>Block No</th>
                     <th>Unit No</th>
                     <th>Building No</th>
                     <th>Floor</th>
                     <th>Area</th>
                     <th>Status</th>
                  </tfoot>
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
        
 var table = $('#vacantlist').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
      url: "{{ route('vacant-list') }}",
      'type': 'POST',

  },
        
    columns: [
          
          {data: 'action', name: 'action',  'width' : '5%', orderable: true, 
                searchable: true},
          {data: 'quartertype', name: 'quartertype'},
          {data: 'block_no', name: 'block_no'},
          {data: 'unit_no', name: 'unit_no'},
          {data: 'building_no', name: 'building_no'},
          {data: 'floor', name: 'floor'},
          {data: 'areaname', name: 'areaname'},
         {data: 'name', name: 'name'},
         ],
         'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 }
],
 initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val()).draw();
                });
            });
        } , 
   fnDrawCallback: function (oSettings) { 
      $( ".vacantquarter" ).click(function() {
       categories = []; // reset 
      $('input[name="quartertype[]"]:checked').each(function()
        { 
           categories.push($(this).val());
        });
        $.ajax({
          'type': 'POST',
            url:"{{ route('vacant_quarter') }}",
            data: {
              category:categories
            },
            dataType: 'json',
            success: function (data) {
              table.draw(true);
            },
            error: function (data) {
                console.log(data);
            }
        });

       
    }); 
        }        
    });
  
 
</script>
@endpush