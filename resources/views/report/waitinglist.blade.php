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


  <div class="row">
			<div class="col-4">
				<div class="form-group">
				<label for="quartertype">Quarter Type</label>
  {{ Form::select('quartertype[]',$quartertype ,'',['id'=>'quartertype','class'=>'form-control select2','multiple'=>"multiple"]) }}
	</div>
  </div>
  <div class="col-4" style="padding-top: 30px;">
				<div class="form-group" >
				<label for="Reset"></label>
        <input type="button" id="btnReset" class="btn btn-primary" value="Reset" />
       	</div>
  </div>





   </div>
<div class="table-responsive"  >

			<table class="table table-bordered table-hover custom_table dataTable" id="waitinglist">
                  <thead>
                    <tr>
                    <th>R Waiting No.</th>
                    <th>Waiting List No.</th>
                    <th>Quarter Type</th>
                    <th>Request Type</th>
                    <th>Inward No</th>
                    <th>Inward Date</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Office</th>
                    <th>Contact No</th>
                    <th>Email Id</th>
                    <th>GPF/CPF Number</th>
                    <th>Retirment Date</th>
                    <th>Native Address</th>
                    <th>Action</th>
                    <th>Remarks </th>
                    <th>Office Email ID</th>
                    <th>User Remarks</th>
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

<!-- Delete Product Modal -->
<div class="modal" id="DocumentModal">
    <div class="modal-dialog">
        <div class="modal-content  pop_up_design">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">View Document</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
               <div id='viewdata'></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger">Close Modal</button>
            </div>
        </div>
    </div>
</div>
<!--add Remarks -->
<div class="modal" id="remarks_modal" >
    <div class="modal-dialog">
        <div class="modal-content  pop_up_design">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Remarks </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="POST" action="{{ url('/upadteremarks') }}" >
    @csrf
    <input type="hidden" name="uid" value="" />
		<input type="hidden" name="wno" value="" />
		<input type="hidden" name="quartertype" value="" />
    <div class="modal-body">
    <div class="row">
<div class="col-sm-12">

<div class="form-group">
<label>Textarea</label>
<textarea class="form-control" rows="3"  id="office_remarks" name="office_remarks" placeholder="Enter Remarks..."></textarea>
</div>
</div>

</div>
    </div>
    <!-- Modal footer -->
    <div class="modal-footer">
        <input type="submit" value="Submit" class="btn btn-success" />
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close Modal</button>
    </div>
</form>

        </div>
    </div>
</div>


@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script type="text/javascript">
    var visible_columns= false;
    var hide_colunm = ["wno", "quartertype", "tableof","inward_no"];
    console.log($.inArray( "designation", hide_colunm ));
 var table = $('#waitinglist').DataTable({
        processing: true,
        serverSide: true,

        ajax: {
          headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
             },
       url: "{{ route('waitinglist.data') }}",
       type:"POST",
    data: function (d) {
                d.quartertype = $('#quartertype').val()

            }
  },
        columns: [
          {data: 'r_wno', name: 'r_wno',sWidth:'2%'},
            {data: 'wno', name: 'wno',sWidth:'2%'},
            {data: 'quartertype',sWidth:'3%', name: 'quartertype' },
            {data: 'tableof',sWidth:'3%', name: 'tableof'},
            {data: 'inward_no', sWidth:'3%', name: 'inward_no'},
            {data: 'inward_date',sWidth:'3%', name: 'inward_date'},
            {data: 'name', name: 'name'},
            {data: 'designation', name: 'designation'},
            {data: 'office', name: 'office'},
            {data: 'contact_no', name: 'contact_no'},
            {data: 'email', name: 'email'},
            {data: 'gpfnumber', name: 'gpfnumber'},
            {data: 'date_of_retirement', name: 'date_of_retirement'},
            {data: 'address', name: 'address'},
            {data: 'action',sWidth:'3%', name: 'action', orderable: true, searchable: true},
            {data: 'office_remarks', name: 'office_remarks'},
            {data: 'office_email_id', name: 'office_email_id'},
            {data: 'withdraw_remarks', name: 'withdraw_remarks'},
        ]
    });
    $('#quartertype').on('change',function (e) {

      table.ajax.reload();

     });
     $('#btnReset').on('click',function (e)
     {
       $("#quartertype").val("").trigger("change");
      });
      $('body').on('click', '.getdocument', function()
      {
          var uid = $(this).attr('data-uid');
          var type = $(this).attr('data-type');
          var rivision_id = $(this).attr('data-rivision_id');
          var requestid = $(this).attr('data-requestid');
          $.ajax({
            url: "{{ route('getdocumentdata') }}",
            method: 'POST',
            data: {uid:uid,type:type,rivision_id:rivision_id,requestid:requestid},
            success: function(result)
            {
              $("#viewdata").html(result);
              $('#DocumentModal').show();

            }
          });
      });
      $('body').on('click', '.btn', function()
      {
         $('#DocumentModal').hide();
      });
     function show_dialog_desig(u,w,q){ // alert("hi");alert(u);alert(w); alert(q);
      $('#remarks_modal').modal('show');
			$("#remarks_modal input[name=uid]").val(u);
			$("#remarks_modal input[name=wno]").val(w);
			$("#remarks_modal input[name=quartertype]").val(q);

		}
    </script>

@endpush
