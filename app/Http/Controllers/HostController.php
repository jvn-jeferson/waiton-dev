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
use App\Models\ClientUpload;
use App\Models\HostUpload;

use Carbon\Carbon;
use Hashids\Hashids;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

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
        if ($this->subscription) {
            $this->subscription_plan = SubscriptionPlan::findorFail($this->subscription->subscription_plan_id);
        } else {
            $this->subscription_plan = null;
        }
        $this->clients = Client::where('accounting_office_id', $this->accounting_office->id)->get();
    }

    public function index()
    {
        $this->set_globals();
        return View::make('host.dashboard')->with(['page_title' => '事業所ホーム', 'subscription' => $this->subscription, 'account' => $this->accounting_office, 'staff' => $this->staff]);
    }

    public function customer_selection()
    {
        $this->set_globals();
        return View::make('host.customer-selection')->with(['page_title' => '顧客の選択', 'clients' => $this->clients, 'hashids' => $this->hashids]);
    }

    public function accounting_profile()
    {
        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        $account_office_id = Auth::user()->accountingOffice->id;
        $customer = Subscription::where('accounting_office_id', $account_office_id)->orderBy('created_at', 'desc')->first();
        $invoice_details = ClientInvoice::where('accounting_office_id', $account_office_id)->get();
        $cards = \Stripe\PaymentMethod::all([
            "customer" => $customer->customer_id, "type" => "card"
        ]);

        foreach ($invoice_details as $inv_details) {
            $invoice = \Stripe\Invoice::retrieve($inv_details->invoice_number);
            $inv_details->date = Carbon::parse($inv_details->created_at)->format('d M Y');
            $inv_details->status = $inv_details->subscription->stripe_status;
            $invoice_pdf = $invoice->invoice_pdf;
            $inv_details->invoice_pdf = $invoice_pdf;
        }


        $cards_data = $cards->data;
        $cards_details = [];
        foreach ($cards_data as $card) {
            if ($card->card) {
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
                    'status' => $customer->stripe_status,
                    'trial_at' => Carbon::parse($customer->trial_ends)->format('d M Y')
                ];
            }
        }
        $collection = collect($cards_details);
        return View::make('host.account-profile', ['customer' => $collection, 'invoice_details' => $invoice_details]);
    }

    public function message_clients()
    {
        $this->set_globals();
        $user_ids = [];
        $users = User::whereIn('role_id',[2,3])->get();
        foreach ($users as $user)
        {
            if($user->accountingOfficeStaff->accountingOffice->id == Auth::user()->accountingOfficeStaff->accountingOffice->id)
            {
                array_push($user_ids, $user->id);
            }
        }

        
        $messages = null;
        if(Auth::user()->role_id == 2){
            $messages = Message::whereIn('user_id',$user_ids)->get();
        }
        else {
            $messages = Message::where('user_id',$this->user->id)->get();
        }

        foreach ($messages as $message) {

            $file_names = array();
            if (!$message->file_id == null) {
                $file_ids = explode(', ', $message->file_id);
                foreach ($file_ids as $file) {
                    $file_name = File::find($file)->get('name');
                    array_push($file_names, $file_name);
                }
            }

            $message->file_names = implode(', ', $file_names);
        }

        return View::make('host.message-clients')->with(['page_title' => '全顧客への連絡', 'messages' => $messages]);
    }

    public function client_list()
    {
        $clients = Client::where('accounting_office_id', 1)->get();
        return View::make('host.client-list')->with(['page_title' => '顧客の一覧（閲覧）', 'clients' => $clients]);
    }

    public function account_management()
    {
        $this->set_globals();
        $staffs = AccountingOfficeStaff::where('accounting_office_id', $this->accounting_office->id)->get();
        return View::make('host.account-management')->with(['page_title' => '事務所内の管理', 'account' => $this->accounting_office, 'staffs' => $staffs]);
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


        DB::transaction(function () use ($request, $accounting_office_id, $result) {

            $user_id = User::insertGetId([
                'email' => $request->input('email'),
                'password' => Hash::make(Str::random(8)),
                'role_id' => 3 - $request->input('is_admin'),
                'is_online' => 0,
                'remember_token' => Str::random(60)
            ]);

            if ($user_id) {
                AccountingOfficeStaff::create([
                    'accounting_office_id' => $accounting_office_id,
                    'user_id' => $user_id,
                    'name' => $request->input('name'),
                    'is_admin' => $request->input('is_admin')
                ]);

                User::findorFail($user_id);
                //Send password reset

                $result = "success";
            } else {
                $result = "failure";
            }
        });

        return $result;
    }

    public function plan_update()
    {
        $this->set_globals();

        return View::make('host.blank-tempo')->with(['page_title' => 'プラン確認・変更']);
    }

    public function register_new_client(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'business_type_id' => 'required',
            'address' => 'required|max:255',
            'representative' => 'required',
            'representative_address' => 'required',
            'email' => 'required|email:rfc,dns',
            'tax_filing_month' => 'required',
            'manager_name' => 'required',
            'manager_email' => 'required|email:rfc,dns',
        ]);


        $host_id = Auth::user()->id;
        $accounting_office_id = AccountingOffice::where('user_id', $host_id)->first()->id;
        $token = Str::random(60);

        DB::transaction(function () use ($request, $accounting_office_id, $token){

            $hashids = new Hashids(config('hashids.login_salt'), 8);

            $client = Client::create([
                'accounting_office_id' => $accounting_office_id,
                'name' => $request->name,
                'business_type_id' => $request->business_type_id,
                'address' => $request->address,
                'representative' => $request->representative,
                'representative_address' => $request->representative_address,
                'contact_email' => $request->email,
                'tax_filing_month' => $request->tax_filing_month
            ]);

            if($client->id)
            {
                $manager_pw = Str::random(8);
                $manager_id = User::insertGetId([
                    'email' => $request->manager_email,
                    'password' => Hash::make($manager_pw),
                    'role_id' => 4,
                    'is_online' => 0,
                    'remember_token' => $token
                ]);

                if($manager_id)
                {
                    $manager_login_id = $hashids->encode($manager_id);
                    $manager = User::findOrFail($manager_id);
                    $manager->update([
                        'login_id' => $manager_login_id
                    ]);

                    ClientStaff::create([
                        'client_id' => $client->id,
                        'user_id' => $manager_id,
                        'name' => $request->manager_name,
                        'is_admin' => 1
                    ]);

                    $manager->save();
                    $manager->createToken();
                    $manager->sendPasswordNotification($token, $manager_pw, $manager_login_id);

                    if($request->user1_name != '' && $request->user1_email != '')
                    {
                        $user1_pw = Str::random(8);
                        $user1_id = User::insertGetId([
                            'email' => $request->user1_email,
                            'password' => Hash::make($user1_pw),
                            'role_id' => 5,
                            'is_online' => 0,
                            'remember_token' => $token
                        ]);

                        if($user1_id)
                        {
                            $user1_login_id = $hashids->encode($user1_id);
                            $user1 = User::findOrFail($user1_id);
                            $user1->update([
                                'login_id' => $user1_login_id
                            ]);

                            ClientStaff::create([
                                'client_id' => $client->id,
                                'user_id' => $user1_id,
                                'name' => $request->user1_name,
                                'is_admin' => 0
                            ]);

                            $user1->save();
                            $user1->createToken();
                            $user1->sendPasswordNotification($token, $user1_pw, $user1_login_id);
                        }

                    }

                    if($request->user2_name != '' && $request->user2_email != '')
                    {
                        $user2_pw = Str::random(8);
                        $user2_id = User::insertGetId([
                            'email' => $request->user2_email,
                            'password' => Hash::make($user2_pw),
                            'role_id' => 5,
                            'is_online' => 0,
                            'remember_token' => $token
                        ]);

                        if($user2_id)
                        {
                            $user2_login_id = $hashids->encode($user2_id);
                            $user2 = User::findOrFail($user2_id);
                            $user2->update([
                                'login_id' => $user2_login_id
                            ]);

                            ClientStaff::create([
                                'client_id' => $client->id,
                                'user_id' => $user2_id,
                                'name' => $request->user2_name,
                                'is_admin' => 0
                            ]);

                            $user1->save();
                            $user1->createToken();
                            $user1->sendPasswordNotification($token, $user1_pw, $user1_login_id);
                        }

                        return 'Client creation success.';
                    }
                }
                else {
                    return "Client creation successfull but failed to add new user.";
                }
            }
            else
            {
                return "Failed to create a new client";
            }
        });
    }

    public function view_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id)->first();
        $client_user_ids = [];
        $users = User::where('role_id', 4)->orWhere('role_id',5)->get();
        foreach ($users as $user)
        {
            if($user->clientStaff->client->id == $id){
                array_push($client_user_ids,$user->id);
            }
        }

        $messages = Message::where('targeted_at', '=', $id)->orWhere('is_global', '=', 1)->latest()->limit(5)->get();
        $uploads = ClientUpload::whereIn('user_id', $client_user_ids)->get();
        $downloads = HostUpload::where('client_id', '=', $id)->get();

        return View::make('host.individual-clients.dashboard', ['hashids'=> $this->hashids, 'client' => $client, 'messages' => $messages, 'uploads' => $uploads, 'downloads' => $downloads]);
    }

    public function contact_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id)->first();
        $messages = Message::where('targeted_at',$id)->get();

        return View::make('host.individual-clients.message-client', ['hashids'=> $this->hashids, 'client' => $client, 'messages' => $messages]);
    }

    public function message_client(Request $request)
    {
        DB::transaction(function () use($request){
            $inputSched = $request->input('scheduled_at');
            $scheduled_at = '';
            if($inputSched == null)
            {
                $scheduled_at = Carbon::now()->format('Y-m-d H:i:s');
            }
            else {
                $time = strtotime($request->input('scheduled_at'));
                $scheduled_at = date('Y-m-d H:i:s', $time);
            }
            
            if($request->file('attachment') != null) {
                $file = $request->file('attachment');
                $file_name = $file->getClientOriginalName();
                $file_path = $file->store('public/files/'.Auth::user()->accountingOfficeStaff->accountingOffice->name.'/'.Client::find($request->client_id)->name);
                $file_size = $file->getSize();

                $file_id = File::insertGetId([
                    'user_id' => Auth::user()->id,
                    'path' => $file_path,
                    'name' => $file_name,
                    'size' => $file_size,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                if($file_id) {
                    Message::create([
                        'user_id' => Auth::user()->id,
                        'is_global' => 0,
                        'targeted_at' => $request->input('client_id'),
                        'scheduled_at' => $scheduled_at,
                        'contents' => $request->input('content'),
                        'file_id' => $file_id
                    ]);
                }
            } 
            else {
                Message::create([
                    'user_id' => Auth::user()->id,
                    'is_global' => 0,
                    'targeted_at' => $request->input('client_id'),
                    'scheduled_at' => $scheduled_at,
                    'contents' => $request->input('content')
                ]);
            }

            
        });

        return redirect()->route('access-contact', ['client_id' => $this->hashids->encode($request->input('client_id'))]);
    }

    public function from_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id)->first();
        $client_user_ids = [];
        $users = User::where('role_id', 4)->orWhere('role_id',5)->get();
        foreach ($users as $user)
        {
            if($user->clientStaff->client->id == $id){
                array_push($client_user_ids,$user->id);
            }
        }
        $uploads = ClientUpload::whereIn('user_id', $client_user_ids)->get();

        return View::make('host.individual-clients.incoming')->with(['hashids'=> $this->hashids, 'client' => $client, 'uploads'=> $uploads]);
    }

    public function download_file(Request $request)
    {
        $file_db = File::find($request->file_id);

        $file = Storage::get($file_db->path);

        return (new Response($file, 200))->header('Content-Type', '.*');
    }

    public function to_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id)->first();
        $uploads = HostUpload::where('client_id', $id)->get();

        return View::make('host.individual-clients.outgoing')->with(['hashids'=> $this->hashids, 'client' => $client, 'uploads' => $uploads]);
    }

    public function file_tax(Request $request)
    {
        $id = $request->client_id;
        $request->validate(
            [
                'file' => 'required|mimes:doc,docx,pdf,csv'
            ]
        );

        DB::transaction(function () use ($request, $id) {

            $path = $request->file('file')->store('public/files/' . Auth::user()->accountingOffice->id);
            $name = $request->file('file')->getClientOriginalName();
            $size = $request->file('file')->getSize();

            $file_id = File::insertGetId([
                'user_id' => Auth::user()->id,
                'path' => $path,
                'name' => $name,
                'size' => $size
            ]);

            HostUpload::create([
                'user_id' => Auth::user()->id,
                'client_id' => $id,
                'file_id' => $file_id,
                'status' => 0,
                'priority' => $request->input('require_action'),
                'details' => $request->input('comment')
            ]);

            return redirect()->route('access-outbox', ['client_id' => $this->hashids->encode($id)]);
        });
    }

    public function financial_history_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id)->first();

        return View::make('host.individual-clients.financial-history', ['client' => $client, 'hashids' => $this->hashids]);
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

    public function save_video(Request $request)
    {
        $url = $request->file;
        if ($request->fileName) {
            $name = $request->fileName . '.mp4';
        } else {
            $name = time() . '.mp4';
        }
        DB::transaction(function () use ($name, $request, $url) {
            Storage::disk('google')->put($name,  file_get_contents($url->getRealPath()));
            $user_id = Auth::user()->id;
            $client = Client::where('user_id', $user_id)->first();
            $staff = ClientStaff::where('user_id', $user_id)->first();

            ClientUpload::create(
                [
                    'client_id' => 1,
                    'client_staff_id' => 1,
                    'file_name' => $request->file->getClientOriginalName(),
                    'file_path' => $name,
                    'file_size' => $request->file->getSize(),
                    'file_type' => 1,
                    'comment' => ''
                ]
            );
        });

        return response()->json($name);
    }

    function getVideo(Request $request) {
        $video_url = $request->video_url;
        $video = Storage::disk('google')->get($video_url);
        $response = Response::make($video, 200);
        $response->header('Content-Type', 'video/mp4');
        return $response;
    }



    public function pdf_source(Request $request)
    {
        $file =  $request->file('file');

        $path = $file->store('public/files/temp');
        $contents = Storage::url($path);

        return $contents;
    }

    public function send_notification(Request $request)
    {
        DB::transaction(function () use ($request) {

            $this->set_globals();
            $file_ids = array();

            if ($request->hasfile('files')) {
                foreach ($request->file('files') as $key => $file) {
                    $path = $file->store('public/files/uploaded/' . Auth::user()->id . '');
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
                'file_id' => implode(',', $file_ids)
            ]);

            Session::flash('success', 'Notification has been sent.');
            return redirect('message_clients');
        });
    }
}
