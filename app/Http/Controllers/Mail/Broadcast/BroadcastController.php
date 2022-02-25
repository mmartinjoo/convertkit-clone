<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Broadcast\CreateBroadcastAction;
use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\ViewModels\Broadcast\CreateBroadcastViewModel;
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
            'model' => new CreateBroadcastViewModel(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        CreateBroadcastAction::execute(BroadcastData::fromRequest($request));

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
        $broadcast->delete();

        return response()->noContent();
    }
}
