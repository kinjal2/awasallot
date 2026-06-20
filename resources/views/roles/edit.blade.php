@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')

<div class="content">

    <!-- Content Header -->

    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0 text-dark">
                        Edit Role
                    </h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item">

                            <a href="#">
                                Home
                            </a>

                        </li>

                        <li class="breadcrumb-item active">

                            Edit Role

                        </li>

                    </ol>

                </div>

            </div>

        </div>

    </div>

    <!-- /.content-header -->

    <div class="col-md-12">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    Edit Role

                </h3>

            </div>

            <form method="POST"
                  action="{{ route('roles.update', $role->id) }}">

                @csrf

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Role Name
                                </label>

                                <input type="text"
                                       name="role_name"
                                       class="form-control"
                                       value="{{ $role->role_name }}">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Role Code
                                </label>

                                <input type="text"
                                       name="role_code"
                                       class="form-control"
                                       value="{{ $role->role_code }}">

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card-footer">

                    <button type="submit"
                            class="btn btn-success">

                        Update Role

                    </button>

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

</script>

@endpush