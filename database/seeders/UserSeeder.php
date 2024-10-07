<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Saugat Kumal',
                    'email' => 'saugatkumal452@gmail.com',
                    'password' => bcrypt('123456789'),

                    'remember_token' => '$2y$12$OHoGL5SvqLI927igkZHMmOTwkEoeDSOnzUmJfybifG4DnZ3alYrja',
                    'status' => 1,
                    'created_at' => '2024-09-12 12:48:42',
                ),

                1 =>
                    array (
                        'id' => 2,
                        'name' => 'Test 1',
                        'email' => 'test@gmail.com',
                        'password' => bcrypt('123456789'),
                        'remember_token' => '$2y$12$OHoGL5SvqLI927igkZHMmOTwkEoeDSOnzUmJfybifG4DnZ3alYrja',
                        'status' => 0,
                        'created_at' => '2024-09-12 12:48:42',
                    ),

                2 =>
                    array (
                        'id' => 3,
                        'name' => 'Test 2',
                        'email' => 'test2@gmail.com',
                        'password' => bcrypt('123456789'),
                        'remember_token' => '$2y$12$OHoGL5SvqLI927igkZHMmOTwkEoeDSOnzUmJfybifG4DnZ3alYrja',
                        'status' => 0,
                        'created_at' => '2024-09-12 12:48:42',
                    ),
        ));
    }
}
