<?php

use App\Http\Controllers\Broadcast\CreateBroadcastController;
use App\Http\Controllers\Broadcast\SendBroadcastController;
use App\Http\Controllers\Sequence\CreateSequenceController;
use App\Http\Controllers\Subscriber\CreateSubscriberController;
use App\Http\Controllers\Subscriber\ImportSubscribersController;
use Illuminate\Support\Facades\Route;

Route::post('subscribers', CreateSubscriberController::class);
Route::post('subscribers/import', ImportSubscribersController::class);

Route::post('broadcasts', CreateBroadcastController::class);
Route::post('sent-broadcasts/{broadcast}', SendBroadcastController::class);

Route::post('sequences', CreateSequenceController::class);
