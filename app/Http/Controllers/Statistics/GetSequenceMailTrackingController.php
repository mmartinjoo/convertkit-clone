<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ViewModels\Tracking\GetTrackingViewModel;

class GetSequenceMailTrackingController extends Controller
{
    public function __invoke(SequenceMail $sequenceMail): TrackingData
    {
        $viewModel = new GetTrackingViewModel($sequenceMail);
        return $viewModel();
    }
}
