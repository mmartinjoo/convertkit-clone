<?php

namespace App\Http\Web\Controllers\Mail\Sequence;

use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\ViewModels\Sequence\GetSequenceReportsViewModel;
use Inertia\Inertia;
use Inertia\Response;

class GetSequenceReportController
{
    public function __invoke(Sequence $sequence): Response
    {
        $sequence->load('mails');

        return Inertia::render('Sequence/Reports', [
            'model' => new GetSequenceReportsViewModel($sequence),
        ]);
    }
}
