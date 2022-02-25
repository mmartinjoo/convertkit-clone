<?php

use App\Http\Controllers\Mail\SentMail\ClickSentMailController;
use App\Http\Controllers\Mail\SentMail\OpenSentMailController;
use Illuminate\Support\Facades\Route;

Route::patch('sent-mails/{sentMail}/open', OpenSentMailController::class);
Route::patch('sent-mails/{sentMail}/click', ClickSentMailController::class);
