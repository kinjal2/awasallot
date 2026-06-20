<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $this->_viewContent['page_title'] = "Role Management";

        $this->_viewContent['roles'] = DB::table('menu.roles')

            ->orderBy('id')

            ->get();

        return view(
            'roles.index',
            $this->_viewContent
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->_viewContent['page_title'] = "Add Role";

        return view(
            'roles.create',
            $this->_viewContent
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        DB::table('menu.roles')

            ->insert([

                'role_name' => $request->role_name,

                'role_code' => $request->role_code,

                'is_active' => true,

                'created_at' => now(),

                'updated_at' => now(),

            ]);

        return redirect()
            ->route('roles.index')
            ->with(
                'success',
                'Role Added Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $this->_viewContent['page_title'] = "Edit Role";

        $this->_viewContent['role'] = DB::table('menu.roles')

            ->where('id', $id)

            ->first();

        return view(
            'roles.edit',
            $this->_viewContent
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        DB::table('menu.roles')

            ->where('id', $id)

            ->update([

                'role_name' => $request->role_name,

                'role_code' => $request->role_code,

                'updated_at' => now(),

            ]);

        return redirect()
            ->route('roles.index')
            ->with(
                'success',
                'Role Updated Successfully'
            );
    }
}