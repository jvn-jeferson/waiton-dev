<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

use Mail;
use App\Mail\RegistrationMail;

class TemporaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('temporary.pdfview');
    }


    public function registration_mail() {

        $data = [
            'rep' => 'Kinichi Ichikawa',
            'company' => 'Ichikawa Tax Accounting Office',
            'password' => 'SGHqwe72',
        ];

        Mail::to('jeffbu.dev@gmail.com')->send(new RegistrationMail($data));

    }

    public function test_file()
    {


        return View::make('layouts.permanent-record-pdf');
    }
}
