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

    public function send_password_change_link(Request $request)
    {

        $request->validate([
            'email' => 'required|email:rfc,dns'
        ]);
        $is_exists = User::where('email', $request->email)->exists();

        if(!$is_exists) {
            return redirect()->route('forgot-password');
        }
        else {
            //here send a password reset link
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken();
            $user->sendForgotPassNotification($token);
        }

    }

}
