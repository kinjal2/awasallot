@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')

<div class="content">

    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0 text-dark">
                        Role Management
                    </h1>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-12">

        <div class="card card-head">

            <div class="card-header">

                <h3 class="card-title">

                    Role List

                </h3>

                <div class="card-tools">

                    <a href="{{ route('roles.create') }}"
                       class="btn btn-primary btn-sm">

                        Add Role

                    </a>

                </div>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Role Name</th>

                            <th>Role Code</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($roles as $role)

                        <tr>

                            <td>

                                {{ $role->id }}

                            </td>

                            <td>

                                {{ $role->role_name }}

                            </td>

                            <td>

                                {{ $role->role_code }}

                            </td>

                            <td>

                                <a href="{{ route('roles.edit', $role->id) }}"
                                   class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection