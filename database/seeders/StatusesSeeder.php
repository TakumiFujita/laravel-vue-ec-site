<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            [
                'name' => '注文受付',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '支払い待ち',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '注文完了',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'キャンセル',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
