<?php

namespace Database\Seeders;

use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('student_profiles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create();

        $student = User::updateOrCreate([
            'first_name'            => 'test',
            'last_name'             => 'student',
            'email'                 => 'student@app.com',
            'phone'                 => '1234567890',
            'gender'                => 1,
            'email_verified_at'     => now(),
            'password'              => \Illuminate\Support\Facades\Hash::make('12345678'),
            'status'                => User::STATUS_ACTIVE,
            'type'                  => User::TYPE_STUDENT,
            'remember_token'        => Str::random(10),
        ]);

        StudentProfile::create([
            'user_id'           => $student->id,
            'address'           => $faker->address(),
            'city'              => $faker->city(),
            'state'             => $faker->state(),
            'country'           => $faker->country(),
            'zip_code'          => $faker->postcode(),
            'about'             => $faker->paragraph(),
            'dob'               => $faker->date(),
            'medical_license'   => $faker->word(),
            'license_type'      => $faker->word(),
            'license_number'    => $faker->word(),

            'facebook'      => $faker->url(),
            'twitter'       => $faker->url(),
            'linkedin'      => $faker->url(),
            'instagram'     => $faker->url(),
            'youtube'       => $faker->url(),
            'website'       => $faker->url(),
//            'created_by'    => 1,
//            'updated_by'    => 1,
        ]);


        User::factory(10)->create([
            'type' => User::TYPE_STUDENT,
        ])->each(function ($user) {
            StudentProfile::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
