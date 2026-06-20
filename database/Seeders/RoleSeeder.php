<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu.roles')->truncate();

        DB::table('menu.roles')->insert([

            [
                'role_name' => 'Super Admin',
                'role_code' => 'superadmin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'role_name' => 'Admin',
                'role_code' => 'admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'role_name' => 'User',
                'role_code' => 'user',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'role_name' => 'DDO User',
                'role_code' => 'ddouser',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]

        ]);
    }
}