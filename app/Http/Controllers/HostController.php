<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request\Request;
use App\Http\Requests\NewClientRequest;
use App\Models\Files;
use App\Models\User;
use App\Models\Client;
use App\Models\AccountingOffice;
use App\Models\AccountingOfficeStaff;
use Hashids\Hashids;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use View;
use Session;


class HostController extends Controller
{
    protected $account;

    public function __construct()
    {
        $this->account = AccountingOffice::find(1)->first();
        $this->hashids = new Hashids('', 15);
        $this->hashfileids = new Hashids('Waiton Files', 10);
    }

    public function index()
    {
        return View::make('host.dashboard');
    }

    public function customer_selection()
    {
        $clients = Client::where('accounting_office_id', 1)->get();

        return View::make('host.customer-selection', ['clients' => $clients, 'hashids'=>$this->hashids]);
    }

    public function message_clients()
    {
        return View::make('host.message-clients');
    }

    public function client_list()
    {
        $clients = Client::where('accounting_office_id', 1)->get();
        return View::make('host.client-list', ['clients'=>$clients]);
    }

    public function account_management()
    {
        $staffs = AccountingOfficeStaff::where('accounting_office_id', 1)->get();
        return View::make('host.account-management', ['account' => $this->account, 'staffs'=> $staffs]);
    }

    public function plan_update()
    {
        return View::make('host.plan-update');
    }

    public function register_new_client(NewClientRequest $request)
    {
        $name = $request->input('company_name');
        $address = $request->input('company_address');
        $rep = $request->input('company_rep');
        $email = $request->input('company_email');
        $rep_address = $request->input('company_rep_address');
        $telephone = $request->input('company_telephone');
        $tax_filing_month = $request->input('filing_month');
        $business_type = $request->get('business_type');
        $nta_num = $request->input('company_nta_num');
        // $notify_on = implode(',', $request->input('notifier'));
        $temporary_password = Str::random(8);
        $account_office_id = 1;
        $token = Str::random(25);

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($temporary_password),
            'role_id' => 4,
            'is_online' => 0,
            'remember_token' => $token,
            'created_at' => time(),
        ]);

        $client_user_id = $user->id;

        $client = Client::create([
            'user_id' => $client_user_id,
            'accounting_office_id' => $account_office_id,
            'name' => $name,
            'business_type_id' => $business_type,
            'address' => $address,
            'telephone' => $telephone,
            'representative' => $rep,
            'tax_filing_month' => $tax_filing_month,
            'nta_num' => $nta_num,
            'business_type_id' => $business_type,
            'temporary_password' => $temporary_password,
            'verified_at' => time(),
        ]);

        Session::flash('success', 'Client has been registered.');
        return redirect()->route('customer-selection');
    }

    public function view_client($client_id) 
    {
        $id = $this->hashids->decode($client_id)[0];
        $client = Client::find($id)->first();

        return View::make('host.individual-clients.dashboard', ['client' => $client]);
    }

    public function contact_client($client_id) 
    {
        $id = $this->hashids->decode($client_id)[0];
        $client = Client::find($id)->first();

        return View::make('host.individual-clients.message-client', ['client' => $client]);
    }

    public function financial_history_client($client_id) 
    {
        $id = $this->hashids->decode($client_id)[0];
        $client = Client::find($id)->first();

        return View::make('host.individual-clients.financial-history', ['client' => $client, 'hashids' => $this->hashfileids]);
    }

    public function access_files_client($client_id, $file_id)
    {
        $id = $this->hashids->decode($client_id)[0];
        $client = Client::find($id)->first();
        return View::make('host.individual-clients.access-historical-file', ['client' => $client, 'hashids' => $this->hashids]);
    }

    public function video_creation()
    {
        return View::make('host.individual-clients.video-creation');
    }

    public function pdf_source(Request $request)
    {
        return $request->pdf;
    }
}
