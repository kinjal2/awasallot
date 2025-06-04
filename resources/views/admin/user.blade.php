@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User list</h1>
          </div>
          @include(Config::get('app.theme').'.template.severside_message')
		      @include(Config::get('app.theme').'.template.validation_errors')
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User List</li>
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
              <div class="table-responsive p-4">
                <table class="table table-bordered table-hover custom_table dataTable" id="userlist">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Name</th>
                      <th>BirthDate</th>
                      <th>Designation</th>
                      <th >Office</th>
                      <th >Email</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                    <tfoot>
                    <tr>
                    <th ></th>
                    <th>Name</th>
                    <th>BirthDate</th>
                    <th>Designation</th>
                    <th>Office</th>
                    <th>Email</th>
                   
                    </tr>
                    </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
          
            </div>
            <!-- /.card -->

          </div>


        </div>
        </div>
        </div>
        <div class="modal" id="reset_modal" data-url="{{ url('/reset') }}">
    <div class="modal-dialog">
        <div class="modal-content pop_up_design">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Reset</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="POST" >
    @csrf
    <input type="hidden" name="field_type" id="field_type" value="" />
    <input type="hidden" name="uid" id="uid" value="" />
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="field_value">New Value <span class="error">*</span></label>
                    <input type="text" name="field_value" id="field_value" class="form-control required" />
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/jquery.inputmask.min.js"></script>
@endsection
@push('page-ready-script')
console.log('page is ready');
@endpush
@push('footer-script')
<script type="text/javascript">

var table = $('#userlist').DataTable({
    lengthMenu: [
        [10, 20, 50, -1],
        [10, 20, 50, "All"] // Change per page values here
    ],
    processing: true,
    serverSide: true,

    
   
    ajax: {
        headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
             },
        url: "{{ route('user.list') }}",
        type: "POST",
      /*  data: function (d) {
            // Add global search value
            d.search = $('#search').val();
            // Add column filters
          //  d.name = $('#name_filter').val();
          //  d.designation = $('#designation_filter').val();
            // Add other column filters similarly
            return d;
        }*/
    },
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'name_link', name: 'name'},
        {data: 'date_of_birth_link', name: 'date_of_birth'},
        {data: 'designation_link', name: 'designation'},
        {data: 'office_link', name: 'office'},
        {data: 'email', name: 'email'},

    ],
    // Other options...
});
$('#userlist tfoot th').each( function () {
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
			  });
    
        table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });  
	  // Open reset modal and set values
    $(document).on('click', '.reset_password', function() {
    //$('.reset_password').click(function() {
     
        var fieldType = 'password';
        var actionUrl = "{{ url('/reset') }}/" + fieldType;
        setModalContent('Reset Password', actionUrl, $(this).data('uid'), fieldType);
    });

    $(document).on('click', '.change_name', function() { 
        var fieldType = 'name';
        var actionUrl = "{{ url('/reset') }}/" + fieldType;
        setModalContent('Change Name', actionUrl, $(this).data('uid'), fieldType);
    });

    $(document).on('click', '.change_designation', function() {  
        var fieldType = 'designation';
        var actionUrl = "{{ url('/reset') }}/" + fieldType;
        setModalContent('Change Designation', actionUrl, $(this).data('uid'), fieldType);
    });
    $(document).on('click', '.change_office', function() {  
        var fieldType = 'office';
        var actionUrl = "{{ url('/reset') }}/" + fieldType;
        setModalContent('Change Office', actionUrl, $(this).data('uid'), fieldType);
    });
    $(document).on('click', '.change_birthdate', function() {  
        var fieldType = 'date_of_birth';
        var actionUrl = "{{ url('/reset') }}/" + fieldType;
  
        setModalContent('Change Date Of Birth', actionUrl, $(this).data('uid'), fieldType);
        
    });
  
  function setModalContent(title, actionUrl, uid, fieldType) { 
        $('#reset_modal').modal('show');
        $('#field_value').val('');
        $('#reset_modal').find('.modal-title').text(title);
        $('#reset_modal').find('form').attr('action', actionUrl);
        $('#reset_modal').find('#field_type').val(fieldType);
        $('#reset_modal').find('#uid').val(uid);
          // Check if the fieldType is 'date_of_birth' and apply input mask accordingly
    if (fieldType === 'date_of_birth') {
        $('#field_value').inputmask('datetime', {
            inputFormat: "yyyy-mm-dd",
            placeholder: "YYYY-MM-DD",
            showMaskOnHover: false
        });
    }  else {
        // Destroy input mask if not 'date_of_birth'
        $('#field_value').inputmask('remove');
    }
    
    } 
</script>
@endpush