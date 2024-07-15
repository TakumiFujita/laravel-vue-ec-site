<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => '管理者',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '出品者',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '購入者',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'ゲスト',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
