<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu.menus';

    protected $fillable = [
        'parent_id',
        'menu_name',
        'menu_title',
        'route_name',
        'url',
        'icon',
        'permission_name',
        'menu_level',
        'display_order',
        'is_visible',
        'is_active'
    ];

        public function children()
        {
        return $this->hasMany(Menu::class, 'parent_id')
        ->where('is_visible', true)
        ->where('is_active', true)
        ->orderBy('display_order');
        }
}