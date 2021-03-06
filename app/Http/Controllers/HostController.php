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
use App\Models\ClientUpload;
use App\Models\HostUpload;
use App\Models\TaxationHistory;
use App\Models\PastNotification;
use App\Models\CreatedVideoRecord;
use App\Models\ClientMajorNotification;
use App\Models\ClientObligation;
use Google\Cloud\Storage\StorageClient;

use Carbon\Carbon;
use Hashids\Hashids;
use ZipArchive;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use View;
use Session;
use DateTime;
use Mail;
use App\Mail\UploadNotification;


use App\Mail\ClientRegistrationMail;
use App\Mail\DeletedUserMail;
use App\Mail\HostUploadForApprovalMail;
use App\Mail\HostUploadNoApprovalMail;
use App\Mail\PasswordResetMail;
use App\Mail\InquiryMail;
use App\Mail\NewClientAccessMail;
use App\Mail\NewHostAccessMail;
use App\Mail\UpdatedLoginCredentialsEmail;
use App\Models\PermanentRecord;
use App\Models\TaxingCredentials;

class HostController extends Controller
{
    private $user;
    private $accounting_office;
    private $staff;
    private $subscription;
    private $clients;
    public const DOWNLOAD_CLOUD = 'https://storage.googleapis.com/download/storage/v1/b/upfiling_bukcet/o/';

    public function __construct()
    {
        $this->hashids = new Hashids('', 15);
        $this->hashfileids = new Hashids('Waiton Files', 10);
    }

    private function set_globals()
    {
        $this->user = Auth::user();
        $this->accounting_office = $this->user->accountingOfficeStaff->accountingOffice;
        $this->staff = AccountingOfficeStaff::firstWhere('user_id', $this->user->id);
        $this->subscription = null;
        $this->subscription_plan = null;
        $this->clients = Client::where('accounting_office_id', $this->user->accountingOfficeStaff->accounting_office_id)->orderBy('tax_filing_month', 'asc')->get();
    }

    public function index()
    {
        $this->set_globals();
        return View::make('host.dashboard')->with(['page_title' => '??????????????????', 'subscription' => $this->subscription, 'account' => $this->accounting_office, 'staff' => $this->staff]);
    }

    public function host_faq()
    {
        $this->set_globals();
        return View::make('host.faq')->with(['page_title' => 'FAQ']);
    }

    public function customer_selection()
    {
        $this->set_globals();
        return View::make('host.customer-selection')->with(['page_title' => '???????????????', 'clients' => $this->clients, 'hashids' => $this->hashids]);
    }

    public function accounting_profile()
    {
        \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        $account_office_id = Auth::user()->accountingOfficeStaff->accountingOffice->id;
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
        $users = User::whereIn('role_id', [2, 3])->get();
        foreach ($users as $user) {
            if ($user->accountingOfficeStaff->accountingOffice->id == Auth::user()->accountingOfficeStaff->accountingOffice->id) {
                array_push($user_ids, $user->id);
            }
        }


        $messages = null;
        if (Auth::user()->role_id == 2) {
            $messages = Message::whereIn('user_id', $user_ids)->latest()->get();
        } else {
            $messages = Message::where('user_id', $this->user->id)->latest()->get();
        }
        return View::make('host.message-clients')->with(['page_title' => '?????????????????????', 'messages' => $messages]);
    }

    public function download_client(Request $request)
    {
        $zip = new ZipArchive;
        $clients = Client::whereIn('id', $request->client_id)->get();
        $data = [];
        if (isset($clients)) {
            foreach ($clients as $client) {
                $client_name = $client ? str_replace(' ', '', $client->name) : '';
                $fileName = trim($client_name) . '.zip';
                $directory = public_path('storage/zip_files/upload/' . $fileName);
                $file_url = asset('storage/zip_files/upload/' . $fileName);
                if ($zip->open($directory, ZipArchive::CREATE) === TRUE) {
                    $files =  Storage::disk('gcs')->allFiles('client-uploads/' . $client->id);
                    foreach ($files as $file) {
                        $zip->addFromString($file, file_get_contents(Storage::disk('gcs')->url($file)));
                    }
                    $zip->close();
                }

                $data[] = array(
                    'file_url' => $file_url,
                    'file_name' => e($fileName)
                );
            }
        }
        return response()->json($data);
    }

    public function client_list()
    {
        $clients = Client::where('accounting_office_id', Auth::user()->accountingOfficeStaff->accounting_office_id)->latest()->get();
        return View::make('host.client-list')->with(['page_title' => '???????????????????????????', 'clients' => $clients]);
    }

