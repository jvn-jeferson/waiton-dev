<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class ClientController extends Controller
{
    public function index()
    {
        return View::make('client.dashboard');
    }

    public function going_out()
    {
        return View::make('client.outgoing');
    }

    public function going_in()
    {
        return View::make('client.incoming');
    }

    public function history()
    {
        // return View::make('client.history');
        echo request()->route()->getName();
    }

    public function access_stored_info()
    {
        return View::make('client.access-password-onetime');
    }

    public function view_stored_info()
    {
        return View::make('client.view-stored-info');
    }

    public function notification_history()
    {
        return View::make('client.notif-history');
    }

    public function various_settings()
    {
        return View::make('client.settings');
    }
}
