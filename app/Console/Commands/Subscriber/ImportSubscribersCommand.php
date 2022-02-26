<?php

namespace App\Console\Commands\Subscriber;

use Domain\Subscriber\Jobs\ImportSubscribersJob;
use Illuminate\Console\Command;

class ImportSubscribersCommand extends Command
{
    protected $signature = 'subscriber:import';
    protected $description = 'Import subscribers from csv';

    public function handle()
    {
        ImportSubscribersJob::dispatch(storage_path('subscribers/subscribers.csv'));

        $this->info("Subscribers are being imported...");

        return self::SUCCESS;
    }
}
