<?php

namespace App\Http\Web\Controllers\Mail\Sequence;

use Domain\Mail\Actions\Sequence\DeleteSequenceMailAction;
use Domain\Mail\Actions\Sequence\UpsertSequenceMailAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SequenceMailController
{
    public function store(Request $request, Sequence $sequence): SequenceMailData
    {
        $mail = UpsertSequenceMailAction::execute(
            SequenceMailData::fromRequest($request),
            $sequence,
            $request->user(),
        );

        return SequenceMailData::from($mail);
    }

    public function update(Request $request, Sequence $sequence): Response
    {
        UpsertSequenceMailAction::execute(
            SequenceMailData::fromRequest($request),
            $sequence,
            $request->user(),
        );

        return response()->noContent();
    }

    public function destroy(Sequence $sequence, SequenceMail $mail): Response
    {
        DeleteSequenceMailAction::execute($mail);

        return response()->noContent();
    }
}
