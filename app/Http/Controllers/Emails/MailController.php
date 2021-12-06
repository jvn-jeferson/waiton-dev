<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function basic_email() {
        $data = array('name'=>"Virat Gandhi");
     
        Mail::send(['text'=>'mail'], $data, function($message) {
           $message->to('jeffbu.dev@gmail.com', 'Tutorials Point')->subject
              ('Laravel Basic Testing Mail');
           $message->from('jbonayon15@gmail.com','Virat Gandhi');
        });
        echo "Basic Email Sent. Check your inbox.";
     }
     public function html_email() {
        $data = array('name'=>"Virat Gandhi");
        Mail::send('mail', $data, function($message) {
           $message->to('jeffbu.dev@gmail.com', 'Tutorials Point')->subject
              ('Laravel HTML Testing Mail');
           $message->from('jbonayon15@gmail.com','Virat Gandhi');
        });
        echo "HTML Email Sent. Check your inbox.";
     }
     public function attachment_email() {
        $data = array('name'=>"Virat Gandhi");
        Mail::send('mail', $data, function($message) {
           $message->to('jeffbu.dev@gmail.com', 'Tutorials Point')->subject
              ('Laravel Testing Mail with Attachment');
           $message->from('jbonayon15@gmail.com','Virat Gandhi');
        });
        echo "Email Sent with attachment. Check your inbox.";
     }
}
