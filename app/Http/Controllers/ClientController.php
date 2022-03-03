<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Auth;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

//Models
use App\Models\Message;
use App\Models\Client;
use App\Models\ClientStaff;
use App\Models\ClientUpload;
use App\Models\HostUpload;
use App\Models\Files;
use App\Models\TaxationHistory;
use App\Models\PastNotification;
use App\Models\OneTimePassword;
use App\Models\User;

use Carbon\Carbon;
use Hashids\Hashids;

use Mail;
use App\Mail\UploadNotification;
use App\Mail\InquiryMail;
use App\Mail\OTPMail;
use App\Mail\NewClientAccessMail;

class ClientController extends Controller
{
    public $hashids;
    public $for_approval;

    public function __construct()
    {
        $this->hashids = new Hashids(config('hashids.loginSalt'), 10);
    }

    public function get_approval_count()
    {
        $client_id = Auth::user()->clientStaff->client->id;

        return HostUpload::where('client_id', $client_id)->where('status', '<>', 1)->where('priority', 0)->count();
    }
    public function index()
    {
        $date = date('Y-m-d');

        $messages = Message::where('created_at', 'like', '' . $date . '%')->where('is_global', 1)->orWhere('targeted_at', Auth::user()->clientStaff->client->id)->latest()->limit(5)->get();
        $uploads = ClientUpload::where('user_id', Auth::user()->id)->get();
        $downloads = HostUpload::where('client_id', Auth::user()->clientStaff->client->id)->get();
        $files = Files::where('user_id', Auth::user()->id)->whereIn('id', ClientUpload::get('file_id'))->get();
        $page_title = 'ホーム';
        return View::make('client.dashboard')->with(['for_approval' => $this->get_approval_count(), 'page_title' => $page_title, 'messages' => $messages, 'uploads' => $uploads, 'downloads' => $downloads, 'files' => $files]);
    }

    public function going_out()
    {
        $page_title = 'To　会計事務所';
        $uploads = ClientUpload::where('user_id', Auth::user()->id)->latest()->get();
        return View::make('client.outgoing')->with(['for_approval' => $this->get_approval_count(), 'page_title' => $page_title, 'uploads' => $uploads]);
    }