    public function account_management()
    {
        $this->set_globals();
        $staffs = AccountingOfficeStaff::where('accounting_office_id', $this->accounting_office->id)->get();
        return View::make('host.account-management')->with(['page_title' => '?????????????????????', 'account' => $this->accounting_office, 'staffs' => $staffs]);
    }

    public function register_new_staff(Request $request)
    {
        $this->set_globals();
        $request->validate([
            'is_admin' => 'required',
            'name' => 'required',
            'email' => 'required|email:rfc,dns'
        ]);

        $accounting_office_id = Auth::user()->accountingOfficeStaff->accountingOffice->id;
        $result = '';

        DB::transaction(function () use ($request, $accounting_office_id, $result) {

            $password = Str::random(8);
            $user = User::create([
                'email' => $request->input('email'),
                'password' => Hash::make(Str::random(8)),
                'role_id' => 3 - $request->is_admin,
                'is_online' => 0,
                'remember_token' => Str::random(60)
            ]);


            if ($user) {
                $login_id = "A" . date('Y') . $user->role_id . $user->id . "";
                $user->update([
                    'login_id' => $login_id
                ]);
                $user->save();

                AccountingOfficeStaff::create([
                    'accounting_office_id' => $accounting_office_id,
                    'user_id' => $user->id,
                    'name' => $request->input('name'),
                    'is_admin' => $request->input('is_admin')
                ]);


                $accounting_office = AccountingOffice::findOrFail($accounting_office_id);
                $user = User::findorFail($user->id);
                Mail::to($user->email)->send(new NewHostAccessMail($user, $accounting_office->name, $password, $request->name));
                if (Mail::failures()) {
                    $result = "failure";
                }

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

        return View::make('host.blank-tempo')->with(['page_title' => '????????????????????????']);
    }

    //function for registering a new client.
    public function register_new_client(Request $request)
    {
        //check if all needed information are entered properly
        $request->validate([
            'name' => 'required',
            'business_type_id' => 'required',
            'address' => 'required|max:255',
            'representative' => 'required',
            'representative_address' => 'required',
            'email' => 'required|email:rfc,dns|unique:accounting_offices,contact_email',
            'tax_filing_month' => 'required',
            'manager_name' => 'required',
            'user1_email' => 'unique:users,email',
            'user2_email' => 'unique:users,email',
            'manager_email' => 'required',
        ]);

        //get init data
        $host_id = Auth::user()->id;
        $accounting_office_id = Auth::user()->accountingOfficeStaff->accountingOffice->id;
        $token = Str::random(60);

        //try for Database Insertion
        DB::transaction(function () use ($request, $accounting_office_id, $token) {

            $hashids = new Hashids(config('hashids.login_salt'), 8);

            $client = Client::create([
                'accounting_office_id' => $accounting_office_id,
                'name' => $request->name,
                'business_type_id' => $request->business_type_id,
                'address' => $request->address,
                'representative' => $request->representative,
                'representative_address' => $request->representative_address,
                'contact_email' => $request->email,
                'tax_filing_month' => $request->tax_filing_month,
            ]);

            if ($client->id) {
                $manager_pw = Str::random(8);
                $manager_id = User::insertGetId([
                    'email' => $request->manager_email,
                    'password' => Hash::make($manager_pw),
                    'role_id' => 4,
                    'is_online' => 0,
                    'remember_token' => $token,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                if ($manager_id) {
                    $manager = User::findOrFail($manager_id);
                    $manager_login_id = "C" . date('Y') . $manager->role_id . $manager->id . "";
                    $manager->update([
                        'login_id' => $manager_login_id
                    ]);

                    ClientStaff::create([
                        'client_id' => $client->id,
                        'user_id' => $manager_id,
                        'name' => $request->manager_name,
                        'is_admin' => 1
                    ]);

                    $this->sendClientRegistrationEmail($manager->remember_token, $manager, $manager_pw);


                }

                if ($request->user1_name && $request->user1_email) {
                    $user1_pw = Str::random(8);
                    $user1_id = User::insertGetId([
                        'email' => $request->user1_email,
                        'password' => Hash::make($user1_pw),
                        'role_id' => 5,
                        'is_online' => 0,
                        'remember_token' => $token,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    if ($user1_id) {
                        $user1 = User::findOrFail($user1_id);
                        $user1_login_id = "C" . date('Y') . $user1->role_id . $user1->id . "";
                        $user1->update([
                            'login_id' => $user1_login_id
                        ]);

                        ClientStaff::create([
                            'client_id' => $client->id,
                            'user_id' => $user1_id,
                            'name' => $request->user1_name,
                            'is_admin' => 0
                        ]);

                        $this->sendClientRegistrationEmail($user1->remember_token, $user1, $user1_pw);
                    }
                }

                if ($request->user2_name != '' && $request->user2_email != '') {
                    $user2_pw = Str::random(8);
                    $user2_id = User::insertGetId([
                        'email' => $request->user2_email,
                        'password' => Hash::make($user2_pw),
                        'role_id' => 5,
                        'is_online' => 0,
                        'remember_token' => $token,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    if ($user2_id) {
                        $user2 = User::findOrFail($user2_id);
                        $user2_login_id = "C" . date('Y') . $user2->role_id . $user2->id . "";
                        $user2->update([
                            'login_id' => $user2_login_id
                        ]);

                        ClientStaff::create([
                            'client_id' => $client->id,
                            'user_id' => $user2_id,
                            'name' => $request->user2_name,
                            'is_admin' => 0
                        ]);

                        $this->sendClientRegistrationEmail($user2->remember_token, $user2, $user2_pw);
                    }

                    return 'Client creation success.';
                }
            } else {
                return "Failed to create a new client";
            }
        });
    }

    public function sendClientRegistrationEmail($token, $user, $password)
    {
        Mail::to($user->email)->send(new ClientRegistrationMail($token, $user, $password, Auth::user()->accountingOfficeStaff->accountingOffice));

        if (Mail::failures()) {
            abort(403);
        }

        return 'SUCCESS';
    }

    public function view_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();


        $date = date('Y-m-d');

        $messages = Message::where(function ($dateQuery) use ($date) {
            $dateQuery->where(function ($dateSubQuery) use ($date) {
                $dateSubQuery->where('created_at', 'like', '' . $date . '%')
                    ->where('scheduled_at', null);
            })->orWhere('scheduled_at', 'like', '' . $date . '%');
        })->where(function ($targetQuery) use ($client) {
            $targetQuery->where('is_global', 1)->orWhere('targeted_at', $client->id);
        })->latest()->get();
        $uploads = ClientUpload::whereIn('user_id', $client_user_ids)->latest()->get();
        $downloads = HostUpload::where('client_id', '=', $id)->latest()->get();

        return View::make('host.individual-clients.dashboard', ['hashids' => $this->hashids, 'client' => $client, 'messages' => $messages, 'uploads' => $uploads, 'downloads' => $downloads, 'unviewed' => $unviewed]);
    }

    public function contact_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $messages = Message::where('targeted_at', $id)->latest()->get();
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        return View::make('host.individual-clients.message-client', ['hashids' => $this->hashids, 'client' => $client, 'messages' => $messages, 'unviewed' => $unviewed]);
    }

    public function message_client(Request $request)
    {
        DB::transaction(function () use ($request) {
            $inputSched = $request->input('scheduled_at');
            $scheduled_at = '';
            if ($inputSched == null) {
                $scheduled_at = Carbon::now()->format('Y-m-d H:i:s');
            } else {
                $time = strtotime($request->input('scheduled_at'));
                $scheduled_at = date('Y-m-d H:i:s', $time);
            }

            if ($request->file('attachment') != null) {
                $file = $request->file('attachment');
                $file_name = $file->getClientOriginalName();

                $file_path = "accounting-office-message-attachments/" . Auth::user()->accountingOfficeStaff->accountingOffice->id . '/' . $request->client_id . str_replace(' ', '%20', $file_name);
                Storage::disk('gcs')->put($file_path, file_get_contents($file));
                $file_size = $file->getSize();

                $file_id = Files::insertGetId([
                    'user_id' => Auth::user()->id,
                    'path' => $file_path,
                    'name' => $file_name,
                    'size' => $file_size,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                if ($file_id) {
                    Message::create([
                        'user_id' => Auth::user()->id,
                        'is_global' => 0,
                        'targeted_at' => $request->input('client_id'),
                        'scheduled_at' => $scheduled_at,
                        'contents' => $request->input('content'),
                        'file_id' => $file_id
                    ]);
                }
            } else {
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
        $client = Client::find($id);
        $client_user_ids = [];
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }
        $uploads = ClientUpload::whereIn('user_id', $client_user_ids)->latest()->get();

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        return View::make('host.individual-clients.incoming')->with(['hashids' => $this->hashids, 'client' => $client, 'uploads' => $uploads, 'unviewed' => $unviewed]);
    }

    public function download_file(Request $request)
    {
        $data = array();
        $client_upload = ClientUpload::whereIn('id', $request->file_id)->get();

        foreach ($client_upload as $file) {
            $file->update([
                'is_viewed' => 1
            ]);
            $file_db = Files::findOrFail($file->file_id);
            $file_url = urlencode($file_db->path);
            $name = $file_db->name;
            array_push($data, array(
                'file_url' => $file_url,
                'file_name' => e($name)
            ));
        }
        return response()->json($data);
    }


    public function to_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $uploads = HostUpload::where('client_id', $id)->latest()->get();
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        return View::make('host.individual-clients.outgoing')->with(['hashids' => $this->hashids, 'client' => $client, 'uploads' => $uploads, 'unviewed' => $unviewed]);
    }

    public function file_tax(Request $request)
    {
        $id = $request->client_id;
        $request->validate(
            [
                'file' => 'required',
                'comment' => 'required',
                'require_action' => 'required'
            ]
        );

        DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');
            $size = $files->getSize();
            $name = $files->getClientOriginalName();
            $path = "host-uploads/" . Auth::user()->accountingOfficeStaff->accountingOffice->id . "/" . str_replace(' ', '%20', $name);
            Storage::disk('gcs')->put($path, file_get_contents($files));

            $file_id = Files::insertGetId([
                'user_id' => Auth::user()->id,
                'path' => $path,
                'name' => $name,
                'size' => $size,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            HostUpload::create([
                'user_id' => Auth::user()->id,
                'client_id' => $id,
                'file_id' => $file_id,
                'status' => 0,
                'priority' => $request->input('require_action'),
                'details' => $request->input('comment'),
                'video_url' => $request->input('vid_url')
            ]);

            $client = Client::findorFail($id);
            $office = AccountingOffice::findorFail(Auth::user()->accountingOfficeStaff->accountingOffice->id);

            $this->sendUploadNotification($client->contact_email, $client, $office, $request->input('require_action'));
            $this->sendUploadNotification($office->contact_email, $client, $office, $request->input('require_action'));
        });

        return redirect()->route('access-outbox', ['client_id' => $this->hashids->encode($id)]);
    }

    public function sendUploadNotification($target, $client, $host, $for_approval)
    {
        if ($for_approval == 0) {
            Mail::to($target)->send(new HostUploadNoApprovalMail($client, $host));

            if (Mail::failures()) {
                return false;
            }

            return false;
        } else {
            Mail::to($target)->send(new HostUploadForApprovalMail($client, $host));

            if (Mail::failures()) {
                return false;
            }

            return true;
        }
    }

    public function financial_history_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);

        $taxation_archive = TaxationHistory::where('client_id', $client->id)->latest()->get();
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }
        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        return View::make('host.individual-clients.financial-history', ['client' => $client, 'hashids' => $this->hashids, 'archives' => $taxation_archive, 'unviewed' => $unviewed]);
    }

    public function create_video_client(Request $request)
    {
        $client_id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($client_id);
        $staff = Auth::user()->accountingOfficeStaff;
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $user->id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        if ($request->record_id) {
            $record = TaxationHistory::find($this->hashids->decodeHex($request->record_id)[0]);
        } else {
            $record = null;
        }
        return View::make('host.individual-clients.past-settlement')->with(['client' => $client, 'hashids' => $this->hashids, 'record' => $record, 'unviewed' => $unviewed]);
    }

    public function video_creation(Request $request)
    {
        $client_id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($client_id);
        $staff = Auth::user()->accountingOfficeStaff;
        if ($request->record_id == 0) {
            $record = null;
        } else {
            $record = TaxationHistory::find($request->record_id);
        }

        return View::make('host.individual-clients.video-creation')->with(['client' => $client, 'hashids' => $this->hashids, 'record' => $record]);
    }

    public function save_video(Request $request)
    {
        $url = $request->file;
        $date_now = Carbon::now();

        if ($request->fileName) {
            $name = "{$date_now}_{$request->fileName}.mp4";
        } else {
            $name = $date_now . '.mp4';
        }

        $user_id = Auth::user()->id;
        $staff = ClientStaff::where('user_id', $user_id)->first();
        $path = "host-uploads/" . Auth::user()->accountingOfficeStaff->accountingOffice->id . "/" . str_replace(' ', '_', $name);
        Storage::disk('gcs')->put($path,  file_get_contents($url->getRealPath()));

        $url = Storage::disk('gcs')->url($path);

        return response()->json($url);
    }

    public function save_settings(Request $request)
    {
        $datas = $request->data;
        $object_data = [];
        foreach ($datas as $data) {
            $object_data[$data['name']] = $data['value'];
        }
    }

    function getVideo(Request $request)
    {
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

    public function view_video_list(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $videos = CreatedVideoRecord::where('client_id', $client->id)->latest()->get();
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();
        return View::make('host.individual-clients.video-list', ['client' => $client, 'hashids' => $this->hashids, 'videos' => $videos, 'unviewed' => $unviewed]);
    }

    public function access_files_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        return View::make('host.individual-clients.access-historical-file', ['client' => $client, 'hashids' => $this->hashids, 'unviewed' => $unviewed]);
    }

    public function notification_history_client(Request $request)
    {
        $page_title = "??????";
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $notification_archives = PastNotification::where(['client_id' => $id])->latest()->get();
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        return View::make('host.individual-clients.notification-history')->with(['page_title', $page_title, 'hashids' => $this->hashids, 'client' => $client, 'archives' => $notification_archives, 'unviewed' => $unviewed]);
    }

    public function view_registration_information(Request $request)
    {
        $page_title = '????????????';
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $months = Client::MONTHS;
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        return View::make('host.individual-clients.view-registration-info')->with(['months' => $months, 'page_title' => $page_title, 'client' => $client, 'hashids' => $this->hashids, 'unviewed' => $unviewed]);
    }

    public function save_notification_archive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('access-notification-history', ['client_id' => $request->client_id])
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function () use ($request) {
            $file = $request->file('file');

            $name = $file->getClientOriginalName();
            $path = 'notification-archive/' . Auth::user()->accountingOfficeStaff->accountingOffice->id . '/' . $request->client_id . str_replace(' ', '%20', $name);
            Storage::disk('gcs')->put($path, file_get_contents($file));

            $file_id = Files::insertGetId([
                'user_id' => Auth::user()->id,
                'path' => $path,
                'name' => $name,
                'size' => $request->file('file')->getSize(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            if ($file_id) {
                PastNotification::create([
                    'user_id' => Auth::user()->id,
                    'client_id' => $request->client_id,
                    'notification_type' => $request->notification_type,
                    'file_id' => $file_id
                ]);
            }
        });

        return redirect()->route('access-notification-history', ['client_id' => $this->hashids->encode($request->client_id)]);
    }


    public function send_notification(Request $request)
    {
        DB::transaction(function () use ($request) {

            $this->set_globals();

            if ($request->hasfile('files')) {
                $file = $request->file('files');
                $file_name = $file->getClientOriginalName();

                $file_path = "accounting-office-message-attachments/" . Auth::user()->accountingOfficeStaff->accountingOffice->id . '/' . $request->client_id . str_replace(' ', '%20', $file_name);
                Storage::disk('gcs')->put($file_path, file_get_contents($file));
                $file_size = $file->getSize();

                $file_id = Files::insertGetId([
                    'user_id' => Auth::user()->id,
                    'path' => $file_path,
                    'name' => $file_name,
                    'size' => $file_size,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                Message::create([
                    'user_id' => Auth::user()->id,
                    'is_global' => $request->input('is_global'),
                    'targeted_at' => $request->input('targeted_at'),
                    'scheduled_at' => $request->input('scheduled_at'),
                    'contents' => $request->input('contents'),
                    'file_id' => $file_id
                ]);
            } else {
                Message::create([
                    'user_id' => Auth::user()->id,
                    'is_global' => $request->input('is_global'),
                    'targeted_at' => $request->input('targeted_at'),
                    'scheduled_at' => $request->input('scheduled_at'),
                    'contents' => $request->input('contents')
                ]);
            }
        });

        Session::flash('success', 'Notification has been sent.');
        return redirect()->route('outbox');
    }

    public function send_inquiry(Request $request)
    {
        $user = Auth::user();
        $staff = $user->accountingOfficeStaff;
        $client = $staff->accountingOffice;

        Mail::to('ichikawa@upfiling.jp')->send(new InquiryMail($user, $staff, $ao, $request->content));

        if (Mail::failures()) {
            return 'failure';
        } else {
            return 'success';
        }
    }

    public function save_taxation_archive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'settlement_date' => 'required',
            'file' => 'required',
            'kinds' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('create-video', ['client_id' => $request->client_id])
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->input('record_id')) {
            $record = TaxationHistory::find($request->record_id);

            $record->update([
                // TODO: update only Comment
                // 'settlement_date' => $request->settlement_date,
                // 'recognition_date' => $request->recognition_date,
                // 'proposal_date' => $request->proposal_date,
                // 'company_representative' => $request->company_representative,
                // 'accounting_office_staff' => $request->accounting_office_staff,
                // 'video_contributor' => $request->video_contributor,
                'comment' => $request->comment,
                // 'kinds' => $request->kinds,
                // 'video_url' => $request->video_url
            ]);

            $record->save();
        } else {
            DB::transaction(function () use ($request) {
                $client_id = $this->hashids->decode($request->client_id)[0];

                $file = $request->file('file');
                $file_name = $file->getClientOriginalName();

                $file_path = "host-uploads/" . Auth::user()->accountingOfficeStaff->accountingOffice->id . '/' . str_replace(' ', '%20', $file_name);
                Storage::disk('gcs')->put($file_path, file_get_contents($file));

                //save file first
                $file_id = Files::insertGetId([
                    'user_id' => Auth::user()->id,
                    'path' => $file_path,
                    'name' => $request->file('file')->getClientOriginalName(),
                    'size' => $request->file('file')->getSize(),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                if ($file_id) {
                    TaxationHistory::create([
                        'user_id' => Auth::user()->id,
                        'client_id' => $client_id,
                        'settlement_date' => $request->settlement_date,
                        'file_id' => $file_id,
                        'comment' => $request->comment,
                        'kinds' => $request->kinds,
                        'video_url' => $request->video_url
                    ]);
                }
            });
        }


        return redirect()->route('access-taxation-history', ['client_id' => $request->client_id]);
    }


    public function access_data_financial_record(Request $request)
    {
        $client_id = $this->hashids->decode($request->client_id)[0];
        $record_id = $request->record_id;
        $record = TaxationHistory::find($record_id);
        $client = Client::find($client_id);

        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client_id = $client->id) {
                array_push($client_user_ids, $user->id);
            }
        }


        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        return View::make('host.individual-clients.past-settlement')->with(['client' => $client, 'record' => $record, 'hashids' => $this->hashids, 'unviewed' => $unviewed]);
    }

    public function save_url_to_database(Request $request)
    {
        $date_now = Carbon::now();

        if ($request->name) {
            $name = "{$date_now}_{$request->name}.mp4";
        } else {
            $name = $date_now . '.mp4';
        }

        CreatedVideoRecord::create([
            'user_id' => Auth::user()->id,
            'client_id' => $request->client,
            'video_url' => $request->video_url,
            'name' => $name
        ]);
        return url(route('video-list', ['client_id' => $this->hashids->encode($request->client)]));
    }
    public function delete_file_from(Request $request)
    {
        $datas = [];
        $datas = $request->data;
        foreach ($datas as $data) {
            HostUpload::find($data)->delete();
        }
        return response()->json($datas);
    }

    public function delete_saved_video(Request $request)
    {
        $id = $request->id;
        CreatedVideoRecord::findOrFail($id)->delete();
    }

    public function update_registration_info(Request $request)
    {

        DB::transaction(function () use ($request) {
            $accounting_office = AccountingOffice::find(Auth::user()->accountingOfficeStaff->accountingOffice->id);
            $accounting_office->update([
                'name' => $request->name,
                'representative' => $request->representative,
                'address' => $request->address,
                'telephone' => $request->telephone
            ]);
            $accounting_office->save();
        });

        return $this->account_management();
    }

    public function get_user(Request $request)
    {
        $user_id = $request->id;

        $staff = AccountingOfficeStaff::where('user_id', $user_id)->first();
        $user = User::find($user_id);

        $data = array(
            'name' => $staff->name,
            'email' => $user->email,
            'token' => $user->remember_token,
            'login_id' => $user->login_id,
            'id' => $user->id
        );
        return $data;
    }

    public function get_client_staff(Request $request)
    {
        $staff_id = $request->id;
        $staff = ClientStaff::findOrFail($staff_id);
        $user = User::findOrFail($staff->user_id);
        $data = array(
            'name' => $staff->name,
            'email' => $user->email,
            'token' => $user->remember_token,
            'login_id' => $user->login_id,
            'id' => $user->id
        );

        return $data;
    }

    public function update_staff(Request $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::find($request->userID);
            $staff = AccountingOfficeStaff::where('user_id', $user->id)->first();
            if ($request->userPassword != '') {
                $user->update([
                    'email' => $request->userEmail,
                    'password' => Hash::make($request->userPassword)
                ]);
            } else {
                $user->update([
                    'email' => $request->userEmail
                ]);
            }


            $user->save();

            $staff->update([
                'name' => $request->userName,
            ]);

            $staff->save();
        });



        return redirect()->route('account');
    }

    public function update_client_staff(Request $request)
    {
        $client_id = $request->clientID;
        DB::transaction(function () use ($request) {
            $user = User::find($request->userID);
            $staff = ClientStaff::where('user_id', $user->id)->first();
            $client = $staff->client;

            $user->update([
                'email' => $request->userEmail,
            ]);

            $user->save();

            $staff->update([
                'name' => $request->userName,
            ]);

            $staff->save();

            Mail::to($user->clientStaff->client->contact_email)->send(new UpdatedLoginCredentialsEmail($user->login_id, $request->userName, $request->userEmail));

            if (Mail::failures()) {
                abort(403);
            }
        });

        return redirect()->route('view-registration-information', ['client_id' => $this->hashids->encode($client_id)]);
    }

    //client info update

    public function update_client_info(Request $request)
    {
        $client = Client::findorFail($request->id);

        if ($client) {
            $client->update([
                'name' => $request->name,
                'address' => $request->address,
                'business_type_id' => $request->business_type_id,
                'representative' => $request->representative,
                'representative_address' => $request->representative_address,
                'tax_filing_month' => (int) $request->tax_filing_month
            ]);

            $client->save();

            return redirect()->route('view-registration-information', ['client_id' => $this->hashids->encode($request->id)]);
        }

        abort(403);
    }

    public function update_client_obligation(Request $request)
    {
        $client_id = $request->id;

        $obligation = ClientObligation::where('client_id', $client_id)->first();

        if ($obligation) {
            $obligation->update([
                'client_id' => $request->id,
                'is_taxable' => $request->is_taxable,
                'calculation_method' => $request->calculation_method,
                'taxable_type' => $request->taxable_type
            ]);

            $obligation->save();
        } else {
            ClientObligation::create([
                'client_id' => $request->id,
                'is_taxable' => $request->is_taxable,
                'calculation_method' => $request->calculation_method,
                'taxable_type' => $request->taxable_type
            ]);
        }

        return redirect()->route('view-registration-information', ['client_id' => $this->hashids->encode($request->id)]);
    }
    public function update_notification_settings(Request $request)
    {
        $client_id = $request->client_id;

        $notifs = ClientMajorNotification::where('client_id', $client_id)->first();


        if ($notifs) {
            $notifs->update([
                'establishment_notification' => $request->establishment_notification,
                'blue_declaration' => $request->blue_declaration,
                'withholding_tax' => $request->withholding_tax,
                'salary_payment' => $request->salary_payment,
                'extension_filing_deadline' => $request->extension_filing_deadline,
                'consumption_tax' => $request->consumption_tax,
                'consumption_tax_excemption' => $request->consumption_tax_excemption,
                'consumption_tax_selection' => $request->consumption_tax_selection,
                'simple_taxation' => $request->simple_taxation,
            ]);

            $notifs->save();
        } else {
            ClientMajorNotification::create([
                'client_id' => $client_id,
                'establishment_notification' => $request->establishment_notification,
                'blue_declaration' => $request->blue_declaration,
                'withholding_tax' => $request->holding_tax,
                'salary_payment' => $request->salary_payment,
                'extension_filing_deadline' => $request->extension_filing_deadline,
                'consumption_tax' => $request->consumption_tax,
                'consumption_tax_excemption' => $request->consumption_tax_excemption,
                'consumption_tax_selection' => $request->consumption_tax_selection,
                'simple_taxation' => $request->simple_taxation,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        return redirect()->route('access-notification-history', ['client_id' => $this->hashids->encode($request->client_id)]);
    }

    public function update_client_credentials(Request $request)
    {
        $client = Client::findorFail($request->id);
        if ($client) {
            $taxing_credentials = TaxingCredentials::where('client_id', $request->id)->first();

            if ($taxing_credentials) {
                $taxing_credentials->update([
                    'nta_id' => $request->nta_num,
                    'nta_password' => $request->nta_password,
                    'el_tax_id' => $request->el_tax_num,
                    'el_tax_password' => $request->el_tax_password
                ]);

                $taxing_credentials->save();
            } else {
                TaxingCredentials::create(
                    [
                        'client_id' => $request->id,
                        'nta_id' => $request->nta_num,
                        'nta_password' => $request->nta_password,
                        'el_tax_id' => $request->el_tax_num,
                        'el_tax_password' => $request->el_tax_password
                    ]
                );
            }
            return redirect()->route('view-registration-information', ['client_id' => $this->hashids->encode($request->id)]);
        }

        abort(403);
    }

    public function mark_as_read(Request $request)
    {
        $record = ClientUpload::find($request->record_id);

        $file = SELF::DOWNLOAD_CLOUD . urlencode($record->file->path) . '?alt=media';

        $record->update([
            'is_viewed' => 1
        ]);
        $record->save();

        $name = $record->file->name;

        return array(url($file), $name);
    }

    public function register_new_client_access(Request $request)
    {
        $page_title = '????????????';
        $id = $request->client_id;
        $client = Client::find($id);
        $months = Client::MONTHS;
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();

        $validator = Validator::make($request->all(), [
            'is_admin' => 'required',
            'staff_name' => 'required',
            'staff_email' => 'required|unique:users,email|email:rfc,dns'
        ]);

        if ($validator->fails()) {
            return redirect()->route('view-registration-information', ['client_id' => $this->hashids->encode($request->client_id)])
                ->withErrors($validator)
                ->withInput();
        } else {
            DB::transaction(function () use ($request) {
                $role = 5 - $request->is_admin;
                $pw = Str::random(8);
                $user = User::create([
                    'email' => $request->staff_email,
                    'password' => Hash::make($pw),
                    'role_id' => $role,
                    'remember_token' => Str::random(60)
                ]);

                $login_id = "C" . date('Y') . $role . $user->id . "";
                $user->update(['login_id' => $login_id]);
                $user->save();

                if ($user) {
                    ClientStaff::create([
                        'client_id' => $request->client_id,
                        'user_id' => $user->id,
                        'name' => $request->staff_name,
                        'is_admin' => $request->is_admin
                    ]);
                }

                $this->sendClientRegistrationEmail($user->remember_token, $user, $pw);
            });
            return back()->with('success', 'User successfully created.');
        }
    }

    public function change_contact_email(Request $request)
    {
        $client = Client::findOrFail($request->client_id);

        if ($client) {
            $client->update([
                'contact_email' => $request->contact_email
            ]);

            $client->save();
        }

        return redirect()->route('view-registration-information', ['client_id' => $this->hashids->encode($request->client_id)]);
    }

    public function delete_user(Request $request)
    {
        $id = $request->user_id;

        DB::transaction(function () use ($id) {

            $staff = ClientStaff::findOrFail($id);
            $client_email = $staff->client->contact_email;


            $user_id = $staff->user_id;

            $user = User::findOrFail($user_id);
            $login_id = $user->login_id;

            $staff->delete();
            $user->delete();


            Mail::to($client_email)->send(new DeletedUserMail($login_id));
            if (Mail::failures()) {
                abort(403);
            }
        });

        return "Deleted!";
    }

    function delete_archives(Request $request)
    {
        DB::transaction(function () use ($request) {
            PastNotification::whereIn('id', $request->ids)->delete();
        });

        return $request->all();
    }

    function delete_staff(Request $request)
    {
        $staff_id = $request->id;

        DB::transaction(function () use ($staff_id) {
            $staff = AccountingOfficeStaff::findOrFail($staff_id);
            $user = User::findOrFail($staff->user_id);
            $accountingOffice = AccountingOffice::findOrFail($staff->accounting_office_id);
            $login_id = $user->login_id;


            $staff->delete();
            $user->delete();

            Mail::to($accountingOffice->contact_email)->send(new DeletedUserMail($login_id));

            if (Mail::failures()) {
                abort(403);
            }
        });

        return true;
    }

    public function update_otp_email(Request $request)
    {
        $accountingOffice = AccountingOffice::findOrFail($request->accountingOfficeID);

        $accountingOffice->update([
            'contact_email' => $request->contact_email,
        ]);

        $accountingOffice->save();

        return $this->account_management();
    }

    function access_material_storage(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::findOrFail($id);
        $client_user_ids = array();
        $users = User::where('role_id', 4)->orWhere('role_id', 5)->get();
        foreach ($users as $user) {
            if ($user->clientStaff->client->id == $id) {
                array_push($client_user_ids, $user->id);
            }
        }

        $unviewed = ClientUpload::where('is_viewed', 0)->whereIn('user_id', $client_user_ids)->count();
        $stored_materials = PermanentRecord::where('client_id', $id)->latest()->get();

        return View::make('host.individual-clients.stored-materials', ['hashids' => $this->hashids, 'client' => $client, 'unviewed' => $unviewed, 'materials' => $stored_materials]);
    }

    function downloadDocumentFiles(Request $request)
    {
        $files = Files::findOrFail($request->file_id);

        $file = SELF::DOWNLOAD_CLOUD . urlencode($files->path) . '?alt=media';

        $name = e($files->name);

        return array(url($file), $name);
    }
}
