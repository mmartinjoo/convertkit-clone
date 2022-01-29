<?php

namespace Domain\Sequence\Actions;

use Domain\Sequence\DataTransferObjects\SequenceData;
use Domain\Sequence\Models\Sequence;

class CreateSequenceAction
{
    public static function execute(SequenceData $data): Sequence
    {
        return Sequence::create($data->all());
    }
}
