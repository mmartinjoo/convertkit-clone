<?php

namespace Domain\Subscriber\Jobs;

use Domain\Subscriber\Actions\ImportSubscribersAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSubscribersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly string $path)
    {
    }

    public function handle()
    {
        ImportSubscribersAction::execute($this->path);
    }
}
