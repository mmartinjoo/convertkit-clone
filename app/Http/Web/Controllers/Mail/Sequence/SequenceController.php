<?php

namespace App\Http\Web\Controllers\Mail\Sequence;

use Domain\Mail\Actions\Sequence\CreateSequenceAction;
use Domain\Mail\Actions\Sequence\DeleteSequenceAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\ViewModels\Sequence\CreateSequenceViewModel;
use Domain\Mail\ViewModels\Sequence\GetSequencesViewModel;
use Domain\Mail\ViewModels\Sequence\EditSequenceContentViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Redirect;

class SequenceController
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Sequence/List', [
            'model' => new GetSequencesViewModel(),
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Sequence/Form', [
            'model' => new CreateSequenceViewModel(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $sequence = CreateSequenceAction::execute(
            SequenceData::fromRequest($request),
            $request->user(),
        );

        return Redirect::route('sequences.edit', $sequence);
    }

    public function edit(Sequence $sequence): InertiaResponse
    {
        return Inertia::render('Sequence/Content', [
            'model' => new EditSequenceContentViewModel($sequence),
        ]);
    }

    public function destroy(Sequence $sequence): RedirectResponse
    {
        DeleteSequenceAction::execute($sequence);

        return Redirect::route('sequences.index');
    }
}
