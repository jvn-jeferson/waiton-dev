<?php

namespace App\Http\Controllers;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Http\Requests\AccountingOfficeRequest;
use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;

use View;

class MainController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return View::make('main/landing_page');
    }

    public function select_plan() {
        $plans = SubscriptionPlan::all();
        return View::make('main/select_plan', ['plans'=>$plans ]);
    }

    public function register_office($subscription_plan) {
        $data = array('subscription_plan'=>$subscription_plan);

        return View::make('auth/register')->with('data', $data);
    }

    public function confirm_payment() {
        return View::make('main/payment_window');
    }

    public function checkout(AccountingOfficeRequest $request) {
        $subscription_plan =  $request->post('subscription_plan');
        $name = $request->post('name');
        $representative = $request->post('representative');
        $address = $request->post('address');
        $telephone = $request->post('telephone');
        $email = $request->post('contact_email');
        $temporary_password = Str::random(8);
        
        $plan = SubscriptionPlan::where('name', $subscription_plan)->first();
        $plan_id = $plan['id'];


        $data = array('name'=>$name,'representative'=>$representative,'address'=>$address,'telephone'=>$telephone,'email'=>$email, 'subscription_plan_id'=>$plan_id, 'temporary_password'=>$temporary_password);

        return View::make('main/payment_window', ['data'=>$data, 'plan'=>$plan]);

        }

    public function change_password($uid) {
        return View::make('auth/passwords/change_passwords', (['uid'=> $uid]));
    }
}
