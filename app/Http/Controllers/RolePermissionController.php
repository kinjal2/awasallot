<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $this->_viewContent['page_title'] = "Role Permission";

        $this->_viewContent['roles'] = DB::table('menu.roles')
            ->orderBy('id')
            ->get();

        $this->_viewContent['menus'] = DB::table('menu.menus')
            ->orderBy('display_order')
            ->get();

        $roleId = $request->role_id ?? 1;

        $this->_viewContent['roleId'] = $roleId;

        $this->_viewContent['assignedMenus'] = DB::table('menu.role_menu_permissions')
            ->where('role_id', $roleId)
            ->pluck('menu_id')
            ->toArray();

        return view(
            'rolepermission.index',
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
        DB::table('menu.role_menu_permissions')

            ->where('role_id', $request->role_id)

            ->delete();

        if ($request->menus) {

            foreach ($request->menus as $menuId) {

                DB::table('menu.role_menu_permissions')

                    ->insert([

                        'role_id' => $request->role_id,

                        'menu_id' => $menuId,

                        'can_view' => true,

                        'can_add' => true,

                        'can_edit' => true,

                        'can_delete' => true,

                        'created_at' => now(),

                        'updated_at' => now(),

                    ]);
            }
        }

        return back()->with(
            'success',
            'Permission Updated Successfully'
        );
    }
}