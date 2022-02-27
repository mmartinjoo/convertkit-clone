<?php

use App\Http\Web\Controllers\Mail\SentMail\ClickSentMailController;
use App\Http\Web\Controllers\Mail\SentMail\OpenSentMailController;
use Illuminate\Support\Facades\Route;

//Route::post('subscribers', )
Route::patch('sent-mails/{sentMail}/open', OpenSentMailController::class);
Route::patch('sent-mails/{sentMail}/click', ClickSentMailController::class);
