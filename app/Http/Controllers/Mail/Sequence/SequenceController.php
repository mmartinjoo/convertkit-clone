<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\ViewModels\Sequence\GetSequencesViewModel;
use Inertia\Inertia;
use Inertia\Response;

class SequenceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Sequence/List', [
            'model' => new GetSequencesViewModel(),
        ]);
    }
}
