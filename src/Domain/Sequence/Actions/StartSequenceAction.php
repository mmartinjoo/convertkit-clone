<?php

namespace Domain\Sequence\Actions;

use Domain\Sequence\Enums\SequenceStatus;
use Domain\Sequence\Models\Sequence;

class StartSequenceAction
{
    public static function execute(Sequence $sequence): void
    {
        $sequence->status = SequenceStatus::STARTED;
        $sequence->save();
    }
}
