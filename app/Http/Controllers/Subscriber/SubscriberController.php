<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Actions\UpsertSubscriberAction;
use Domain\Subscriber\Actions\DeleteSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\ViewModels\UpsertSubscriberViewModel;
use Domain\Subscriber\ViewModels\GetSubscribersViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class SubscriberController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Subscriber/List', [
            'model' => new GetSubscribersViewModel(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Subscriber/Form', [
            'model' => new UpsertSubscriberViewModel(),
        ]);
    }

    public function store(SubscriberData $data): RedirectResponse
    {
        UpsertSubscriberAction::execute($data);

        return Redirect::route('subscribers.index');
    }

    public function edit(Subscriber $subscriber): Response
    {
        return Inertia::render('Subscriber/Form', [
            'model' => new UpsertSubscriberViewModel($subscriber),
        ]);
    }

    public function update(SubscriberData $data): RedirectResponse
    {
        UpsertSubscriberAction::execute($data);

        return Redirect::route('subscribers.index');
    }

    public function destroy(Subscriber $subscriber): HttpResponse
    {
        DeleteSubscriberAction::execute($subscriber);

        return response()->noContent();
    }
}
