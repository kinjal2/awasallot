<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;

class MenuController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MENU LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
     
    $this->_viewContent['page_title'] = "Menu Management";
    $this->_viewContent['menus'] = Menu::with('children')
                                   ->whereNull('parent_id')
                                    ->orderBy('display_order')
                                    ->get();
    return view('menus.index',$this->_viewContent);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE SCREEN
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->_viewContent['page_title'] = "Add Menu";
        $this->_viewContent['parentMenus']  = Menu::whereNull('parent_id')
            ->orderBy('display_order')
            ->get();

        return view('menus.create',$this->_viewContent);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE MENU
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'menu_name' => 'required',

            'menu_title' => 'required',

        ]);

        Menu::create([

            'parent_id'       => $request->parent_id,

            'menu_name'       => $request->menu_name,

            'menu_title'      => $request->menu_title,

            'route_name'      => $request->route_name,

            'url'             => $request->url,

            'icon'            => $request->icon,

            'permission_name' => $request->permission_name,

            'menu_level'      => $request->parent_id ? 2 : 1,

            'display_order'   => $request->display_order,

            'is_visible'      => true,

            'is_active'       => true,

            'created_by'      => 1,

            'updated_by'      => 1,

        ]);

        return redirect()
            ->route('menus.index')
            ->with(
                'success',
                'Menu Added Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT SCREEN
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {  
        $this->_viewContent['page_title'] = "Edit Menu";

        $this->_viewContent['menu'] = Menu::findOrFail($id);

        $this->_viewContent['parentMenus'] = Menu::whereNull('parent_id')
            ->orderBy('display_order')
            ->get();

        return view(
            'menus.edit',
            $this->_viewContent
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE MENU
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $menu->update([

            'parent_id'       => $request->parent_id,

            'menu_name'       => $request->menu_name,

            'menu_title'      => $request->menu_title,

            'route_name'      => $request->route_name,

            'url'             => $request->url,

            'icon'            => $request->icon,

            'permission_name' => $request->permission_name,

            'menu_level'      => $request->parent_id ? 2 : 1,

            'display_order'   => $request->display_order,

            'updated_by'      => 1,

        ]);

        return redirect()
            ->route('menus.index')
            ->with(
                'success',
                'Menu Updated Successfully'
            );
    }
}