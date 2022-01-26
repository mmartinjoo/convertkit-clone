<?php

namespace App\Http\Controllers\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Broadcast\Actions\CreateBroadcastAction;
use Domain\Broadcast\DataTransferObjects\BroadcastData;

class BroadcastController extends Controller
{
    public function store(BroadcastData $data): BroadcastData
    {
        return BroadcastData::from(
            CreateBroadcastAction::execute($data)
        );
    }
}
