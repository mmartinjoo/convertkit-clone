<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\ViewModels\CreateSubscriberViewModel;
use Inertia\Inertia;
use Inertia\Response;

class SubscriberController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Subscriber/Create', [
            'model' => new CreateSubscriberViewModel(),
        ]);
    }
}
