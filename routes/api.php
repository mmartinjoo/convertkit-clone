<?php

use App\Http\Api\Controllers\Mail\ClickSentMailController;
use App\Http\Api\Controllers\Mail\OpenSentMailController;
use App\Http\Api\Controllers\Subscriber\CreateSubscriberController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::post('subscribers', CreateSubscriberController::class);
    Route::patch('sent-mails/{sentMail}/open', OpenSentMailController::class);
    Route::patch('sent-mails/{sentMail}/click', ClickSentMailController::class);
});
