<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;
use Illuminate\Http\Response;

class PublishSequenceController extends Controller
{
    public function __invoke(Sequence $sequence): Response
    {
        $sequence->status = SequenceStatus::PUBLISHED;
        $sequence->save();

        return response()->noContent();
    }
}
