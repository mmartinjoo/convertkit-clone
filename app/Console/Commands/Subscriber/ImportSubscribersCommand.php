<?php

namespace App\Console\Commands\Subscriber;

use Domain\Shared\Models\User;
use Domain\Subscriber\Jobs\ImportSubscribersJob;
use Illuminate\Console\Command;

class ImportSubscribersCommand extends Command
{
    protected $signature = 'subscriber:import {user? : The ID of the user}';
    protected $description = 'Import subscribers from csv';

    public function handle()
    {
        $userId = $this->argument('user') ?? $this->ask('User ID');

        ImportSubscribersJob::dispatch(
            storage_path('subscribers/subscribers.csv'),
            User::findOrFail($userId),
        );

        $this->info("Subscribers are being imported...");

        return self::SUCCESS;
    }
}
