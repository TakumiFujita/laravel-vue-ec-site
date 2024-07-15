<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'ファッション',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '家電',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '本・コミック',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '食品',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '楽器',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'スポーツ・アウトドア',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
