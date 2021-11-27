<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientUpload;

use Session;

//Models
use App\Models\Message;
use App\Models\Client;
use App\Models\ClientStaff;

class ClientController extends Controller
{
    public function index()
    {
        $messages = Message::where([[
            'accounting_office_id', '=', 1
        ]])
        ->where(function($q){
          $q->where('is_global', '=', '1')
          ->orWhere('targeted_at', '=', Auth::user()->client->id);  
        })->get();
        return View::make('client.dashboard')->with(['messages' => $messages]);
    }

    public function going_out()
    {
        return View::make('client.outgoing');
    }

    public function upload_files(Request $request) 
    {
        
        if($request->has('file')) {
            foreach($request->file('file') as $key => $file) {
                $comment = $request->input('comment')[$key];

                DB::transaction(function () use ($comment, $request) {

                    $user_id = Auth::user()->id;
                    $client = Client::where('user_id', $user_id)->first();
                    $staff = ClientStaff::where('user_id', $user_id)->first();

                    ClientUpload::create(
                        [
                            'client_id' => $client->id,
                            'client_staff_id' => $staff->id,
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $file->store('public/files/upload/'.Auth::user()->id),
                            'file_size' => $file->getFileSize(),
                            'comment' => $comment
                        ]);

                    return redirect('data-outgoing');
                });
            }
        }
        else {
            return redirect('data-outgoing');
        }
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
}
