<?php

namespace App\Http\Web\Controllers\Mail\Broadcast;

use Domain\Mail\Actions\Broadcast\UpsertBroadcastAction;
use Domain\Mail\Actions\Broadcast\DeleteBroadcastAction;
use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\ViewModels\Broadcast\UpsertBroadcastViewModel;
use Domain\Mail\ViewModels\Broadcast\GetBroadcastsViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class BroadcastController
{
    public function index(): Response
    {
        return Inertia::render('Broadcast/List', [
            'model' => new GetBroadcastsViewModel(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Broadcast/Form', [
            'model' => new UpsertBroadcastViewModel(),
        ]);
    }

    public function store(BroadcastData $data, Request $request): RedirectResponse
    {
        UpsertBroadcastAction::execute($data, $request->user());

        return Redirect::route('broadcasts.index');
    }

    public function edit(Broadcast $broadcast): Response
    {
        return Inertia::render('Broadcast/Form', [
            'model' => new UpsertBroadcastViewModel($broadcast),
        ]);
    }

    public function update(BroadcastData $data, Request $request): RedirectResponse
    {
        UpsertBroadcastAction::execute($data, $request->user());

        return Redirect::route('broadcasts.index');
    }

    public function destroy(Broadcast $broadcast): RedirectResponse
    {
        DeleteBroadcastAction::execute($broadcast);

        return Redirect::route('broadcasts.index');
    }
}
