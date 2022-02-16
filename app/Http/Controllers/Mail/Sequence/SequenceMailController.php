<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Sequence\UpsertSequenceMailAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redirect;

class SequenceMailController extends Controller
{
    public function store(Request $request, Sequence $sequence): RedirectResponse
    {
        UpsertSequenceMailAction::execute(
            SequenceMailData::fromRequest($request),
            $sequence
        );

        return Redirect::route('sequences.show', $sequence);
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
