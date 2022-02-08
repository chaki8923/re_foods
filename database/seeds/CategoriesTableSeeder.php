<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([

            [
                'category_name' => '野菜',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'お肉',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'お魚',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => '調味料',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => '備品類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => '食器類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => '調理器具',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => '家具',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => '家電',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'お酒',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
