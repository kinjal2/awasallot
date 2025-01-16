@extends(\Config::get('app.theme').'.master')
@section('title', $page_title)
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{  __('priority.priority_list') }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{  __('priority.priority_list') }}</li>
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
                <table class="table table-bordered table-hover custom_table dataTable" id="prioritylist">
                <thead>
                <tr>
                    <th>{{ __('priority.request_type') }}</th>
                    <th>{{ __('priority.waiting_list') }} <br/>{{ __('priority.no') }}</th>
                    <th> {{ __('priority.quarter') }} <br/>{{ __('priority.type') }} </th>
                    <th>{{ __('priority.name') }}</th>
                    <th>{{ __('priority.office') }}</th>
                    <th> {{ __('priority.contact_no') }}</th>
                    <th>{{ __('priority.eamil_id') }}</th>
                    <th>{{ __('priority.request_date') }}</th>
                    <th>Action</th>

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

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css"> 

<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>




<script type="text/javascript">
  $(document).ready(function () {
        load_table();
    });

    function load_table() {

        oTable = $('#prioritylist').dataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'pageLength'
        ],
        exportOptions: {
    modifer: {
      page: 'all',
      search: 'none'    }
  },
            columns: [
                {data: 'requesttype'},
                {data: 'wno'},
                {data: 'quartertype'},
                {data: 'name'},
                {data: 'office'},
                {data: 'contact_no'}, 
                {data: 'email'},
                {data: 'request_date'},
                {
                data: null,
                render: function(data, type, row) {
                return data.action + ' ' + data.delete;
                }
                },
            ],
            ajax: {
      url: "{{ URL::action('QuartersPriorityController@getList') }}",
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
     var type = $(this).attr("type");
     var rev = $(this).attr("rev-id");
     var uid = $(this).attr("uid");
    
     swal.fire({
                    title: "Alert",
                    text: "Are You sure want to delete ! ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                  }).then(function() {
                $.ajax({
                      type: "DELETE",
                      url: "{{ route('quarterlistpriority.store') }}"+'/'+1,
                      data:{id:id,rev:rev,type:type,uid:uid},
                      success: function (data) {
                        load_table();
                      },
                      error: function (data) {
                          console.log('Error:', data);
                      }
                  });
    });
 });
</script>
@endpush