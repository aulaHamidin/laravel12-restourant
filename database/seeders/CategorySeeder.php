<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'cat_name' => 'Appetizers',
                'description' => 'Starters to whet your appetite',
            ],
            [
                'cat_name' => 'Main Course',
                'description' => 'Hearty main dishes',
            ],
            [
                'cat_name' => 'Desserts',
                'description' => 'Sweet treats to end your meal',
            ],
            [
                'cat_name' => 'Beverages',
                'description' => 'Refreshing drinks to accompany your food',
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
