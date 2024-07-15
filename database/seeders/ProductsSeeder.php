<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Product1',
                'description' => 'Description for product1',
                'image_path' => 'path/to/image1.jpg',
                'stock_quantity' => 10,
                'price' => 1000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product2',
                'description' => 'Description for product2',
                'image_path' => 'path/to/image2.jpg',
                'stock_quantity' => 20,
                'price' => 2000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product3',
                'description' => 'Description for product3',
                'image_path' => 'path/to/image3.jpg',
                'stock_quantity' => 30,
                'price' => 3000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product4',
                'description' => 'Description for product4',
                'image_path' => 'path/to/image4.jpg',
                'stock_quantity' => 40,
                'price' => 4000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product5',
                'description' => 'Description for product5',
                'image_path' => 'path/to/image5.jpg',
                'stock_quantity' => 50,
                'price' => 5000,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
