<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Jobs\ImportSubscribersJob;
use Illuminate\Http\Response;

class ImportSubscribersController extends Controller
{
    public function __invoke(): Response
    {
        ImportSubscribersJob::dispatch(storage_path('subscribers/subscribers.csv'));

        return response('', Response::HTTP_ACCEPTED);
    }
}
