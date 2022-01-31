<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Sequence\Models\Sequence;
use Domain\Statistics\Actions\Sequences\GetSequenceProgressAction;
use Domain\Statistics\DataTransferObjects\SequenceProgress\SequenceProgressData;

class GetSequenceProgressController extends Controller
{
    public function __invoke(Sequence $sequence): SequenceProgressData
    {
        return GetSequenceProgressAction::execute($sequence);
    }
}
