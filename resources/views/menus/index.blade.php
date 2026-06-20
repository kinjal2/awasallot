@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')

<div class="content">

    <!-- Content Header (Page header) -->

    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0 text-dark">
                        Menu Management
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

                            Menu Management

                        </li>

                    </ol>

                </div>

            </div>

        </div>

    </div>

    <!-- /.content-header -->

    <div class="col-md-12">

        <!-- general form elements -->

        <div class="card card-head">

            <div class="card-header">

                <h3 class="card-title">

                    Menu Management

                </h3>

                <div class="card-tools">

                    <a href="{{ route('menus.create') }}"
                       class="btn btn-primary btn-sm">

                        Add Menu

                    </a>

                </div>

            </div>

            <!-- /.card-header -->

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover custom_table">

                        <thead>

                            <tr>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Menu
                                </th>

                                <th>
                                    Route
                                </th>

                                <th>
                                    Order
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($menus as $menu)

                            <tr>

                                <td>

                                    {{ $menu->id }}

                                </td>

                                <td>

                                    <strong>

                                        {{ $menu->menu_title }}

                                    </strong>

                                </td>

                                <td>

                                    {{ $menu->route_name }}

                                </td>

                                <td>

                                    {{ $menu->display_order }}

                                </td>

                                <td>

                                    <a href="{{ route('menus.edit', $menu->id) }}"
                                       class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                </td>

                            </tr>

                            @foreach($menu->children as $child)

                            <tr>

                                <td>

                                    {{ $child->id }}

                                </td>

                                <td>

                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    └ {{ $child->menu_title }}

                                </td>

                                <td>

                                    {{ $child->route_name }}

                                </td>

                                <td>

                                    {{ $child->display_order }}

                                </td>

                                <td>

                                    <a href="{{ route('menus.edit', $child->id) }}"
                                       class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                </td>

                            </tr>

                            @endforeach

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

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