<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AccountingOffice;
use App\Models\AccountingOfficeStaff;
use App\Models\Subscription;
use App\Models\Client;
use App\Models\ClientInvoice;
use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use View;
use Hash;
use Hashids\Hashids;
use Illuminate\Support\Facades\Artisan;

use Mail;
use App\Mail\InquiryMail;

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

  public function index()
  {
    return View::make('main/landing_page');
  }

  public function signin(Request $request)
  {
    $user_type = $request->user_type;
    if ($user_type == null) {
      $user_type = '会計事務所';
    }

    return View::make('auth/login')->with(['user_type' => $user_type]);
  }

  public function select_plan()
  {
    $plans = SubscriptionPlan::all();
    return View::make('main/select_plan', ['plans' => $plans]);
  }

  public function request_reset_password()
  {
    return View::make('auth/passwords/request_reset_password');
  }

  public function send_password_reset(Request $request)
  {
    $request->validate(
      [
        'email' => 'required|email:rfc,dns',
      ]
    );

    $user = User::where('email', $request->input('email'))->first();
    $login_id = $user->login_id;
    $token = $user->createToken();
    $user->sendResetPassNotification($token, $login_id);

    return View::make('main.payment_success');
  }

  public function password_reset_granted($token, $login_id)
  {
    echo 'HELLO';
  }


  public function confirm_payment()
  {
    return View::make('main/payment_window');
  }

  public function cron()
  {
    Artisan::call('schedule:run');
  }

  // public function checkout(Request $request)
  // {

  //   $request->validate([
  //     'name' => 'required',
  //     'address' => 'required',
  //     'representative' => 'required'
  //   ]);

  //   \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
  //   $customer = \Stripe\Customer::create([
  //     'email' => $request->stripeEmail,
  //     'source' => $request->stripeToken,
  //   ]);
  //   $subscription =  \Stripe\Subscription::create([
  //     'customer' => $customer->id,
  //     'items' => [[
  //       'price' => 'price_1Jq5VQDBrLv03ZFn0B6Doilf',
  //     ]],
  //     'trial_period_days' => 30,
  //   ]);

  //   $session = \Stripe\Checkout\Session::create([
  //     'payment_method_types' => ['card'],
  //     'subscription_data' => [
  //       'trial_period_days' => 30,
  //     ],
  //     'line_items' => [[
  //       'price' => 'price_1Jq5VQDBrLv03ZFn0B6Doilf',
  //       'quantity' => 1,
  //     ]],
  //     'mode' => 'subscription',
  //     'success_url' => 'https://example.com/success',
  //     'cancel_url' => 'https://example.com/cancel',
  //   ]);
  //   DB::transaction(function () use ($request, $customer, $subscription, $session) {

  //     $name = $request->name;
  //     $representative = $request->representative;
  //     $address = $request->address;
  //     $telephone = $request->telephone;
  //     $token = $request->stripeToken;
  //     $email = $request->stripeEmail;
  //     $subscription_plan = $request->subscription_plan;
  //     $temporary_password = 'password';

  //     $userId = User::insertGetId([
  //       'email' => $email,
  //       'password' => Hash::make($temporary_password),
  //       'role_id' => 2,
  //       'is_online' => 0,
  //       'remember_token' => $token
  //     ]);

  //     if ($userId) {
  //       $accountingId = AccountingOffice::insertGetId([
  //         'user_id' => $userId,
  //         'name' => $name,
  //         'representative' => $representative,
  //         'address' => $address,
  //         'telephone' => $telephone,
  //         'contact_email' => $email,
  //         'verified_at' => Carbon::now(),
  //       ]);

  //       Subscription::create([
  //         'accounting_office_id' => $accountingId,
  //         'subscription_plan_id' => $subscription_plan,
  //         'stripe_id' => $subscription->id,
  //         'stripe_status' => $subscription->status,
  //         'customer_id'  => $customer->id,
  //         'stripe_price' => $subscription->plan->amount,
  //         'quantity' => $subscription->quantiy,
  //         'trial_ends' => Carbon::parse($subscription->trial_end)->format('Y-m-d H:i:s'),
  //         'trial_start' => Carbon::parse($subscription->trial_start)->format('Y-m-d H:i:s')
  //       ]);

  //       ClientInvoice::create([
  //         'accounting_office_id' => $accountingId,
  //         'amount_due' => $subscription->plan->amount,
  //         'client_id' => $accountingId,
  //         'invoice_number' => $subscription->latest_invoice,
  //         'payment_invoice_status' => $session->payment_status,
  //         'subscription_id' => $subscription_plan,
  //         'token' => $session->id,
  //       ]);

  //       AccountingOfficeStaff::create([
  //         'accounting_office_id' => $accountingId,
  //         'user_id' => $userId,
  //         'is_admin' => 1,
  //         'name' => $name
  //       ]);

  //       $user = User::findorFail($userId);
  //       // $user->sendPasswordNotification($user->createToken());
  //     }
  //   });

  //   return View::make('main/payment_success', (['session_id' => $session->id]));
  // }

  public function change_password($uid)
  {
    return View::make('auth/passwords/change_passwords', (['uid' => $uid]));
  }

  public function redirectuser()
  {
    if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3) {
      return redirect('home');
    } else if (Auth::user()->role_id == 4 || Auth::user()->role_id == 5) {
      return redirect('client-home');
    } else {
      abort(403);
    }
  }

  public function send_inquiry(Request $request)
  {
    Mail::to('jbonayon15@gmail.com')->send(new InquiryMail(Auth::user()->email, $request->content));

    if (Mail::fails()) {
      return 'failure';
    } else {
      return 'success';
    }
  }
}
