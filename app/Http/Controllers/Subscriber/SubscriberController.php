<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Actions\CreateSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\ViewModels\CreateSubscriberViewModel;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class SubscriberController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Subscriber/Create', [
            'model' => new CreateSubscriberViewModel(),
        ]);
    }

    public function store(SubscriberData $data)
    {
        CreateSubscriberAction::execute($data);

        return Redirect::route('dashboard');
    }
}
