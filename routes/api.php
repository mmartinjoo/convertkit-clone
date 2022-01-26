<?php

use App\Http\Controllers\Broadcast\BroadcastController;
use App\Http\Controllers\Subscriber\ImportSubscribersController;
use App\Http\Controllers\Subscriber\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::apiResource('subscribers', SubscriberController::class);
Route::post('subscribers/import', ImportSubscribersController::class);

Route::apiResource('broadcasts', BroadcastController::class);
