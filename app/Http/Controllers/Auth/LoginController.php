<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogin;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo() 
    {
        $role = auth()->user()->role_id;

        switch($role)
        {
            case 1:
                return '/administrator/home';
                break;
            case 2:
            case 3:
                return '/accounting_office';
                break;
            case 4:
            case 5:
                return '/client-home';
                break;
            default:
                return '/login';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'login_id';
    }

    // public function authenticated(App\Http\Controllers\Auth\Request $request, $user)
    // {
    //     UserLogin::create([
    //         'user_id' => $user->id,
    //         'ip_address' => $request->getClientIp()
    //     ]);
    // }
}
