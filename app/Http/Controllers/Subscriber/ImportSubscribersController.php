<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Actions\ImportSubscribersAction;

class ImportSubscribersController extends Controller
{
    public function __invoke()
    {
        ImportSubscribersAction::execute(storage_path('subscribers/subscribers.csv'));
        return response()->noContent();
    }
}
