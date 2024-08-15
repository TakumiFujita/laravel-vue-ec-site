<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_category')->insert([
            [
                'product_id' => 1,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 2,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 3,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_id' => 4,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
