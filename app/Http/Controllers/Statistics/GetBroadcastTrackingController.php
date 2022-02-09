<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ViewModels\Tracking\GetTrackingViewModel;

class GetBroadcastTrackingController extends Controller
{
    public function __invoke(Broadcast $broadcast): TrackingData
    {
        $viewModel = new GetTrackingViewModel($broadcast);
        return $viewModel();
    }
}
