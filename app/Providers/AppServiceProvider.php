<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    View::composer('*', function ($view) {

        /*
        |--------------------------------------------------------------------------
        | CHECK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!Auth::check() && !Auth::guard('ddo_users')->check()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | GET ROLE
        |--------------------------------------------------------------------------
        */

        $roleCode = session('role');

        /*
        |--------------------------------------------------------------------------
        | NORMAL LOGIN
        |--------------------------------------------------------------------------
        */

        if (!$roleCode && Auth::check()) {

            $roleId = Auth::user()->role_id;

        }

        /*
        |--------------------------------------------------------------------------
        | DDO LOGIN
        |--------------------------------------------------------------------------
        */

        else {

            $roleId = DB::table('menu.roles')
                ->where('role_code', $roleCode)
                ->value('id');
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE MENUS
        |--------------------------------------------------------------------------
        */

        $roleMenus = DB::table('menu.role_menu_permissions')
            ->where('role_id', $roleId)
            ->where('can_view', true)
            ->pluck('menu_id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | USER MENUS
        |--------------------------------------------------------------------------
        */

        $userMenus = [];

        if (Auth::check()) {

            $userMenus = DB::table('menu.user_menu_permissions')
                ->where('user_id', Auth::id())
                ->where('is_active', true)
                ->pluck('menu_id')
                ->toArray();
        }

        /*
        |--------------------------------------------------------------------------
        | MERGE MENUS
        |--------------------------------------------------------------------------
        */

        $allowedMenuIds = array_unique(
            array_merge(
                $roleMenus,
                $userMenus
            )
        );

        /*
        |--------------------------------------------------------------------------
        | LOAD MENUS
        |--------------------------------------------------------------------------
        */

        $menus = Menu::with([

            'children' => function ($query) use ($allowedMenuIds) {

                $query->whereIn('id', $allowedMenuIds)
                    ->where('is_visible', true)
                    ->where('is_active', true)
                    ->orderBy('display_order');

            }

        ])

        ->whereNull('parent_id')

        ->whereIn('id', $allowedMenuIds)

        ->where('is_visible', true)

        ->where('is_active', true)

        ->orderBy('display_order')

        ->get();

        /*
        |--------------------------------------------------------------------------
        | SHARE MENUS
        |--------------------------------------------------------------------------
        */

        $view->with('dynamicMenus', $menus);

    });
}
}