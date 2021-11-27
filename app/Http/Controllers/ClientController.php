<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientUpload;

use Session;

//Models
use App\Models\Message;

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
