<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Saugat Kumal',
                    'email' => 'saugatkumal452@gmail.com',
                    'password' => bcrypt('123456789'),
                    'remember_token' => '$2y$12$OHoGL5SvqLI927igkZHMmOTwkEoeDSOnzUmJfybifG4DnZ3alYrja',
                    'created_at' => '2024-09-12 12:48:42',
                    'updated_at' => '2024-09-12 12:48:42',
                ),
        ));
    }
}
