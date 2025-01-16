@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quarter Type List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quarter Type List</li>
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
              <a class="btn btn-success mb-3" href="{{ route('masterquartertype.storenew') }}" id="createNewArea"> Create New
             Quarter Type</a>
                <table class="table table-bordered table-hover custom_table dataTable" id="userlist">
                <thead>
                <tr>
                    <th rowspan="2">Quarter Type</th>
                    
                    <th colspan="2" >Basic Pay</th>
                    <th colspan="4" >Rent</th>
                    
                    <th  rowspan="2" >Action</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Normal</th>
                    <th>Standard</th>
                    <th>Economical</th>
                    <th>Market</th>
                    
                    
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
@endsection
@push('page-ready-script')
console.log('page is ready');
@endpush
@push('footer-script')
<script type="text/javascript">
  $(document).ready(function () {
        load_table();
        $('#userlist').dataTable().fnDestroy();
    });
    oTable='';
    function load_table() {

        oTable = $('#userlist').dataTable({
            processing: true,
            serverSide: true,
            columns: [
                {data: 'quartertype', name: 'quartertype'},
                {data: 'bpay_from', name: 'bpay_from'},
                {data: 'bpay_to', name: 'bpay_to'},
                {data: 'rent_normal', name: 'rent_normal'},
                {data: 'rent_standard', name: 'rent_standard'},
                {data: 'rent_economical', name: 'rent_economical'},
                {data: 'rent_market', name: 'rent_market'},
                
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            ajax: {
      url: "{{ URL::action('QuarterTypeController@getList') }}",
      'type': 'POST',
  },
       
            fnDrawCallback: function (oSettings) { console.log(oSettings);
             
                $('#userlist tbody tr td').click(function () {
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
        alert(id);
        confirm("Are You sure want to delete !");
        $.ajax({
          type: "DELETE",
          url: "{{ route('masterquartertype.destroy',"+ id +") }}",
        
          success: function (data) {
            load_table();
          },
          error: function (data) {
              console.log('Error:', data);
          }
        });
    });                
                  
</script>
@endpush