<?php

namespace App\Http\Controllers\Sequence;

use App\Http\Controllers\Controller;
use Domain\Sequence\Actions\StartSequenceAction;
use Domain\Sequence\Models\Sequence;
use Illuminate\Http\Response;

class StartSequenceController extends Controller
{
    public function __invoke(Sequence $sequence): Response
    {
        StartSequenceAction::execute($sequence);
        return response('', Response::HTTP_CREATED);
    }
}
