<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\DeleteHostFiles;

class DeleteHostsFile extends Command
{
    protected $signature = 'delete:host_files';

    protected $description = 'Testing for Jobs delete Host Files';

    public function handle()
    {
        dispatch(new DeleteHostFiles());
    }
}
