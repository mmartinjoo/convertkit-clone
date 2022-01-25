<?php

use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::apiResource('subscribers', SubscriberController::class);
