<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\ViewModels\GetBroadcastsViewModel;
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
}
