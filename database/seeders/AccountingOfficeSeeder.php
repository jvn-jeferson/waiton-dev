<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountingOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounting_offices')->insert([
            'user_id' => 2,
            'name' => '	Ichikawa Tax Accountant Office',
            'representative' => 'Kinichi Ichikawa',
            'address' => '2-6-7 Higashitenma, Kita-ku, Osaka-shi, Osaka',
            'telephone' => '06-6356-3366',
            'contact_email' => 'jeffbu.dev@gmail.com',
            'temporary_password' => Str::random(8),
        ]);
    }
}
