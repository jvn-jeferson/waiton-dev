<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Message;
use App\Model\File;
use DataTables;


class MessageController extends Controller
{
    public function getMessageByClientId(Request $request, $clientId)
    {
        if($request->ajax()) {
            $data = Message::where('targeted_at', $clientId)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('file_name', function($row) {
                        $file_name = File::find($row['file_id'])->name;
                        return $file_name;
                })
                ->rawColumns(['file_name'])
                ->make(true);
        }

        return view('host.individual-clients.message-client');
    }
}
