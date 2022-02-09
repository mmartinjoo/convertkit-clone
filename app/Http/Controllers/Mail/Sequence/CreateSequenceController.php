<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Sequence\CreateSequenceAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;

class CreateSequenceController extends Controller
{
    public function __invoke(SequenceData $data): SequenceData
    {
        return SequenceData::from(
            CreateSequenceAction::execute($data)
        );
    }
}
