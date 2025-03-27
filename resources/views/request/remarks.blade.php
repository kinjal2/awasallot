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
 <form method="POST" name="front_annexurea" id="front_annexurea" action="{{ url('saveremarks') }}" enctype="multipart/form-data">
            @csrf
	  <input type="hidden" name="r" id="r" value="{{ $requestid }}" />
            <input type="hidden" name="rv" id="rv" value="{{ $rv }}" />
            <input type="hidden" name="type" id="type" value="{{ $type }}" />
            <input type="hidden" name="remarks" id="remarks"  />
	<div  style="text-align:center;">
            <input type="submit" class="button btn btn-success" value="Save" onclick="return validate();" />
	</div>
<div  style="overflow-x:auto;">

			<table class="table table-bordered" id="remarkslist">
                  <thead>                  
                    <tr>
                   <th></th>
                    <th>Remarks</th>
                   </tr>
                  </thead>
                  <tbody>
				     @foreach($remarks as $rm)
					 <tr>
						 <td><input type="checkbox" name="remarksArr[]" id="{{$rm->remark_id }}" onclick="SelectRemarks(this);" /></td>
						 <td>{{$rm->description }}</td>
					 </tr>
					@endforeach
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


$(document).ready( function () {
    $('#remarkslist').DataTable();
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