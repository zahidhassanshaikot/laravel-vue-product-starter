<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $supperAdmin = User::updateOrCreate([
            'first_name'            => 'John',
            'last_name'            => 'Deo',
            'email'                 => 'admin@app.com',
            'phone'                 => '1234567890',
            'email_verified_at'     => now(),
            'password'              => \Illuminate\Support\Facades\Hash::make('12345678'),
            'status'                => User::STATUS_ACTIVE,
            'type'                  => 'Admin',
            'remember_token'        => Str::random(10),
        ]);

        $supperAdmin->assignRole('Super Admin');

        User::factory()->count(80)->create()->each(function ($user) {
            if($user->type == 'Admin') {
                $user->assignRole('Admin');
            } else {
                $user->assignRole('Manager');
            }
        });
//        $users = User::all();
//        foreach($users as $u){
//            $u->assignRole(1);
//        }
    }
}
