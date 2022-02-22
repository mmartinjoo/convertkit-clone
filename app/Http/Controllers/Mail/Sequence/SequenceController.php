<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Sequence\CreateSequenceAction;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\ViewModels\Sequence\CreateSequenceViewModel;
use Domain\Mail\ViewModels\Sequence\GetSequencesViewModel;
use Domain\Mail\ViewModels\Sequence\ShowSequenceViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Redirect;

class SequenceController extends Controller
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
        $sequence = CreateSequenceAction::execute(SequenceData::fromRequest($request));

        return Redirect::route('sequences.show', $sequence);
    }

    public function show(Sequence $sequence): InertiaResponse
    {
        return Inertia::render('Sequence/Show', [
            'model' => new ShowSequenceViewModel($sequence),
        ]);
    }

    public function destroy(Sequence $sequence): Response
    {
        $sequence->subscribers()->sync([]);
        $sequence->mails->each->delete();
        $sequence->delete();

        return response()->noContent();
    }
}
