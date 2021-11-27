<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    public function redirectTo() 
    {
        $role = auth()->user()->role->id;

        switch($role)
        {
            case 1:
                abort(403);
                break;
            case 2:
            case 3:
                return '/home';
                break;
            case 4:
            case 5:
                return '/client-home';
                break;
            default:
                return '/login';
        }
    }
}
