<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Sequence\StartSequenceAction;
use Domain\Mail\Models\Sequence\Sequence;
use Illuminate\Http\Response;

class StartSequenceController extends Controller
{
    public function __invoke(Sequence $sequence): Response
    {
        StartSequenceAction::execute($sequence);
        return response('', Response::HTTP_CREATED);
    }
}
