<?php

use App\Http\Controllers\Subscriber\ImportSubscribersController;
use App\Http\Controllers\Subscriber\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::apiResource('subscribers', SubscriberController::class);
Route::post('subscribers/import', ImportSubscribersController::class);
