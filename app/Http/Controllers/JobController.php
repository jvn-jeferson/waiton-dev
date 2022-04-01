<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class JobController extends Controller
{
    public function cron()
    {
        Artisan::call('schedule:run');
    }
}
