<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('categories')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Test 1',
                    'slug' => 'test-1',
                    'description' => 'test 1',
                    'image' => NULL,
                    'created_by' => '1',
                    'created_at' => '2024-09-23 12:48:42',
                    'updated_by' => NULL,
                    'updated_at' => NULL,
                    'deleted_by' => NULL,
                    'deleted_at' => NULL,
                ),

                1 =>
                    array (
                        'id' => 2,
                        'name' => 'Test 2',
                        'slug' => 'test-2',
                        'description' => 'test 2',
                        'image' => NULL,
                        'created_by' => '2',
                        'created_at' => '2024-09-23 12:49:42',
                        'updated_by' => NULL,
                        'updated_at' => NULL,
                        'deleted_by' => NULL,
                        'deleted_at' => NULL,
                    ),

                    2 =>
                    array (
                        'id' => 3,
                        'name' => 'Test 3',
                        'slug' => 'test-3',
                        'description' => 'test 3',
                        'image' => NULL,
                        'created_by' => '1',
                        'created_at' => '2024-09-23 12:50:42',
                        'updated_by' => NULL,
                        'updated_at' => NULL,
                        'deleted_by' => NULL,
                        'deleted_at' => NULL,
                    ),

                    3 =>
                    array (
                        'id' => 4,
                        'name' => 'Test 4',
                        'slug' => 'test-4',
                        'description' => 'test 4',
                        'image' => NULL,
                        'created_by' => '2',
                        'created_at' => '2024-09-23 12:51:42',
                        'updated_by' => NULL,
                        'updated_at' => NULL,
                        'deleted_by' => NULL,
                        'deleted_at' => NULL,
                    ),
        ));
    }
}
