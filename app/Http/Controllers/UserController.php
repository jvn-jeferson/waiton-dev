<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\AccountingOffice;
use App\Models\AccountingOfficeStaff;
use App\Models\Client;
use App\Models\ClientStaff;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Hashids\Hashids;

use Mail;

use App\Mail\PasswordResetMail;
use App\Mail\AccountingOfficeRegistrationMail;

class UserController extends Controller
{
    public function ao_registration(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:accounting_offices,name',
            'representative' => 'required',
            'address' => 'required',
            'telephone' => 'required|unique:accounting_offices,telephone',
            'email' => 'required|unique:users,email|email:rfc,dns',
        ]);

        DB::transaction(function () use ($request) {
            $pw = Str::random(8);
            $hashids = new Hashids(config('hashids.login_salt'), 10);
            $user_id = User::insertGetId([
                'email' => $request->input('email'),
                'password' => Hash::make($pw),
                'role_id' => 2,
                'is_online' => 0,
                'remember_token' => Str::random(60),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            if ($user_id) {
                $user = User::findOrFail($user_id);
                $login_id = "A" . date('Y') . $user->role_id . $user_id . "";
                $user->update([
                    'login_id' => $login_id
                ]);
                $user->save();

                $accountingId = AccountingOffice::insertGetId([
                    'user_id' => $user_id,
                    'name' => $request->input('name'),
                    'representative' => $request->input('representative'),
                    'address' => $request->input('address'),
                    'telephone' => $request->input('telephone'),
                    'contact_email' => $request->input('email'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                $staff_id = AccountingOfficeStaff::insertGetId([
                    'accounting_office_id' => $accountingId,
                    'user_id' => $user_id,
                    'name' => $request->input('representative'),
                    'is_admin' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                $user = User::findOrFail($user_id);
                $accountingOffice = AccountingOffice::findOrFail($accountingId);
                $token = $user->remember_token;
                $this->sendAORegistrationEmail($token, $user, $pw, $accountingOffice);
            }
        });

        return View::make('main.payment_success');
    }

    public function sendAORegistrationEmail($token, User $user, $password, $accountingOffice)
    {
        Mail::to($user->email)->send(new AccountingOfficeRegistrationMail($token, $user, $password, $accountingOffice));

        if (Mail::failures()) {
            abort(403);
        }

        return 'SUCCESS';
    }

    public function first_time_login(Request $request)
    {
        $user = User::where('remember_token', $request->token)->first();
        if (isset($user->email_verified_at)) {
            return abort(403);
        }
        return View::make('auth.passwords.reset')->with('token', $request->token);
    }
    public function forgot_password()
    {
        return View::make('auth.passwords.request_reset_password');
    }

    public function send_password_change_link(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|exists:users'
        ]);

        if ($validator->fails()) {
            return redirect()->route('forgot-password')
                ->withErrors($validator)
                ->withInput();
        }

        //here send a password reset link
        $user = User::where('email', $request->email)->first();

        $new_password = Str::random(8);

        $user->update([
            'password' => Hash::make($new_password),
            'remember_token' => Str::random(60)
        ]);

        $user->save();

        $this->sendEmail($user, $new_password);

        return View::make('auth.passwords.reset-notif');
    }

    public function sendEmail($user, $new_password)
    {
        Mail::to($user->email)->send(new PasswordResetMail($user, $new_password));

        if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again later.');
        }

        return "Success";
    }

    public function update_password(Request $request)
    {
        $user = User::where('remember_token', $request->remember_token)->first();
        if($user == null)
        {
            abort(403);
        }
        return View::make('auth.passwords.update_password')->with(['login_id' => $user->login_id]);
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), ['password' => 'required|confirmed']);

        if ($validator->fails()) {
            return redirect()->route('update-password', ['login_id' => $request->login_id])
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('login_id', $request->input('login_id'))->first();

        $user->createToken();
        $user->update([
            'password' => Hash::make($request->input('password')),
            'email_verified_at' => Carbon::now()
        ]);
        $user->save();

        return View::make('auth.passwords.password_change_success');
    }

    public function update_credentials(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_id' => 'required|exists:users',
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->route('first-time-login')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('login_id', $request->input('login_id'))->first();

        $user->createToken();
        $user->update([
            'password' => Hash::make($request->input('password')),
            'email_verified_at' => Carbon::now()
        ]);
        $user->save();

        return View::make('auth.passwords.password_change_success');
    }
}
