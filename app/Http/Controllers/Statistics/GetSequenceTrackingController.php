<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Sequence\Models\Sequence;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ViewModels\Tracking\GetSequenceTrackingViewModel;

class GetSequenceTrackingController extends Controller
{
    public function __invoke(Sequence $sequence): TrackingData
    {
        $viewModel = new GetSequenceTrackingViewModel($sequence);
        return $viewModel();
    }
}
