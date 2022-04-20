<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AccountingOffice;
use App\Models\Client;
use App\Models\Post;
use Hashids\Hashids;
use View;

class AdministratorController extends Controller
{
    public function index()
    {
        $this_month = AccountingOffice::whereMonth('created_at', 12)->count();
        $accounting_firms = AccountingOffice::all();
        return view('admin.dashboard')->with(['this_month', $this_month, 'accounting_firms'=>$accounting_firms]);
    }

    public function registration_status(Request $request)
    {
        $id = $request->office;
        $office = AccountingOffice::findOrFail($id);
        $clients = Client::where('accounting_office_id', $office->id);
        return view('admin.registration-status')->with(['office'=>$office, 'clients'=>$clients]);
    }

    public function registered_client_information(Request $request)
    {
        $office_id = $request->office_id;
        $office = AccountingOffice::findOrFail($office_id);
        $clients = Client::where('accounting_office_id', $office_id)->get();

        return View::make('admin.registered-client-information')->with(['clients'=>$clients, 'office'=>$office]);
    }

    public function contact()
    {
        $posts = Post::all();
        return View::make('admin.contact')->with(['posts'=>$posts]);
    }

    public function settings()
    {

    }

    public function link_change()
    {
        return View::make('admin.link-change');
    }
}
