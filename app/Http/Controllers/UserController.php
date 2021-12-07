<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function forgot_password()
    {
        return View::make('auth.passwords.request_reset_password');
    }

    public function send_forgot_password_link(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns'
        ]);

        
    }

}
