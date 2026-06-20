@extends(\Config::get('app.theme').'.master')

@section('title', $page_title)

@section('content')

<div class="content">

    <div class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="m-0 text-dark">
                        Role Permission
                    </h1>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-12">

        <div class="card card-head">

            <div class="card-header">

                <h3 class="card-title">

                    Manage Role Permission

                </h3>

            </div>

            <form method="POST"
                  action="{{ route('role.menu.store') }}">

                @csrf

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>
                                    Select Role
                                </label>

                                <select name="role_id"
                                        class="form-control"
                                        onchange="window.location='?role_id='+this.value">

                                    @foreach($roles as $role)

                                    <option value="{{ $role->id }}"
                                        {{ $roleId == $role->id ? 'selected' : '' }}>

                                        {{ $role->role_name }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        @foreach($menus as $menu)

                        <div class="col-md-3">

                            <div class="form-check mb-2">

                                <input type="checkbox"
                                       name="menus[]"
                                       value="{{ $menu->id }}"
                                       class="form-check-input"

                                       @if(in_array($menu->id, $assignedMenus))
                                           checked
                                       @endif
                                >

                                <label class="form-check-label">

                                    {{ $menu->menu_title }}

                                </label>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

                <div class="card-footer">

                    <button type="submit"
                            class="btn btn-success">

                        Save Permission

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection