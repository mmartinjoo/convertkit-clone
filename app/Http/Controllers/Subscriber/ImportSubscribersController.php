<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Actions\ImportSubscribersAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ImportSubscribersController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        ImportSubscribersAction::execute(storage_path('subscribers/subscribers.csv'));

        return Redirect::route('subscribers.index');
    }
}
