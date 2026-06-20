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
                        Edit Menu
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

                            Edit Menu

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

                    Edit Menu

                </h3>

            </div>

            <!-- /.card-header -->

            <!-- form start -->

            <form method="POST"
                  action="{{ route('menus.update', $menu->id) }}">

                @csrf

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Parent Menu
                                </label>

                                <select name="parent_id"
                                        class="form-control">

                                    <option value="">
                                        Main Menu
                                    </option>

                                    @foreach($parentMenus as $parent)

                                    <option value="{{ $parent->id }}"
                                        @if($menu->parent_id == $parent->id)
                                            selected
                                        @endif
                                    >

                                        {{ $parent->menu_title }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Menu Name
                                </label>

                                <input type="text"
                                       name="menu_name"
                                       class="form-control"
                                       value="{{ $menu->menu_name }}">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Menu Title
                                </label>

                                <input type="text"
                                       name="menu_title"
                                       class="form-control"
                                       value="{{ $menu->menu_title }}">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Route Name
                                </label>

                                <input type="text"
                                       name="route_name"
                                       class="form-control"
                                       value="{{ $menu->route_name }}">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Icon
                                </label>

                                <input type="text"
                                       name="icon"
                                       class="form-control"
                                       value="{{ $menu->icon }}">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Display Order
                                </label>

                                <input type="number"
                                       name="display_order"
                                       class="form-control"
                                       value="{{ $menu->display_order }}">

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card-footer">

                    <button type="submit"
                            class="btn btn-success">

                        Update Menu

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