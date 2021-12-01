<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests\MessageRequest;
use App\Http\Requests\NewClientRequest;
use App\Http\Requests\AccountingOfficeStaffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Files;
use App\Models\User;
use App\Models\Client;
use App\Models\Post;
use App\Models\AccountingOffice;
use App\Models\AccountingOfficeStaff;
use App\Models\ClientInvoice;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\ClientStaff;
use App\Models\Message;
use App\Models\File;

use Carbon\Carbon;
use Hashids\Hashids;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use View;
use Session;
use DateTime;

class HostController extends Controller
{
    private $user;
    private $accounting_office;
    private $staff;
    private $subscription;
    private $subscription_plan;
    private $clients;

    public function __construct()
    {
        $this->hashids = new Hashids('', 15);
        $this->hashfileids = new Hashids('Waiton Files', 10);
    }

    private function set_globals()
    {
        $this->user = Auth::user();
        $this->accounting_office = AccountingOffice::firstWhere('user_id', $this->user->id);
        $this->staff = AccountingOfficeStaff::firstWhere('user_id', $this->user->id);
        $this->subscription = Subscription::firstWhere('accounting_office_id', $this->accounting_office->id);
        if($this->subscription) {     
            $this->subscription_plan = SubscriptionPlan::findorFail($this->subscription->subscription_plan_id);
        }else {
            $this->subscription_plan = null;
        }
        $this->clients = Client::where('accounting_office_id', $this->accounting_office->id)->get();
    }

    public function index()
    {  
        $this->set_globals();
        return View::make('host.dashboard')->with(['page_title'=> '事業所ホーム', 'subscription' => $this->subscription, 'account' => $this->accounting_office, 'staff' => $this->staff]);
    }

    public function customer_selection()
    {
        $this->set_globals();
        return View::make('host.customer-selection')->with(['page_title'=> '顧客の選択','clients' => $this->clients, 'hashids'=>$this->hashids]);
    }

    public function accounting_profile()
    {
        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        $account_office_id = Auth::user()->accountingOffice->id;
        $customer = Subscription::where('accounting_office_id',$account_office_id)->orderBy('created_at', 'desc')->first();
        $invoice_details = ClientInvoice::where('accounting_office_id',$account_office_id)->get();
        $cards = \Stripe\PaymentMethod::all([
            "customer" => $customer->customer_id, "type" => "card"
        ]);

        foreach($invoice_details as $inv_details)
        {
            $invoice = \Stripe\Invoice::retrieve($inv_details->invoice_number);
            $inv_details->date = Carbon::parse($inv_details->created_at)->format('d M Y');
            $inv_details->status = $inv_details->subscription->stripe_status;
            $invoice_pdf = $invoice->invoice_pdf;
            $inv_details->invoice_pdf = $invoice_pdf;
        }


        $cards_data = $cards->data;
        $cards_details = [];
        foreach($cards_data as $card)
        {
            if($card->card)
            {
                $brand = $card->card->brand;
                $country = $card->card->country;
                $exp_month = $card->card->exp_month;
                $exp_year = $card->card->exp_year;
                $card_type = $card->card->funding;
                $last_digits = $card->card->last4;
                $cards_details = [
                    'brand' => $brand,
                    'country' => $country,
                    'exp_month' => $exp_month,
                    'exp_year' => $exp_year,
                    'card_type' => $card_type,
                    'last_digits' => $last_digits,
                    'status'=>$customer->stripe_status,
                    'trial_at' => Carbon::parse($customer->trial_ends)->format('d M Y')
                ];
            }
         }
         $collection = collect($cards_details);
        return View::make('host.account-profile',['customer' => $collection,'invoice_details'=> $invoice_details]);
    }

    public function message_clients()
    {
        $this->set_globals();
        $messages = null;
        if(Auth::user()->role_id == 2){
            $messages = Message::where('accounting_office_id',$this->accounting_office->id)->get();
        }
        else {
            $messages = Message::where('user_id',$this->user->id)->get();
        }

        foreach($messages as $message) {
            
            $file_names = array();
            if(!$message->file_id == null) {
                $file_ids = explode(', ', $message->file_id);
                foreach($file_ids as $file) {
                    $file_name = File::find($file)->get('name');
                    array_push($file_names,$file_name);
                }
            }
            
            $message->file_names = implode(', ', $file_names);
        }
        
        return View::make('host.message-clients')->with(['page_title'=>'全顧客への連絡', 'messages' => $messages]);
    }

