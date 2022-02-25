<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Broadcast\UpsertBroadcastAction;
use Domain\Mail\Actions\Broadcast\DeleteBroadcastAction;
use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\ViewModels\Broadcast\UpsertBroadcastViewModel;
use Domain\Mail\ViewModels\Broadcast\GetBroadcastsViewModel;
use Domain\Mail\ViewModels\Broadcast\ShowBroadcastViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class BroadcastController extends Controller
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

    public function store(Request $request): RedirectResponse
    {
        UpsertBroadcastAction::execute(BroadcastData::fromRequest($request));

        return Redirect::route('broadcasts.index');
    }

    public function edit(Broadcast $broadcast): Response
    {
        return Inertia::render('Broadcast/Form', [
            'model' => new UpsertBroadcastViewModel($broadcast),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        UpsertBroadcastAction::execute(BroadcastData::fromRequest($request));

        return Redirect::route('broadcasts.index');
    }

    public function show(Broadcast $broadcast): Response
    {
        return Inertia::render('Broadcast/Show', [
            'model' => new ShowBroadcastViewModel($broadcast),
        ]);
    }

    public function destroy(Broadcast $broadcast): HttpResponse
    {
        DeleteBroadcastAction::execute($broadcast);

        return response()->noContent();
    }
}
