<?php

use App\Http\Controllers\Mail\Broadcast\SendBroadcastController;
use App\Http\Controllers\Mail\SentMail\ClickSentMailController;
use App\Http\Controllers\Mail\SentMail\OpenSentMailController;
use App\Http\Controllers\Subscriber\ImportSubscribersController;
use Illuminate\Support\Facades\Route;

Route::post('subscribers/import', ImportSubscribersController::class);

Route::post('broadcasts/{broadcast}/send', SendBroadcastController::class);

Route::patch('sent-mails/{sentMail}/open', OpenSentMailController::class);
Route::patch('sent-mails/{sentMail}/click', ClickSentMailController::class);