    public function client_list()
    {
        $clients = Client::where('accounting_office_id', 1)->get();
        return View::make('host.client-list')->with(['page_title'=> '顧客の一覧（閲覧）', 'clients'=>$clients]);
    }

    public function account_management()
    {
        $this->set_globals();
        $staffs = AccountingOfficeStaff::where('accounting_office_id', $this->accounting_office->id)->get();
        return View::make('host.account-management')->with(['page_title'=> '事務所内の管理', 'account' => $this->accounting_office, 'staffs'=> $staffs]);
    }

    public function register_new_staff(Request $request)
    {
        $this->set_globals();
        $request->validate([
            'is_admin' => 'required',
            'name' => 'required',
            'email' => 'required|email:rfc,dns'
        ]);

        $accounting_office_id = $this->accounting_office->id;
        $result = '';


        DB::transaction(function () use($request, $accounting_office_id, $result){

            $user_id = User::insertGetId([
                'email' => $request->input('email'),
                'password' => Hash::make(Str::random(8)),
                'role_id' => 3 - $request->input('is_admin'),
                'is_online' => 0,
                'remember_token' => Str::random(60)
            ]);

            if($user_id) {
                AccountingOfficeStaff::create([
                    'accounting_office_id' => $accounting_office_id,
                    'user_id' => $user_id,
                    'name' => $request->input('name'),
                    'is_admin' => $request->input('is_admin')
                ]);

                User::findorFail($user_id);
                //Send password reset

                $result = "success";
            }
            else {
                $result = "failure";
            }
        });
        
        return $result;
    }

    public function plan_update()
    {
        $this->set_globals();

        return View::make('host.plan-update')->with(['page_title' => 'プラン確認・変更']);
    }

    public function register_new_client(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'business_type_id' => 'required',
            'address' => 'required|max:255',
            'telephone' => 'required',
            'representative' => 'required',
            'tax_filing_month' => 'required',
            'email' => 'required|email:rfc,dns'
        ]);


        $host_id = Auth::user()->id;
        $accounting_office_id = AccountingOffice::where('user_id', $host_id)->first()->id;
        $token = Str::random(60);

        DB::transaction(function () use ($request, $accounting_office_id, $token){
            $user_id = User::insertGetId([
                'email' => $request->email,
                'password' => Hash::make('password'),
                'role_id' => 4,
                'is_online' => 0,
                'remember_token' => $token
            ]);
    
            if($user_id) {
                $client_id = Client::insertGetId([
                    'user_id' => $user_id,
                    'accounting_office_id' => $accounting_office_id,
                    'name' => $request->name,
                    'business_type_id' => $request->business_type_id,
                    'address' => $request->address,
                    'telephone' => $request->telephone,
                    'representative' => $request->representative,
                    'tax_filing_month' => $request->tax_filing_month
                ]);
    
                ClientStaff::create([
                    'client_id' => $client_id,
                    'user_id' => $user_id,
                    'name' => $request->representative,
                    'is_admin' => 1
                ]);
                return "Client creation successful";
            }
            else {
                return "Client creation failed";
            }
        });
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
        $file =  $request->file('file');

        $path = $file->store('public/files/temp');
        $contents = Storage::url($path);

        return $contents;

        
        //127.0.0.1:8080/storage/public/temp/file_name
    }

    public function send_notification(Request $request)
    {
        DB::transaction(function () use($request){

            $this->set_globals();
            $file_ids = array();

            if($request->hasfile('files')) {
                foreach($request->file('files') as $key => $file) {
                    $path = $file->store('public/files/uploaded/'.Auth::user()->id.'');
                    $name = $file->getClientOriginalName();

                    $file_id = File::insertGetId([
                        'user_id' => Auth::user()->id,
                        'path' => $path,
                        'name' => $name
                    ]);

                    array_push($file_ids, $file_id);
                }
            }

            Message::create([
                'user_id' => Auth::user()->id,
                'accounting_office_id' => $this->accounting_office->id,
                'accounting_office_staff_id' => $this->staff->id,
                'is_global' => $request->input('is_global'),
                'targeted_at' => $request->input('targeted_at'),
                'scheduled_at' => $request->input('scheduled_at'),
                'contents' => $request->input('contents'),
                'file_id' => implode(',' , $file_ids)
            ]);

            Session::flash('success', 'Notification has been sent.');
            return redirect('message_clients');
        });
    }
}
