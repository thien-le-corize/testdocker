<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123123'),
            'role_id' => 1,
            'isValid' => true,
            'phone' => '12345678'
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123123123'),
            'role_id' => 2,
            'isValid' => true,
            'phone' => '123456789'
        ]);

        DB::table('users')->insert([
            'name' => 'seller',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('123123123'),
            'role_id' => 3,
            'isValid' => true,
            'phone' => '1234567890'
        ]);
    }
}
