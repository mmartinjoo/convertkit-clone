<?php

namespace Domain\Mail\Jobs\Broadcast;

use Domain\Mail\Actions\Broadcast\SendBroadcastAction;
use Domain\Mail\Models\Broadcast\Broadcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBroadcastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Broadcast $broadcast)
    {
    }

    public function handle()
    {
        SendBroadcastAction::execute($this->broadcast);
    }
}
