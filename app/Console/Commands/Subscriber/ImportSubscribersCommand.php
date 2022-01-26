<?php

namespace App\Console\Commands\Subscriber;

use Domain\Subscriber\Actions\ImportSubscribersAction;
use Illuminate\Console\Command;

class ImportSubscribersCommand extends Command
{
    protected $signature = 'subscriber:import';
    protected $description = 'Import subscribers from csv';

    public function handle()
    {
        $count = ImportSubscribersAction::execute(storage_path('subscribers/subscribers.csv'));
        $this->info("$count subscribers have been imported successfully");

        return self::SUCCESS;
    }
}
