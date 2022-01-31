<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Sequence\Models\Sequence;
use Domain\Statistics\DataTransferObjects\SequenceProgress\SequenceProgressData;
use Domain\Statistics\ViewModels\GetSequenceProgressViewModel;

class GetSequenceProgressController extends Controller
{
    public function __invoke(Sequence $sequence): SequenceProgressData
    {
        $viewModel = new GetSequenceProgressViewModel($sequence);
        return $viewModel();
    }
}
