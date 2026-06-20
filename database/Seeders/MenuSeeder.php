<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu.menus')->truncate();

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        DB::table('menu.menus')->insert([

            'parent_id'       => null,
            'menu_name'       => 'dashboard',
            'menu_title'      => 'Dashboard',
            'route_name'      => 'admin.dashboard.admindashboard',
            'url'             => null,
            'icon'            => 'nav-icon fas fa-tachometer-alt',
            'permission_name' => 'dashboard',
            'menu_level'      => 1,
            'display_order'   => 1,
            'is_visible'      => true,
            'is_active'       => true,
            'created_by'      => 1,
            'updated_by'      => 1,
            'created_at'      => now(),
            'updated_at'      => now()

        ]);

        /*
        |--------------------------------------------------------------------------
        | QUARTERS
        |--------------------------------------------------------------------------
        */

        $quartersId = DB::table('menu.menus')->insertGetId([

            'parent_id'       => null,
            'menu_name'       => 'quarters',
            'menu_title'      => 'Quarters',
            'route_name'      => null,
            'url'             => '#',
            'icon'            => 'icon-home',
            'permission_name' => 'quarters',
            'menu_level'      => 1,
            'display_order'   => 2,
            'is_visible'      => true,
            'is_active'       => true,
            'created_by'      => 1,
            'updated_by'      => 1,
            'created_at'      => now(),
            'updated_at'      => now()

        ]);

        /*
        |--------------------------------------------------------------------------
        | QUARTERS SUB MENU
        |--------------------------------------------------------------------------
        */

        DB::table('menu.menus')->insert([

            [
                'parent_id'       => $quartersId,
                'menu_name'       => 'request-list-normal',
                'menu_title'      => 'Request List (Normal)',
                'route_name'      => 'quarter.list.normal',
                'url'             => null,
                'icon'            => 'fa fa-list',
                'permission_name' => 'quarter.list.normal',
                'menu_level'      => 2,
                'display_order'   => 1,
                'is_visible'      => true,
                'is_active'       => true,
                'created_by'      => 1,
                'updated_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'parent_id'       => $quartersId,
                'menu_name'       => 'rejected-list',
                'menu_title'      => 'Rejected List',
                'route_name'      => 'request.rejected',
                'url'             => null,
                'icon'            => 'fa fa-times',
                'permission_name' => 'request.rejected',
                'menu_level'      => 2,
                'display_order'   => 2,
                'is_visible'      => true,
                'is_active'       => true,
                'created_by'      => 1,
                'updated_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'parent_id'       => $quartersId,
                'menu_name'       => 'new-request',
                'menu_title'      => 'New Request',
                'route_name'      => 'user.Quarters',
                'url'             => null,
                'icon'            => 'far fa-circle',
                'permission_name' => 'user.Quarters',
                'menu_level'      => 2,
                'display_order'   => 3,
                'is_visible'      => true,
                'is_active'       => true,
                'created_by'      => 1,
                'updated_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'parent_id'       => $quartersId,
                'menu_name'       => 'higher-category-quarter',
                'menu_title'      => 'Higher Category Quarter Request',
                'route_name'      => 'user.quarter.higher',
                'url'             => null,
                'icon'            => 'far fa-circle',
                'permission_name' => 'user.quarter.higher',
                'menu_level'      => 2,
                'display_order'   => 4,
                'is_visible'      => true,
                'is_active'       => true,
                'created_by'      => 1,
                'updated_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'parent_id'       => $quartersId,
                'menu_name'       => 'request-history',
                'menu_title'      => 'Request History',
                'route_name'      => 'user.quarter.history',
                'url'             => null,
                'icon'            => 'fa fa-history',
                'permission_name' => 'user.quarter.history',
                'menu_level'      => 2,
                'display_order'   => 5,
                'is_visible'      => true,
                'is_active'       => true,
                'created_by'      => 1,
                'updated_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now()
            ]

        ]);

        /*
        |--------------------------------------------------------------------------
        | REPORTS
        |--------------------------------------------------------------------------
        */

        $reportsId = DB::table('menu.menus')->insertGetId([

            'parent_id'       => null,
            'menu_name'       => 'reports',
            'menu_title'      => 'Reports',
            'route_name'      => null,
            'url'             => '#',
            'icon'            => 'icon-home',
            'permission_name' => 'reports',
            'menu_level'      => 1,
            'display_order'   => 3,
            'is_visible'      => true,
            'is_active'       => true,
            'created_by'      => 1,
            'updated_by'      => 1,
            'created_at'      => now(),
            'updated_at'      => now()

        ]);

        /*
        |--------------------------------------------------------------------------
        | REPORT SUB MENUS
        |--------------------------------------------------------------------------
        */

        DB::table('menu.menus')->insert([

            [
                'parent_id'       => $reportsId,
                'menu_name'       => 'waiting-list',
                'menu_title'      => 'Waiting List',
                'route_name'      => 'waiting.list',
                'icon'            => 'fa fa-spinner',
                'permission_name' => 'waiting.list',
                'menu_level'      => 2,
                'display_order'   => 1,
                'is_visible'      => true,
                'is_active'       => true,
                'created_by'      => 1,
                'updated_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now()
            ],

            [
                'parent_id'       => $reportsId,
                'menu_name'       => 'quarter-allotment',
                'menu_title'      => 'Quarter Allotment',
                'route_name'      => 'allotment.list',
                'icon'            => 'fa fa-thumbs-up',
                'permission_name' => 'allotment.list',
                'menu_level'      => 2,
                'display_order'   => 2,
                'is_visible'      => true,
                'is_active'       => true,
                'created_by'      => 1,
                'updated_by'      => 1,
                'created_at'      => now(),
                'updated_at'      => now()
            ]

        ]);

        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        DB::table('menu.menus')->insert([

            'parent_id'       => null,
            'menu_name'       => 'profile',
            'menu_title'      => 'Profile',
            'route_name'      => 'user.profile',
            'url'             => null,
            'icon'            => 'fa fa-user',
            'permission_name' => 'user.profile',
            'menu_level'      => 1,
            'display_order'   => 4,
            'is_visible'      => true,
            'is_active'       => true,
            'created_by'      => 1,
            'updated_by'      => 1,
            'created_at'      => now(),
            'updated_at'      => now()

        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGOUT
        |--------------------------------------------------------------------------
        */

        DB::table('menu.menus')->insert([

            'parent_id'       => null,
            'menu_name'       => 'logout',
            'menu_title'      => 'Logout',
            'route_name'      => 'logout',
            'url'             => null,
            'icon'            => 'fas fa-sign-out-alt',
            'permission_name' => 'logout',
            'menu_level'      => 1,
            'display_order'   => 999,
            'is_visible'      => true,
            'is_active'       => true,
            'created_by'      => 1,
            'updated_by'      => 1,
            'created_at'      => now(),
            'updated_at'      => now()

        ]);
    }
}