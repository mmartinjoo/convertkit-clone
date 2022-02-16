<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Sequence\UpsertSequenceMailAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;

class CreateSequenceMailController extends Controller
{
    public function __invoke(SequenceMailData $data, Sequence $sequence): SequenceMailData
    {
        return SequenceMailData::from(
            UpsertSequenceMailAction::execute($data, $sequence)
        );
    }
}
