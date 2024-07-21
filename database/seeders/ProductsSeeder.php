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
                'image_path' => 'https://tailwindui.com/img/ecommerce-images/product-page-02-secondary-product-shot.jpg',
                'stock_quantity' => 10,
                'price' => 1000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product2',
                'description' => 'Description for product2',
                'image_path' => 'https://tailwindui.com/img/ecommerce-images/product-page-02-tertiary-product-shot-01.jpg',
                'stock_quantity' => 20,
                'price' => 2000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product3',
                'description' => 'Description for product3',
                'image_path' => 'https://tailwindui.com/img/ecommerce-images/product-page-02-tertiary-product-shot-02.jpg',
                'stock_quantity' => 30,
                'price' => 3000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product4',
                'description' => 'Description for product4',
                'image_path' => 'https://tailwindui.com/img/ecommerce-images/product-page-02-featured-product-shot.jpg',
                'stock_quantity' => 40,
                'price' => 4000,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
