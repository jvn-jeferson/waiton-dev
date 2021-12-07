<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\User;
use App\Models\AccountingOffice;
use View;
use Illuminate\Support\Facades\Mail;
use Hash;
use App\Mail\Email;
class PaymentController extends Controller
{
    
    public function payment_process(Request $request) {

        $email = $request->input('email');
        $pw = $request->input('temporary_password');
        $rep = $request->input('representative');
        $company = $request->input('name');


        $user = User::create([
            'email' => $email,
            'password' => Hash::make($pw),
            'role' => 1,
            'online_status' => 0,
            'remember_token' => 0
        ]);

        if($user->save()) {
            $uid = $user->id;

            $firm = Accounting_Office::create([
                'name' => $company,
                'representative' => $rep,
                'address' => $request->input('address'),
                'telephone' => $request->input('tel_number'),
                'temporary_password' => $request->input('temporary_password'),
                'verified_at' => 0,
                'user_id' => $uid
            ]);

            if($firm->save()) {
                $this->sendMail($company, $rep, $email, $pw);
            }
        }
    }

    private function sendMail($company, $rep, $email, $pw) {
        $target = $rep;
        $target_email = $email;
        $data = array('company' => $company, 'representative' => $rep, 'email' => $email, 'pw' => $pw);

        Mail::send('email.mail', $data, function($message) use ($target, $target_email) {
            $message->to($target_email, $target)->subject('Complete your Waiton registration.');
            $message->from(env('MAIL_FROM_ADDRESS'), 'Registration Validation');
        });
    }
}
