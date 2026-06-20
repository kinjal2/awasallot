<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $this->_viewContent['page_title'] = "User Permission";

        $this->_viewContent['users'] = DB::table('userschema.users')
            ->orderBy('name')
            ->get();

        $this->_viewContent['menus'] = DB::table('menu.menus')
            ->orderBy('display_order')
            ->get();

        $userId = $request->user_id ?? 1;

        $this->_viewContent['userId'] = $userId;

        $this->_viewContent['assignedMenus'] = DB::table('menu.user_menu_permissions')
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->pluck('menu_id')
            ->toArray();

        return view(
            'userpermission.index',
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
        DB::table('menu.user_menu_permissions')

            ->where('user_id', $request->user_id)

            ->delete();

        if ($request->menus) {

            foreach ($request->menus as $menuId) {

                DB::table('menu.user_menu_permissions')

                    ->insert([

                        'user_id' => $request->user_id,

                        'menu_id' => $menuId,

                        'is_active' => true,

                        'created_at' => now(),

                    ]);
            }
        }

        return back()->with(
            'success',
            'User Permission Updated Successfully'
        );
    }
}