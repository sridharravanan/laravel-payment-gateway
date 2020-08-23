<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();


        /*
         * Add Admin User
         *
         */
        if (config('roles.models.defaultUser')::where('email', '=', 'admin@gmail.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Admin',
                'email'    => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'phone_number' => '1234567890',
            ]);

            $newUser->attachRole($adminRole);
            
        }

    }
}
