<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('news')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'title' => 'News 1',
                    'slug' => 'news-1',
                    'image' => NULL,
                    'category_id' => '1',
                    'description' => 'news 1',
                    'status' => '1',
                    'published_at' => '2024-09-23 12:48:42',
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
                        'title' => 'News 2',
                        'slug' => 'news-2',
                        'image' => NULL,
                        'category_id' => '2',
                        'description' => 'news 2',
                        'status' => '0',
                        'published_at' => '2024-09-23 12:49:42',
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
                        'title' => 'News 3',
                        'slug' => 'news-3',
                        'image' => NULL,
                        'category_id' => '3',
                        'description' => 'news 3',
                        'status' => '1',
                        'published_at' => '2024-09-23 12:50:42',
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
                        'title' => 'News 4',
                        'slug' => 'news-4',
                        'image' => NULL,
                        'category_id' => '4',
                        'description' => 'news 4',
                        'status' => '0',
                        'published_at' => '2024-09-23 12:51:42',
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
