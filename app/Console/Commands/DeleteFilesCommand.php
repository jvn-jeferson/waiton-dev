<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\DeleteTemporaryFiles;

class DeleteFilesCommand extends Command
{
    protected $signature = 'delete:files';

    protected $description = 'Testing for Jobs delete Files';

    public function handle()
    {
        dispatch(new DeleteTemporaryFiles());
    }
}
