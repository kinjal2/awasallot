@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<div class="content">
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Remarks</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Remarks</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
     <!-- /.content-header -->
    <div class="col-md-12">
            <!-- general form elements -->
            <div class="card ">
              <div class="card-header">
                <h3 class="card-title">Remarks</h3>
			
			
              </div>
              <!-- /.card-header -->
              <!-- form start -->
          
	<div class="card-body"> 
    <form action="{{ route('quarter.list.addnewremark') }}" method="POST" id="save_new_remark" name="save_new_remark">
      @csrf
      <div class="row">
        <div class="col-,d-6">
          <label for="new_remark">Add New Remark</label>
          <input class="form-control" type="text" name="new_remark" id="new_remark" value="{{ old('new_remark') }}">
          <input type="submit" value="Add New Remark" class="button btn btn-success mt-4">
        </div>
      </div>
    </form>
 <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('saveremarks') }}" enctype="multipart/form-data">
            @csrf
	  <input type="hidden" name="r" id="r" value="{{ $requestid }}" />
            <input type="hidden" name="rv" id="rv" value="{{ $rv }}" />
            <input type="hidden" name="type" id="type" value="{{ $type }}" />
            <input type="hidden" name="remarks" id="remarks"  />
	<div  style="text-align:right;" class="col-md-12">
 
            <input type="submit" class="button btn btn-success" value="Save Remarks" onclick="return validate();" />
	</div>
  
<div  style="overflow-x:auto;">

			<table class="table table-bordered" id="remarkslist">
                  <thead>                  
                    <tr>
                      <th>Select</th>
                   <th>Sr No</th>
                    <th>Remarks</th>
                   </tr>
                  </thead>
                  <tbody>
				    
				</tbody>
                </table>
                
		<!-- /.card-body -->
		</div> 

      	</form>	 
		
	</div>

            </div> </div>








@endsection
@push('page-ready-script')

@endpush
@push('footer-script')
<script type="text/javascript">

$('#remarkslist').DataTable({
    processing: true,
    serverSide: true,
    ajax:{ 
      
      url:"{{ route('quarter.list.listremarks') }}",
            type: 'POST', // Ensure the POST method is used
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
             },
       },
    columns: [
        { data: 'checkbox', orderable: false, searchable: false }, //  Checkbox column
        { data: 'index', name: 'index', orderable: false, searchable: false }, 
        {
                data: 'description',
                name: 'description'
        },
        
    ]
});
$(document).ready( function () {

  
   // $('#remarkslist').DataTable();
    
    $('#save_new_remark').on('submit', function (e) {
            e.preventDefault(); // prevent default form submission

            var formData = {
                new_remark: $('#new_remark').val(),
                _token: '{{ csrf_token() }}' // CSRF token for Laravel
            };

            $.ajax({
                type: 'POST',
                url: "{{ route('quarter.list.addnewremark') }}",
                data: formData,
                success: function (response) {
                    console.log('Remark added successfully:', response);
                    if(response.status === 'success') {
                      alert(response.message); // or use a toast/snackbar for better UI
                      
                      //location.reload(); // Reload the entire page
                      // You can reset the form or update the UI
                      //  Reload DataTable
                    //   if ($.fn.dataTable.isDataTable('#remarkslist')) {
                    //     $('#remarkslist').DataTable().clear().destroy();
                    //   }
                    // $('#remarkslist').DataTable(); // false = don't reset pagination
                      $('#save_new_remark')[0].reset();
                  }
                    $('#save_new_remark')[0].reset(); 
                },
                error: function (xhr, status, error) {
                    console.error('Error submitting remark:', error);
                    // Optional: Show error messages on the form
                }
            });
        });
} );
  function SelectRemarks(obj)
    { 
        var remarks = "";
        if (obj.id=='O' && obj.checked) {
            $("#other_remarks").removeAttr('disabled');
        }
        else if (obj.id == 'O' && !obj.checked) {
            $("#other_remarks").attr('disabled',true);
        }
        
        $("input[name='remarksArr[]']:checked").each(function(){
                remarks += $(this).attr('id')+",";
            });
        $('#remarks').attr('value',remarks);
    }
</script>
@endpush