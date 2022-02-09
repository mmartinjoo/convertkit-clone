<?php

namespace App\Http\Controllers\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Sequence\CreateSequenceMailAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;

class CreateSequenceMailController extends Controller
{
    public function __invoke(SequenceMailData $data, Sequence $sequence): SequenceMailData
    {
        return SequenceMailData::from(
            CreateSequenceMailAction::execute($data, $sequence)
        );
    }
}
