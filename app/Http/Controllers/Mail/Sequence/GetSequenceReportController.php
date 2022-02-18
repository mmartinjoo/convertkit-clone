<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Statistics\ViewModels\Tracking\GetSequenceReportsViewModel;
use Inertia\Inertia;
use Inertia\Response;

class GetSequenceReportController extends Controller
{
    public function __invoke(Sequence $sequence): Response
    {
        $sequence->load('mails');

        return Inertia::render('Sequence/Reports', [
            'model' => new GetSequenceReportsViewModel($sequence),
        ]);
    }
}
