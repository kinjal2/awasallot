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
                            <li class="breadcrumb-item active">DDO List</li>
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
                    <h3 class="card-title">DDO List</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <div class="card-body">
                    <a class="btn btn-success mb-3" href="{{ route('ddo.addNewDDO') }}" id="createNewDDO"> Create New
                        DDO</a>
                    @if (session('success'))
                        <div id="success" class="alert  alert-light alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive p-4">

                        <table class="table table-bordered table-hover custom_table dataTable" id="ddolist">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>DDO Office Name</th>
                                    <th>District Name</th>
                                    <th>Cardex No</th>
                                    <th>DDO Registration No</th>
                                    <th>Email</th>
									{{-- <th>DTO Registration No</th>
                                    
                                    <th>Mobile No.</th>
                                    <th>Created At</th>
                                    <th>Updated At</th> --}}
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
            </div>
            <!-- /.card -->
        @endsection
        @push('page-ready-script')
        @endpush
        @push('footer-script')
            <script type="text/javascript">

                var table = $('#ddolist').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('ddo.showlist') }}",
                        'type': 'POST',
                    },
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'ddo_office'
                        },
                        {
                            data: 'district'
                        },
                        {
                            data: 'cardex_no'
                        },
                        {
                            data: 'ddo_reg_no'
                        },
                        {
                            data: 'ddo_office_email_id'
                        },

                       /* {
                            data: 'dto_registration_no'
                        },
                        
                        {
                            data: 'mobile_no'
                        },
                        {
                            data: 'created_at',
                            render: function(data) {
                             const date = new Date(data);
                            return date.toISOString().split('T')[0]; // Outputs: "2024-09-24"
                            }
                        },
                        {
                            data: 'updated_at',
                            render: function(data) {
                             const date = new Date(data);
                            return date.toISOString().split('T')[0]; // Outputs: "2024-09-24"
                            }
                        },*/
                        {
                            data: 'action'
                        },
                    ]
                });
            </script>
        @endpush
