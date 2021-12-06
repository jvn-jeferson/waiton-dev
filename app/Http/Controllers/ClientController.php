<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Auth;

use Session;
use Illuminate\Support\Facades\DB;

//Models
use App\Models\Message;
use App\Models\Client;
use App\Models\ClientStaff;
use App\Models\ClientUpload;
use App\Models\HostUpload;
use App\Models\File;

use Carbon\Carbon;
use Hashids\Hashids;

class ClientController extends Controller
{
    public function index()
    {
        $messages = Message::where('is_global', 1)->orWhere('targeted_at', Auth::user()->clientStaff->client->id)->latest()->limit(5);

        $uploads = ClientUpload::where('user_id', Auth::user()->id)->get();
        $downloads = HostUpload::where('client_id', Auth::user()->clientStaff->client->id)->get();
        return View::make('client.dashboard')->with(['messages' => $messages, 'uploads' => $uploads, 'downloads' => $downloads]);
    }

    public function going_out()
    {
        $uploads = ClientUpload::where('user_id', Auth::user()->id)->latest()->get();
        return View::make('client.outgoing')->with(['uploads' => $uploads]);
    }

    public function upload_files(Request $request)
    {
        if($request->has('file')) {
            foreach($request->file('file') as $key => $value) {
                $comment = $request->input('comment')[$key];

                DB::transaction(function () use ($comment, $request, $key) {

                    $user_id = Auth::user()->id;
                    $client = Auth::user()->clientStaff->client;
                    $staff = ClientStaff::where('user_id', $user_id)->first();

                    $file_id = File::insertGetId([
                        'user_id' => $user_id,
                        'path' => $request->file('file')[$key]->store('public/files/upload/'.Auth::user()->id),
                        'name' => $request->file('file')[$key]->getClientOriginalName(),
                        'size' => $request->file('file')[$key]->getSize(),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    
                    if($file_id)
                    {
                        ClientUpload::create([
                            'user_id' => $user_id,
                            'file_id' => $file_id,
                            'comment' => $comment
                        ]);
                    }

                });
            }

            Session::flash('success', 'ファイルバッチが会計事務所に送信されました。');
            return redirect('data-outgoing');
        }
        else {
            return redirect('data-outgoing');
        }
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
        
        return View::make('client.incoming');
    }

    public function history()
    {
        return View::make('client.history');
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
        return View::make('client.notif-history');
    }

    public function various_settings()
    {
        return View::make('client.settings');
    }

    public function faq()
    {
        return View::make('client.faq');
    }

    public function inquiry()
    {
        return View::make('client.inquiry');
    }
}
