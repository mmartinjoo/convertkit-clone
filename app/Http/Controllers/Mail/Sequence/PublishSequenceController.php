<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class PublishSequenceController extends Controller
{
    public function __invoke(Sequence $sequence): RedirectResponse
    {
        $sequence->status = SequenceStatus::Published;
        $sequence->save();

        return Redirect::route('sequences.show', $sequence);
    }
}
