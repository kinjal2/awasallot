@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<style >
.bg-light-pink {
    background-color: #FFC0CB; /* Light pink */
} 
</style>
<div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Waiting List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Waiting List</li>
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
                <h3 class="card-title">Waiting List</h3>
			
			
              </div>
              <!-- /.card-header -->
              <!-- form start -->
          
	<div class="card-body"> 



  <div class="table-responsive">

			<table class="table table-bordered table-hover custom_table dataTable" id="waitinglist">
                  <thead>                  
                    <tr>
                    
                   
                    <th>Request Type</th>
                    <th>Quarter Type</th>
                    <th>Inward No</th>
                    <th>Inward Date</th>
                    <th>Name</th>
                    <th>Office</th>
                    <th>Contact No</th>
                    <th>Email Id</th>
                   <th>Request Date </th>   
                   <th>Action</th>   
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
		<!-- /.card-body -->
		</div>
	</div>

            </div> </div>
            <!-- /.card -->




	
@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script type="text/javascript">
    var visible_columns= false;  
   
    
 var table = $('#waitinglist').DataTable({
        processing: true,
        serverSide: true,
      
        ajax: {
       url: "{{ route('policestaff.data') }}",
       type:"POST",
    data: function (d) { 
              d._token = '{{ csrf_token() }}'; // CSRF token
                d.quartertype = $('#quartertype').val();
              
            }
  },
        columns: [
         
            {data: 'tableof',sWidth:'3%', name: 'tableof' },
            {data: 'quartertype',sWidth:'3%', name: 'quartertype'},
            {data: 'inward_no', sWidth:'3%', name: 'inward_no'},
            {data: 'inward_date',sWidth:'3%', name: 'inward_date'},
            {data: 'UserName', name: 'UserName'},
            {data: 'UserOffice', name: 'UserOffice'},
            {data: 'UserContactNo', name: 'UserContactNo'},
            {data: 'UserEmailId', name: 'UserEmailId'},
            {data: 'request_date', name: 'request_date'},
            {data: 'action', name: 'action'},
          
           
        ]
    });
   
    </script>

@endpush