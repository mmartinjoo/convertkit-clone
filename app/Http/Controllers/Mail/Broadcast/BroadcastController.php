<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Broadcast\CreateBroadcastAction;
use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\ViewModels\Broadcast\CreateBroadcastViewModel;
use Domain\Mail\ViewModels\Broadcast\GetBroadcastsViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class BroadcastController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Broadcast/Index', [
            'model' => new GetBroadcastsViewModel(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Broadcast/Create', [
            'model' => new CreateBroadcastViewModel(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        CreateBroadcastAction::execute(BroadcastData::fromRequest($request));

        return Redirect::route('broadcasts.index');
    }
}
