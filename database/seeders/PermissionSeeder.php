<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'User' => [
                'Add User',
                'Edit User',
                'Show User',
                'List User',
                'Delete User'
            ],
            'Role' => [
                'Add Role',
                'Edit Role',
                'Show Role',
                'List Role',
                'Delete Role'
            ],
            'Settings' => [
                'Site Settings'
            ]

        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($permissions as $parent => $child) {
            $parent_data = \App\Models\Permission::create([
                'name' => $parent,
                'guard_name' => 'web'
            ]);

            foreach ($child as $c) {
                \App\Models\Permission::create([
                    'name' => $c,
                    'guard_name' => 'web',
                    'parent_id' => $parent_data->id
                ]);
            }
        }
    }
}
