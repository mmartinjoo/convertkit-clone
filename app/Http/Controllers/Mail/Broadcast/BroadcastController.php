<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Broadcast\CreateBroadcastAction;
use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\ViewModels\Broadcast\GetBroadcastsViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

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
        return Inertia::render('Subscriber/Create', [
            'model' => new CreateBroadcastViewModel(),
        ]);
    }

    public function store(BroadcastData $data): RedirectResponse
    {
        CreateBroadcastAction::execute($data);

        return Redirect::route('broadcasts.index');
    }
}
