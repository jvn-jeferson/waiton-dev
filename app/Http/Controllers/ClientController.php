<?php

namespace App\Http\Controllers;

use App\Mail\ClientUploadNotifMail;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Auth;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

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
use App\Mail\DecisionCompleteMail;
use App\Mail\ViewingNotifMail;
use App\Models\PermanentRecord;

class ClientController extends Controller
{
    public $hashids;
    public $for_approval;

    public const DOWNLOAD_CLOUD = 'https://storage.googleapis.com/download/storage/v1/b/upfiling_bukcet/o/';

    public function __construct()
    {
        $this->hashids = new Hashids(config('hashids.loginSalt'), 10);
    }

    public function get_approval_count()
    {
        $client_id = Auth::user()->clientStaff->client->id;

        return HostUpload::where('client_id', $client_id)->where('status', 0)->count();
    }
    public function index()
    {
        $date = date('Y-m-d');

        $messages = Message::where('created_at', 'like', '' . $date . '%')->where('is_global', 1)->orWhere('targeted_at', Auth::user()->clientStaff->client->id)->latest()->limit(5)->get();
        $uploads = ClientUpload::where('user_id', Auth::user()->id)->latest()->get();
        $downloads = HostUpload::where('client_id', Auth::user()->clientStaff->client->id)->latest()->get();
        $files = Files::where('user_id', Auth::user()->id)->whereIn('id', ClientUpload::get('file_id'))->latest()->get();
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
                    $path = "client-uploads/" . Auth::user()->clientStaff->client->id . "/" . str_replace(' ', '%20', $name);
                    Storage::disk('gcs')->put($path, file_get_contents($file));


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

            $client = Auth::user()->clientStaff->client;
            $host = $client->host;
            $uploader = Auth::user()->clientStaff;



            $this->sendUploadNotification($client->contact_email, $client, $host, $uploader);
            $this->sendUploadNotification($host->contact_email, $client, $host, $uploader);

            return redirect()->route('data-outgoing');
        } else {
            Session::flash('failure', 'ファイルのアップロードでエラーが発生しました。 もう一度やり直してください。');
            return redirect('data-outgoing');
        }
    }

    public function sendUploadNotification($target, $client, $host, $uploader)
    {
        Mail::to($target)->send(new ClientUploadNotifMail($client, $host, $uploader));

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

            $user = Auth::user()->clientStaff;


            $url = url(route('access-record-verification', ['access_id' => $this->hashids->encode($access_id)]));
            Mail::to(Auth::user()->email)->send(new OTPMail($password, $url, $user));
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
        $name = e($file_db->name);
        return array(url($file), $name);
    }

    public function download_host_file(Request $request)
    {
        $record = HostUpload::findorFail($request->record_id);

        $record->update([
            'status' => 1,
            'last_viewed_by_user_id' => Auth::user()->id,
            'modified_by_user_id' => Auth::user()->id,
        ]);

        if ($record->save()) {
            if ($record->priority == 1) {
                $staff = Auth::user()->clientStaff;
                $company = $staff->client;
                $host = $company->host;
                $slug = '';
                if ($record->video_url) {
                    $slug = '動画含む';
                } else {
                    $slug = 'その他';
                }


                $today = Carbon::now()->format('Y-m-d H:i:s');
                $file = Files::find($record->file_id);
                $upload_date = $record->created_at;
                $sender = User::find($record->user_id)->accountingOfficeStaff;
                $video_url = $record->video_url;
                $with_approval = 0;
                $comment = $record->details;
                $title = '確認書_' . date('Y_m_d_H:i:s') . '.pdf';

                $pdf = PDF::loadView('layouts.permanent-record-pdf', ['client_name' => $company->name, 'accounting_office_name' => $host->name, 'email_date' => $today, 'file_name' => $file->name, 'upload_date' => $upload_date, 'sender' => $sender->name, 'video_url' => $video_url, 'with_approval' => $with_approval, 'comment' => $comment, 'first_viewing_date' => $today, 'response_date' => $today, 'decision' => '承認不要データ', 'viewer' => $staff->name, 'creation_date' => $today, 'title' => $title]);

                $content = $pdf->download($title)->getOriginalContent();
                $path = 'permanent_records/' . $sender->accountingOffice->id . '/' . $title;

                Storage::disk('gcs')->put($path, $content);

                $pdf_file = Files::create(
                    [
                        'user_id' => Auth::user()->id,
                        'path' => $path,
                        'name' => $title,
                        'size' => 0
                    ]
                );

                PermanentRecord::create([
                    'client_id' => $company->id,
                    'accounting_office_id' => $host->id,
                    'file_id' => $record->file_id,
                    'pdf_file_id' => $pdf_file->id,
                    'request_sent_at' => $upload_date,
                    'request_sent_by_staff_id' => $sender->id,
                    'has_video' => $video_url,
                    'with_approval' => $with_approval,
                    'comments' => $comment,
                    'viewed_by_staff_id' => $staff->id,
                    'response_completed_at' => $today,
                    'is_approved' => 0,
                    'viewing_date' => $today
                ]);

                $this->notify_archive_creation($company->contact_email, $company, $host, $staff, $slug);
                $this->notify_archive_creation($host->contact_email, $company, $host, $staff, $slug);
            }

            $file_db = Files::find($record->file_id);

            $path = urlencode($file_db->path);
            $name = e($file_db->name);

            return array($path, $name);
        }
    }

    public function update_host_upload(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $target = HostUpload::find($id);

        $target->update([
            'status' => $status,
            'last_viewed_by_user_id' => Auth::user()->id,
            'modified_by_user_id' => Auth::user()->id,
        ]);

        if ($target->save()) {
            $staff = Auth::user()->clientStaff;
            $company = $staff->client;
            $host = $company->host;

            if ($status != 1) {
                $today = Carbon::now()->format('Y-m-d H:i:s');
                $file = Files::find($target->file_id);
                $upload_date = $target->created_at;
                $sender = User::find($target->user_id)->accountingOfficeStaff;
                $video_url = $target->video_url;
                $with_approval = 1;
                $comment = $target->details;
                $title = '確認書_' . date('Y_m_d_H:i:s') . '.pdf';

                $pdf = PDF::loadView('layouts.permanent-record-pdf', ['client_name' => $company->name, 'accounting_office_name' => $host->name, 'email_date' => $today, 'file_name' => $file->name, 'upload_date' => $upload_date, 'sender' => $sender->name, 'video_url' => $video_url, 'with_approval' => $with_approval, 'comment' => $comment, 'first_viewing_date' => $today, 'response_date' => $today, 'decision' => '承認不要データ', 'viewer' => $staff->name, 'creation_date' => $today, 'title' => $title]);

                $content = $pdf->download($title)->getOriginalContent();
                $path = 'permanent-records/' . $sender->accountingOffice->id . '/' . str_replace(' ', '%20', $title);

                Storage::disk('gcs')->put($path, $content);

                $pdf_file = Files::create(
                    [
                        'user_id' => Auth::user()->id,
                        'path' => $path,
                        'name' => $title,
                        'size' => 0
                    ]
                );

                PermanentRecord::create([
                    'client_id' => $company->id,
                    'accounting_office_id' => $host->id,
                    'file_id' => $target->file_id,
                    'pdf_file_id' => $pdf_file->id,
                    'request_sent_at' => $upload_date,
                    'request_sent_by_staff_id' => $sender->id,
                    'has_video' => $video_url,
                    'with_approval' => $with_approval,
                    'comments' => $comment,
                    'viewed_by_staff_id' => $staff->id,
                    'response_completed_at' => $today,
                    'is_approved' => $request->status,
                    'viewing_date' => $today
                ]);

                $this->sendDecisionCompleteMail($company->contact_email, $host, $company, $staff);
                $this->sendDecisionCompleteMail($host->contact_email, $host, $company, $staff);
            }

            return 'success';
        }
    }

    public function sendDecisionCompleteMail($target, $host, $client, $staff)
    {
        Mail::to($target)->send(new DecisionCompleteMail($client, $host, $staff));
        if (Mail::failures()) {
            return false;
        }

        return true;
    }

    public function notify_archive_creation($target, $client, $host, $staff, $slug)
    {
        Mail::to($target)->send(new ViewingNotifMail($client, $host, $staff, $slug));
        if (Mail::failures()) {
            return false;
        }
        return true;
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

    public function material_storage()
    {
        $materials = PermanentRecord::where('client_id', Auth::user()->clientStaff->client->id)->latest()->get();
        return View::make('client.material-storage')->with(['for_approval' => $this->get_approval_count(), 'page_title' => '確認済の資料', 'materials' => $materials]);
    }
}
