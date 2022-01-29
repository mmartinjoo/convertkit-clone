<?php

namespace App\Http\Controllers\Sequence;

use App\Http\Controllers\Controller;
use Domain\Sequence\Actions\CreateSequenceMailAction;
use Domain\Sequence\DataTransferObjects\SequenceMailData;
use Domain\Sequence\Models\Sequence;

class CreateSequenceMailController extends Controller
{
    public function __invoke(SequenceMailData $data, Sequence $sequence): SequenceMailData
    {
        return SequenceMailData::from(
            CreateSequenceMailAction::execute($data, $sequence)
        );
    }
}
