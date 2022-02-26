<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Jobs\ImportSubscribersJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ImportSubscribersController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        ImportSubscribersJob::dispatch(storage_path('subscribers/subscribers.csv'));

        return Redirect::route('subscribers.index');
    }
}
