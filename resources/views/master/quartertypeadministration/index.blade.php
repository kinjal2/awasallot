@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{  __('area.area_list') }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{  __('area.area_list') }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
            <div class="card">
           <!--   <div class="card-header">
                <h3 class="card-title">li</h3>
              </div>--->
              <!-- /.card-header -->
              <div class="card-body">
              <a class="btn btn-success" href="javascript:void(0)" id="createNewArea"> Create New Area</a>
 
                <table class="table table-bordered" id="arealist">
                <thead>
                <tr>
                    <th>{{  __('area.area_name') }}</th>
                    <th>{{  __('area.address') }}</th>
                    <th>{{  __('area.address_gujatati') }}</th>
                    <th></th>
                  
                    
                </tr>
                </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
          
            </div>
            <!-- /.card -->

          </div>


        </div>
        </div>
        </div>
     
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
			
                <h4 class="modal-title" id="modelHeading"></h4>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="areaForm" name="areaForm" class="form-horizontal">
                   <input type="hidden" name="area_id" id="area_id">
                    <div class="form-group">
                        <label for="areaname" class="col-sm-6 control-label">Quarter Type</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="areaname" name="areaname" placeholder="Enter Area Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="areaname" class="col-sm-6 control-label">Area</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="areaname" name="areaname" placeholder="Enter Area Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="areaname" class="col-sm-6 control-label">Block No</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="block_no" name="block_no" placeholder="Enter block No" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="areaname" class="col-sm-6 control-label">Entry Type</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="block_no" name="block_no" placeholder="Enter block No" value="" maxlength="50" required="">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Unit No</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="unit_no" name="unit_no" placeholder="Enter Unit No" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Lift</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="unit_no" name="unit_no" placeholder="Enter Unit No" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Building No</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="building_no" name="building_no" placeholder="Enter Address Gujarati" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Floor</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="floor" name="floor" placeholder="Enter Address Gujarati" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Status</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="status" name="status" placeholder="Enter Address Gujarati" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Remarks</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Address Gujarati" value="" maxlength="50" required="">
                        </div>
                    </div>
                    


                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>      
@endsection
@push('page-ready-script')
console.log('page is ready');
@endpush
@push('footer-script')
<script type="text/javascript">
  $(document).ready(function () {
        load_table();
    });

    function load_table() {

        oTable = $('#arealist').dataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            columns: [
                {data: 'areaname', name: 'areaname'},
                {data: 'address', name: 'address'},
                {data: 'address_g', name: 'address_g'},
               
                
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            ajax: {
      url: "{{ URL::action('QuarterAdministrationController@getList') }}",
      'type': 'POST',
  },
       
            fnDrawCallback: function (oSettings) { //console.log(oSettings);
            
                $('#arealist tbody tr td').click(function () {
                    var par = $(this).parent('tr');
                   // var len = oTable.columns().header().length;
                    var len = oTable.fnSettings().aoColumns.length;
                    if ($(this).index() < len - 1) {
                        $editLnk = par.find('td:last > a.edit_row');
                        if ($editLnk[0]) {
                            $editLnk[0].click();
                        }
                    }
                });
            }
        });
    }
    $('body').on('click', '.delete', function () {
     
     var id = $(this).attr("destroy-id");
     
     confirm("Are You sure want to delete !");
   
     $.ajax({
         type: "DELETE",
         url: "{{ route('masterarea.store') }}"+'/'+1,
         data:{id:id},
         success: function (data) {
          oTable.draw();
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
 });
 $('#createNewArea').click(function () {
        $('#saveBtn').val("create-Area");
        $('#area_id').val('');
        $('#areaForm').trigger("reset");
        $('#modelHeading').html("Create New Area");
        $('#ajaxModel').modal('show');
    });
    $('body').on('click', '.editArea', function () {
      var area_id = $(this).attr('data-id');
      
      $.get("{{ route('masterarea.index') }}" +'/' + area_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Area");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#area_id').val(data.areacode);
          $('#areaname').val(data.areaname);
          $('#address').val(data.address);
          $('#address_g').val(data.address_g); 

      })
   }); 
   $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#areaForm').serialize(),
          url: "{{ route('masterarea.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#areaForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              load_table();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    }); 
</script>
@endpush