@extends(\Config::get('app.theme') . '.master')
@section('title', $page_title)
@section('content')

<div class="content">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">DDO List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Area List</li>
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
                <h3 class="card-title">Area List</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">
                <a class="btn btn-success mb-3" href="{{ route('masterarea.addNewArea') }}" id="createNewArea"> Create New
                    Area</a>
                @if (session('success'))
                <div id="success" class="alert  alert-light alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="table-responsive p-4">

                    <table class="table table-bordered table-hover custom_table dataTable" id="arealist">
                        <thead>
                            <tr>
                                <th>{{ __('area.area_name') }}</th>
                                <th>{{ __('area.address') }}</th>
                                <th>{{ __('area.address_gujatati') }}</th>
                                <th></th>


                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
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
            $(document).ready(function() {
                load_table();
            });

            function load_table() {

                oTable = $('#arealist').dataTable({
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,
                    columns: [{
                            data: 'areaname',
                            name: 'areaname'
                        },
                        {
                            data: 'address',
                            name: 'address'
                        },
                        {
                            data: 'address_g',
                            name: 'address_g'
                        },


                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    ajax: {
                        url: "{{ URL::action('AreaController@getList') }}",
                        'type': 'POST',
                    },

                    fnDrawCallback: function(oSettings) { //console.log(oSettings);

                       /* $('#arealist tbody tr td').click(function() {
                            var par = $(this).parent('tr');
                            // var len = oTable.columns().header().length;
                            var len = oTable.fnSettings().aoColumns.length;
                            if ($(this).index() < len - 1) {
                                $editLnk = par.find('td:last > a.edit_row');
                                if ($editLnk[0]) {
                                    $editLnk[0].click();
                                }
                            }
                            // Get the data-id value
                            var id = $(this).data('id');
                            alert(id);
                        });*/
                    }
                });
            }

        //    $('body').on('click', '.edit', function() {
        // Get the data-id value
        var id = $(this).data('id');
             //   alert(id);
        // Make the AJAX request to fetch data for the specified ID
        /*$.ajax({
            url: "{{ url('masterarea') }}/" + id + "/edit",
            //url: '/masterarea/' + id +'/edit', // Adjust the URL to your endpoint
            type: 'GET',                 // Use GET to fetch data
            success: function(response) {
                // Handle the response, e.g., populate a form for editing
               // console.log(response);

                // Example of populating a form (assuming you have inputs with IDs)
            /*    $('#editForm #name').val(response.name);
                $('#editForm #description').val(response.description);
                // Show the edit modal or form if needed
                $('#editModal').modal('show');*/
        /*    },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error fetching data:', error);
            }
        });*/
  //   });
            $('body').on('click', '.delete', function() {

                var id = $(this).attr("destroy-id");

                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('masterarea.store') }}/" + id,
                    data: {
                        id: id
                    },
                    success: function(data) {
                        oTable.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        </script>
        @endpush
