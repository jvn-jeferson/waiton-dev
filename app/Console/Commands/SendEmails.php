<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SendEmails extends Command
{
    protected $signature = 'password:email';

    protected $description = 'Password Email';

    public function handle()
    {
        $user = User::find(1);
        $user->sendPasswordNotification($user->createToken());
    }
}
