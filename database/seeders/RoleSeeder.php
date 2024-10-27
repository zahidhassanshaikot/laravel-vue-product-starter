<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $user       = User::where('email', 'admin@app.com')->first();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $role = Role::updateOrCreate([
            'name'       => 'Super Admin',
            'guard_name' => 'web',
        ]);
        Role::updateOrCreate([
            'name'       => 'Admin',
            'guard_name' => 'web',
        ]);
        $manager_role = Role::updateOrCreate([
            'name'       => 'Manager',
            'guard_name' => 'web',
        ]);

        $permissions = Permission::pluck('name')->toArray();

        $role->givePermissionTo($permissions);
//        $user->syncRoles($role->id);

//        $manager    = User::where('email', 'manager@app.com')->first();
//        $manager_role->givePermissionTo($permissions);
//        $manager->syncRoles($manager_role->id);
    }
}
