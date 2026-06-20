<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuPermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu.role_menu_permissions')->truncate();

        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */

        $superAdmin = DB::table('menu.roles')
            ->where('role_code', 'superadmin')
            ->first();

        $allMenus = DB::table('menu.menus')->pluck('id');

        foreach ($allMenus as $menuId) {

            DB::table('menu.role_menu_permissions')->insert([

                'role_id'    => $superAdmin->id,
                'menu_id'    => $menuId,
                'can_view'   => true,
                'can_add'    => true,
                'can_edit'   => true,
                'can_delete' => true,
                'created_at' => now(),
                'updated_at' => now()

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = DB::table('menu.roles')
            ->where('role_code', 'admin')
            ->first();

        $adminMenus = DB::table('menu.menus')
            ->whereIn('menu_name', [

                'dashboard',
                'quarters',
                'reports',
                'profile',
                'logout'

            ])
            ->pluck('id');

        foreach ($adminMenus as $menuId) {

            DB::table('menu.role_menu_permissions')->insert([

                'role_id'    => $admin->id,
                'menu_id'    => $menuId,
                'can_view'   => true,
                'can_add'    => true,
                'can_edit'   => true,
                'can_delete' => false,
                'created_at' => now(),
                'updated_at' => now()

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $user = DB::table('menu.roles')
            ->where('role_code', 'user')
            ->first();

        $userMenus = DB::table('menu.menus')
            ->whereIn('menu_name', [

                'dashboard',
                'profile',
                'quarters',
                'new-request',
                'higher-category-quarter',
                'request-history',
                'logout'

            ])
            ->pluck('id');

        foreach ($userMenus as $menuId) {

            DB::table('menu.role_menu_permissions')->insert([

                'role_id'    => $user->id,
                'menu_id'    => $menuId,
                'can_view'   => true,
                'can_add'    => false,
                'can_edit'   => false,
                'can_delete' => false,
                'created_at' => now(),
                'updated_at' => now()

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | DDO USER
        |--------------------------------------------------------------------------
        */

        $ddoUser = DB::table('menu.roles')
            ->where('role_code', 'ddouser')
            ->first();

        $ddoMenus = DB::table('menu.menus')
            ->whereIn('menu_name', [

                'dashboard',
                'quarters',
                'request-list-normal',
                'rejected-list',
                'logout'

            ])
            ->pluck('id');

        foreach ($ddoMenus as $menuId) {

            DB::table('menu.role_menu_permissions')->insert([

                'role_id'    => $ddoUser->id,
                'menu_id'    => $menuId,
                'can_view'   => true,
                'can_add'    => false,
                'can_edit'   => true,
                'can_delete' => false,
                'created_at' => now(),
                'updated_at' => now()

            ]);
        }
    }
}