<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class HostController extends Controller
{
    public function index() {
        return View::make('host/dashboard');
    }

    public function screen_record() {
        return View::make('host/video-recording');
    }
}
