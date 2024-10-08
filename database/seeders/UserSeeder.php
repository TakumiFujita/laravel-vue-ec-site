<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
            'address' => 'test address',
            'phone_number' => '1234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
