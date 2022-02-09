<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Broadcast\CreateBroadcastAction;
use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;

class CreateBroadcastController extends Controller
{
    public function __invoke(BroadcastData $data): BroadcastData
    {
        return BroadcastData::from(
            CreateBroadcastAction::execute($data)
        );
    }
}
