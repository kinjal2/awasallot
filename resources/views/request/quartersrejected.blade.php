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
                      <th>Inward No</th>
                      <th>Inward Date</th>
                      <th>Name</th>
                      <th>Office</th>
                      <th>Contact No.</th>
                      <th>Email ID</th>
                      <th>Request Date</th>
                      <th>Remarked On</th>
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
  <!-- view remarks -->
  <div class="modal" id="DocumentModal">
    <div class="modal-dialog">
        <div class="modal-content  pop_up_design">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Remarks</h4>
                <button type="button" class="btn btn-danger close" data-dismiss="modal">&times;</button>

                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               <div id='viewdata'></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger">Close</button>
            </div>
        </div>
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
       
        ajax: {
          headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          url: "{{ route('request.rejectedquarter-list') }}",
          'type': 'POST',
  },


        columns: [
            {data: 'requesttype'},
            {data: 'quartertype'},
            {data: 'inward_no'},
            {data: 'inward_date'},
            {data: 'name'},
            {data: 'office'},
            {data: 'contact_no'},
            {data: 'email'},
            {data: 'request_date'},
            {data: 'remarks_date'},
            {data: 'action'},
          //  {data: 'delete'},
         ]
    });
    $('body').on('click', '.btn', function()
      {
         $('#DocumentModal').hide();
      });
     $('body').on('click', '.getdocument', function()
      {
          var uid = $(this).attr('data-uid');
          var type = $(this).attr('data-type');
          var rivision_id = $(this).attr('data-rivision_id');
          var requestid = $(this).attr('data-requestid');
          var remarks=$(this).attr('data-remarks');
          $.ajax({
            url: "{{ route('quarter.list.getremarks') }}",
            method: 'POST',
            data: {uid:uid,type:type,rivision_id:rivision_id,requestid:requestid,remarks:remarks},
            success: function(result) {
            var html = '<ul>';

            if (result.success === false || !result.data || result.data.length === 0) {
                html += '<li>' + result.message + '</li>';
            } else {
                result.data.forEach(function(item) {
                    html += '<li>' + item.description + '</li>';
                });
            }

            html += '</ul>';
            $("#viewdata").html(html);
            $('#DocumentModal').show();
        }
          });
      });

    </script>

@endpush
