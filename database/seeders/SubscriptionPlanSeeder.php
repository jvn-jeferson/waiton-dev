<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscription_plans')->insert([
                'name' => 'Basic',
                'price' => 600,
                'max_admin' => 2,
                'max_users' => 5,
                'max_clients' => 5,
                'max_storage' => 50,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            
        DB::table('subscription_plans')->insert([
                'name' => 'Intermediate',
                'price' => 1000,
                'max_admin' => 4,
                'max_users' => 10,
                'max_clients' => 25,
                'max_storage' => 120,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        DB::table('subscription_plans')->insert([
                'name' => 'Enterprise',
                'price' => 2000,
                'max_admin' => 10,
                'max_users' => 20,
                'max_clients' => 100,
                'max_storage' => 300,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
    
    }
}