    public function upload_files(Request $request)
    {
        if ($request->has('file')) {
            foreach ($request->file('file') as $key => $value) {
                $comment = $request->input('comment')[$key];

                DB::transaction(function () use ($comment, $request, $key) {

                    $user_id = Auth::user()->id;
                    $client_id = Auth::user()->clientStaff->client->id;
                    $staff = ClientStaff::where('user_id', $user_id)->first();

                    //TO FIX upload path:
                    $name = $request->file('file')[$key]->getClientOriginalName();
                    $file = $request->file('file')[$key];
                    Storage::disk('gcs')->put(Auth::user()->clientStaff->client->id . "/" . $name, file_get_contents($file));
                    $path = Auth::user()->clientStaff->client->id . "/" . $name;


                    $file_id = Files::insertGetId([
                        'user_id' => $user_id,
                        'path' => $path,
                        'name' => $name,
                        'size' => $request->file('file')[$key]->getSize(),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    if ($file_id) {
                        ClientUpload::create([
                            'user_id' => $user_id,
                            'file_id' => $file_id,
                            'comment' => $comment
                        ]);
                    }
                });
            }

            $client = Client::find(Auth::user()->clientStaff->client_id);
            Session::flash('success', 'ファイルバッチが会計事務所に送信されました。');
            $this->sendUploadNotification(Auth::user()->email, Auth::user()->clientStaff->client->host, "Successfully uploaded file");
            $this->sendUploadNotification($client->host->contact_email, $client->host, "One of your clients has uploaded a file. It is ready for download on your dashboard.");

            return redirect()->route('data-outgoing');
        } else {
            Session::flash('failure', 'ファイルのアップロードでエラーが発生しました。 もう一度やり直してください。');
            return redirect('data-outgoing');
        }
    }

    public function sendUploadNotification($email, $target, $message)
    {
        Mail::to($email)->send(new UploadNotification($target, $message));

        if (Mail::failures()) {
            return false;
        }

        return true;
    }

    public function delete_records(Request $request)
    {
        $ids = $request->file_ids;
        foreach ($ids as $id) {
            $record = ClientUpload::find($id);
            $record->delete();
        }

        return 'Deleted successfully';
    }

    public function going_in()
    {
        $page_title = 'From　会計事務所';
        $host_uploads = HostUpload::where('client_id', '=', Auth::user()->clientStaff->client->id)->latest()->get();

        return View::make('client.incoming')->with(['for_approval' => $this->get_approval_count(), 'page_title' => $page_title, 'host_uploads' => $host_uploads]);
    }

    public function history()
    {
        $page_title = '過去決算';
        $archives = TaxationHistory::where('client_id', Auth::user()->clientStaff->client->id)->get();
        return View::make('client.history')->with(['for_approval' => $this->get_approval_count(), 'page_title' => $page_title, 'archives' => $archives]);
    }

    public function access_stored_info()
    {
        return View::make('client.access-password-onetime');
    }

    public function view_stored_info()
    {
        return View::make('client.view-stored-info');
    }

    public function notification_history()
    {
        $page_title = '過去届出';
        $account = Client::find(Auth::user()->clientStaff->client->id);
        $notifs = PastNotification::where('client_id', Auth::user()->clientStaff->client->id)->get();
        return View::make('client.notif-history')->with(['for_approval' => $this->get_approval_count(), 'page_title' => $page_title, 'account' => $account, 'records' => $notifs]);
    }

    public function send_otp_notif(Request $request)
    {
        $client_id = $request->client_id;

        return 'success';
    }

    public function send_otp(Request $request)
    {
        DB::transaction(function () use ($request) {
            $password = Str::random(10);
            $access_id = OneTimePassword::insertGetId([
                'password' => Hash::make($password),
                'target_table' => $request->table,
                'record_id' => $request->record_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);



            $url = url(route('access-record-verification', ['access_id' => $this->hashids->encode($access_id)]));
            Mail::to(Auth::user()->email)->send(new OTPMail($password, $url));
            if (Mail::failures()) {
                return 'failure';
            }
        });

        return 'success';
    }

    public function access_record_verification(Request $request)
    {
        return View::make('client.access_record_verification', ['access_id' => $request->access_id]);
    }

    public function various_settings()
    {
        $page_title = '各種設定';
        $staffs = ClientStaff::where('client_id', Auth::user()->clientStaff->client_id)->get();
        $account = Client::find(Auth::user()->clientStaff->client->id);
        return View::make('client.settings')->with(['for_approval' => $this->get_approval_count(), 'page_title' => $page_title, 'account' => $account, 'staffs' => $staffs]);
    }

    public function faq()
    {
        $page_title = 'FAQ';
        return View::make('client.faq')->with(['for_approval' => $this->get_approval_count(), 'page_title' => $page_title]);
    }

    public function send_inquiry(Request $request)
    {
        Mail::to('jvncgs.info@gmail.com')->send(new InquiryMail(Auth::user()->email, $request->content));

        if (Mail::fails()) {
            return 'failure';
        } else {
            return 'success';
        }
    }

    public function download_file(Request $request)
    {
        $file_db = Files::find($request->file_id);

        $file = Storage::disk('gcs')->url($file_db->path);
        $name = $file_db->name;
        return array(url($file), $name);
    }

    public function update_host_upload(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $target = HostUpload::find($id);

        $target->update([
            'status' => $status,
            'modified_by_user_id' => Auth::user()->id,
        ]);

        if ($target->save()) {
            return 'success';
        }
    }

    public function one_time_access(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('access-record-verification')
                ->withErrors($validator)
                ->withInput();
        }

        $access = OneTimePassword::find($this->hashids->decode($request->record_id)[0]);


        $route = $this->access_record($access, $request->password);

        return redirect($route);
    }

    public function access_record(OneTimePassword $access, $password)
    {
        if (Hash::check($password, $access->password)) {
            switch ($access->target_table) {
                case 'past_notifications':
                    return route('access-past-notification', ['record_id' => $this->hashids->encode($access->record_id)]);
                    break;
                case 'taxation_histories':
                    return route('access-tax-history', ['id' => $this->hashids->encode($access->record_id)]);
                    break;
                default:
                    abort(403);
                    break;
            }
        } else {
            abort(403);
        }
    }

    public function access_past_notification(Request $request)
    {
        $record = PastNotification::findOrFail($this->hashids->decode($request->record_id)[0]);
        return View::make('client.view_archived_notif')->with('record', $record);
    }

    public function access_tax_history(Request $request)
    {
        $record = TaxationHistory::find($this->hashids->decode($request->id)[0]);

        return View::make('client.view_archived_taxation')->with('record', $record);
    }


    public function register_new_access(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_role' => 'required',
            'staff_name' => 'required',
            'staff_email' => 'required|unique:users,email|email:rfc,dns'
        ]);

        if ($validator->fails()) {
            return redirect()->route('various-settings')
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function () use ($request) {
            $password = Str::random(8);
            $user = User::create([
                'email' => $request->staff_email,
                'password' => Hash::make($password),
                'role_id' => $request->staff_rol + 4,
                'remember_token' => Str::random(60),
            ]);

            if ($user) {
                $id = $user->id;
                $login_id = 'C' . date('Y') . $id . $user->role_id;
                $user->update([
                    'login_id' => $login_id
                ]);
                $user->save();

                ClientStaff::create([
                    'client_id' => $request->client_id,
                    'user_id' => $id,
                    'name' => $request->staff_name,
                    'is_admin' => $request->staff_role
                ]);
            }

            Mail::to($request->staff_email)->send(new NewClientAccessMail($user, Client::find($request->client_id)->name, $password, $request->staff_name));
        });
        return redirect()->route('various-settings');
    }
}
