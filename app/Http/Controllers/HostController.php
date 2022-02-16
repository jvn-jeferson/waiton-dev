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
use App\Mail\PasswordResetMail;
use App\Mail\InquiryMail;
use App\Models\TaxingCredentials;

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
        $users = User::whereIn('role_id', [2, 3])->get();
        foreach ($users as $user) {
            if ($user->accountingOfficeStaff->accountingOffice->id == Auth::user()->accountingOfficeStaff->accountingOffice->id) {
                array_push($user_ids, $user->id);
            }
        }


        $messages = null;
        if (Auth::user()->role_id == 2) {
            $messages = Message::whereIn('user_id', $user_ids)->get();
        } else {
            $messages = Message::where('user_id', $this->user->id)->get();
        }
        foreach ($messages as $message) {
            $file_names = '';
            if ($message->file_id) {
                $files = explode(',', $message->file_id);
                foreach ($files as $file) {
                    $file_names .= Files::find($file)->name . " • ";
                }
            }

            $message->file_id = $file_names;
        }
        return View::make('host.message-clients')->with(['page_title' => '全顧客への連絡', 'messages' => $messages]);
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
                    $files =  Storage::disk('public')->files('files/upload/' . $client->id);
                    foreach ($files as $file) {
                        $relativeNameInZipFile = explode('/', $file)[3];
                        $zip->addFile(Storage::path('public/' . $file), $relativeNameInZipFile);
                    }
                    $zip->close();
                }
                $data[] = array(
                    'file_url' => $file_url,
                    'file_name' => $fileName
                );
            }
        }
        return response()->json($data);
    }

    public function client_list()
    {
        $clients = Client::where('accounting_office_id', Auth::user()->accountingOfficeStaff->accounting_office_id)->get();
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

                $user = User::findorFail($user_id);
                Mail::to($user->email)->send(new PasswordResetMail($user));
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
            'email' => 'required|email:rfc,dns|unique:accounting_offices,contact_email',
            'tax_filing_month' => 'required',
            'manager_name' => 'required',
            'user1_email' => 'unique:users,email',
            'user2_email' => 'unique:users,email',
            'manager_email' => 'required',
        ]);

        $host_id = Auth::user()->id;
        $accounting_office_id = AccountingOffice::where('user_id', $host_id)->first()->id;
        $token = Str::random(60);

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

                    if ($request->user1_name != '' && $request->user1_email != '') {
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
                    return "Client creation successfull but failed to add new user.";
                }
            } else {
                return "Failed to create a new client";
            }
        });
    }

    public function sendClientRegistrationEmail($token, $user, $password)
    {
        Mail::to($user->email)->send(new ClientRegistrationMail($token, $user, $password));

        if (Mail::failures()) {
            abort(403);
        }

        return 'SUCCESS';
    }

    public function view_client(Request $request)
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

        $messages = Message::where('targeted_at', '=', $id)->orWhere('is_global', '=', 1)->latest()->limit(5)->get();
        $uploads = ClientUpload::whereIn('user_id', $client_user_ids)->get();
        $downloads = HostUpload::where('client_id', '=', $id)->get();

        return View::make('host.individual-clients.dashboard', ['hashids' => $this->hashids, 'client' => $client, 'messages' => $messages, 'uploads' => $uploads, 'downloads' => $downloads]);
    }

    public function contact_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $messages = Message::where('targeted_at', $id)->get();

        return View::make('host.individual-clients.message-client', ['hashids' => $this->hashids, 'client' => $client, 'messages' => $messages]);
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
                $file_path = $file->store('public/files/' . Auth::user()->accountingOfficeStaff->accountingOffice->name . '/' . Client::find($request->client_id)->name);
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
        $uploads = ClientUpload::whereIn('user_id', $client_user_ids)->get();

        return View::make('host.individual-clients.incoming')->with(['hashids' => $this->hashids, 'client' => $client, 'uploads' => $uploads]);
    }

    public function download_file(Request $request)
    {
        $file_db = Files::find($request->file_id);

        $file = Storage::url($file_db->path);
        $name = $file_db->name;
        return array(url($file), $name);
    }

    public function to_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $uploads = HostUpload::where('client_id', $id)->get();

        return View::make('host.individual-clients.outgoing')->with(['hashids' => $this->hashids, 'client' => $client, 'uploads' => $uploads]);
    }

    public function file_tax(Request $request)
    {
        $id = $request->client_id;
        $request->validate(
            [
                'file' => 'required|mimes:doc,docx,pdf,csv',
                'comment' => 'required',
                'require_action' => 'required'
            ]
        );

        DB::transaction(function () use ($request, $id) {

            $files = $request->file('file');
            $size = $files->getSize();
            $name = $files->getClientOriginalName();
            $path = Storage::disk('gcs')->put(Auth::user()->accountingOffice->id . "/" . $name, file_get_contents($files));

            $file_id = Files::insertGetId([
                'user_id' => Auth::user()->id,
                'path' => Auth::user()->accountingOfficeStaff->accountingOffice->id . "/" . $name,
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

            $client = Client::find($id);
            $office = AccountingOffice::find(Auth::user()->accountingOfficeStaff->accountingOffice->id);

            $this->sendUploadNotification($client->contact_email, $office->name, "Successfully uploaded file");
            $this->sendUploadNotification($office->contact_email, $office->name, "One of your clients has uploaded a file. It is ready for download on your dashboard.");
        });

        return redirect()->route('access-outbox', ['client_id' => $this->hashids->encode($id)]);
    }

    public function sendUploadNotification($email, $target, $message)
    {
        Mail::to($email)->send(new UploadNotification($target, $message));

        if(Mail::failures())
        {
            return false;
        }

        return true;
    }

    public function financial_history_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $taxation_archive = TaxationHistory::where('client_id', $client->id)->get();

        return View::make('host.individual-clients.financial-history', ['client' => $client, 'hashids' => $this->hashids, 'archives' => $taxation_archive]);
    }

    public function create_video_client(Request $request)
    {
        $client_id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($client_id);
        $staff = Auth::user()->accountingOfficeStaff;

        if ($request->record_id) {
            $record = TaxationHistory::find($this->hashids->decodeHex($request->record_id)[0]);
        } else {
            $record = null;
        }
        return View::make('host.individual-clients.past-settlement')->with(['client' => $client, 'hashids' => $this->hashids, 'record' => $record]);
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
        if ($request->fileName) {
            $name = $request->fileName . '.mp4';
        } else {
            $name = time() . '.mp4';
        }
        Storage::disk('gcs')->put($name,  file_get_contents($url->getRealPath()));
        $url = Storage::disk('gcs')->url($name);
        $user_id = Auth::user()->id;
        $staff = ClientStaff::where('user_id', $user_id)->first();

        Files::create(
            [
                'user_id' => $user_id,
                'path' => $url,
                'name' => $request->file->getClientOriginalName(),
                'size' => $request->file->getSize(),
            ]
        );

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
        $videos = CreatedVideoRecord::where('client_id', $client->id)->get();

        return View::make('host.individual-clients.video-list', ['client' => $client, 'hashids' => $this->hashids, 'videos' => $videos]);
    }

    public function access_files_client(Request $request)
    {
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);

        return View::make('host.individual-clients.access-historical-file', ['client' => $client, 'hashids' => $this->hashids]);
    }

    public function notification_history_client(Request $request)
    {
        $page_title = "届出";
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $notification_archives = PastNotification::where(['client_id' => $id])->get();
        return View::make('host.individual-clients.notification-history')->with(['page_title', $page_title, 'hashids' => $this->hashids, 'client' => $client, 'archives' => $notification_archives]);
    }

    public function view_registration_information(Request $request)
    {
        $page_title = '各種設定';
        $id = $this->hashids->decode($request->client_id)[0];
        $client = Client::find($id);
        $months = Client::MONTHS;
        return View::make('host.individual-clients.view-registration-info')->with(['months' => $months, 'page_title' => $page_title, 'client' => $client, 'hashids' => $this->hashids]);
    }

    public function save_notification_archive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proposal_date' => 'required',
            'recognition_date' => 'required',
            'file' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('access-notification-history', ['client_id' => $request->client_id])
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function () use ($request) {
            $file_id = Files::insertGetId([
                'user_id' => Auth::user()->id,
                'path' => $request->file('file')->store('public/files/' . Auth::user()->accountingOfficeStaff->accountingOffice->name . '/' . Client::find($request->client_id)->name),
                'name' => $request->file('file')->getClientOriginalName(),
                'size' => $request->file('file')->getSize(),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            if ($file_id) {
                PastNotification::create([
                    'user_id' => Auth::user()->id,
                    'client_id' => $request->client_id,
                    'proposal_date' => $request->proposal_date,
                    'recognition_date' => $request->recognition_date,
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
            $file_ids = array();

            if ($request->hasfile('files')) {
                foreach ($request->file('files') as $key => $file) {
                    $path = $file->store('public/files/uploaded/' . Auth::user()->accountingOfficeStaff->accountingOffice->name . '');
                    $name = $file->getClientOriginalName();

                    $file_id = Files::insertGetId([
                        'user_id' => Auth::user()->id,
                        'path' => $path,
                        'name' => $name,
                        'size' => $file->getSize(),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    array_push($file_ids, $file_id);
                }

                Message::create([
                    'user_id' => Auth::user()->id,
                    'is_global' => $request->input('is_global'),
                    'targeted_at' => $request->input('targeted_at'),
                    'scheduled_at' => $request->input('scheduled_at'),
                    'contents' => $request->input('contents'),
                    'file_id' => implode(',', $file_ids)
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
        Mail::to('jvncgs.info@gmail.com')->send(new InquiryMail(Auth::user()->email, $request->content));

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
            'recognition_date' => 'required',
            'proposal_date' => 'required',
            'company_representative' => 'required',
            'accounting_office_staff' => 'required',
            'video_contributor' => 'required',
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
                'settlement_date' => $request->settlement_date,
                'recognition_date' => $request->recognition_date,
                'proposal_date' => $request->proposal_date,
                'company_representative' => $request->company_representative,
                'accounting_office_staff' => $request->accounting_office_staff,
                'video_contributor' => $request->video_contributor,
                'comment' => $request->comment,
                'kinds' => $request->kinds,
                'video_url' => $request->video_url
            ]);

            $record->save();
        } else {
            DB::transaction(function () use ($request) {
                $client_id = $this->hashids->decode($request->client_id)[0];

                //save file first
                $file_id = Files::insertGetId([
                    'user_id' => Auth::user()->id,
                    'path' => $request->file('file')->store('public/files/' . Auth::user()->accountingOfficeStaff->accountingOffice->name . '/' . Client::find($client_id)->name),
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
                        'recognition_date' => $request->recognition_date,
                        'proposal_date' => $request->proposal_date,
                        'company_representative' => $request->company_representative,
                        'accounting_office_staff' => $request->accounting_office_staff,
                        'video_contributor' => $request->video_contributor,
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
        $record_id = $this->hashids->decodeHex($request->record_id)[0];
        $record = TaxationHistory::find($record_id);
        $client = Client::find($client_id);


        return View::make('host.individual-clients.past-settlement')->with(['client' => $client, 'record' => $record, 'hashids' => $this->hashids]);
    }

    public function save_url_to_database(Request $request)
    {
        CreatedVideoRecord::create([
            'user_id' => Auth::user()->id,
            'client_id' => $request->client,
            'video_url' => $request->video_url,
            'name' => $request->name
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

    public function update_staff(Request $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::find($request->userID);
            $staff = AccountingOfficeStaff::where('user_id', $user->id)->first();

            $user->update([
                'email' => $request->userEmail,
                'password' => Hash::make($request->userPassword)
            ]);

            $user->save();

            $staff->update([
                'name' => $request->userName,
            ]);

            $staff->save();
        });

        return redirect()->route('account');
    }


    //client info update

    public function update_client_info(Request $request)
    {
        $client = Client::findorFail($request->id);

        if($client){
            $client->update([
                'name' => $request->name,
                'address' => $request->address,
                'representative' => $request->representative,
                'representative_address' => $request->representative_address,
                'tax_filing_month ' => $request->tax_filing_month
            ]);

            $client->save();

            return redirect()->route('view-registration-information', ['client_id' => $this->hashids->encode($request->id)]);
        }

        abort(403);
    }

    public function update_notification_settings(Request $request)
    {

    }

    public function update_client_credentials(Request $request)
    {
        $client = Client::findorFail($request->id);

        if($client) {
            $taxing_credentials = TaxingCredentials::where('client_id', $request->id)->first();

            if($taxing_credentials)
            {
                $taxing_credentials->update([
                    'nta_id' => $request->nta_num,
                    'nta_password' => $request->nta_password,
                    'el_tax_id' => $request->el_tax_num,
                    'el_tax_password' => $request->el_tax_password
                ]);

                $taxing_credentials->save();
            }
            else {
                TaxingCredentials::create(
                    [
                        'client_id' => $request->id,
                        'nta_id' => $request->nta_number,
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
}
