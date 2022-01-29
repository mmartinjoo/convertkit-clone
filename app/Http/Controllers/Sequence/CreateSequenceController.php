<?php

namespace App\Http\Controllers\Sequence;

use App\Http\Controllers\Controller;
use Domain\Sequence\Actions\CreateSequenceAction;
use Domain\Sequence\DataTransferObjects\SequenceData;

class CreateSequenceController extends Controller
{
    public function __invoke(SequenceData $data): SequenceData
    {
        return SequenceData::from(
            CreateSequenceAction::execute($data)
        );
    }
}
