<?php

namespace Domain\Statistics\ViewModels;

use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\SequenceProgress\SequenceProgressData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetSequenceProgressViewModel extends ViewModel
{
    public function __construct(private readonly Sequence $sequence)
    {
    }


}
