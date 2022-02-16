<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Sequence\UpsertSequenceMailAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SequenceMailController extends Controller
{
    public function store(Request $request, Sequence $sequence): SequenceMailData
    {
        $mail = UpsertSequenceMailAction::execute(
            SequenceMailData::fromRequest($request),
            $sequence
        );

        return SequenceMailData::from($mail);
    }

    public function update(Request $request, Sequence $sequence): Response
    {
        UpsertSequenceMailAction::execute(
            SequenceMailData::fromRequest($request),
            $sequence
        );

        return response()->noContent();
    }
}
