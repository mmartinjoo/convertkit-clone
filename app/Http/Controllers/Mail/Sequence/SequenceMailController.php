<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Sequence\CreateSequenceAction;
use Domain\Mail\Actions\Sequence\CreateSequenceMailAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\ViewModels\Sequence\CreateSequenceViewModel;
use Domain\Mail\ViewModels\Sequence\GetSequencesViewModel;
use Domain\Mail\ViewModels\Sequence\ShowSequenceViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class SequenceMailController extends Controller
{
    public function store(Request $request, Sequence $sequence): RedirectResponse
    {
        CreateSequenceMailAction::execute(
            SequenceMailData::fromRequest($request),
            $sequence
        );

        return Redirect::route('sequences.show', $sequence);
    }
}
