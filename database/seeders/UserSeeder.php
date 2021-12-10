<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
            'login_id' => Str::random(12),
            'email' => 'ichikawa@upfiling.jp',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'is_online' => 0,
            'remember_token' => Str::random(60),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'login_id' => Str::random(12),
            'email' => 'administrator@upfiling.jp',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'is_online' => 0,
            'remember_token' => Str::random(60),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
