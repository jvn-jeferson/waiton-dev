<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'email' => 'jbonayon15@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'is_online' => 0,
            'remember_token' => Str::random(25),
        ]);

        DB::table('users')->insert([
            'email' => 'jeffbu.dev@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'is_online' => 0,
            'remember_token' => Str::random(25),
        ]);
    }
}
