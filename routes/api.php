<?php

use App\Http\Api\Controllers\Mail\ClickSentMailController;
use App\Http\Api\Controllers\Mail\OpenSentMailController;
use Illuminate\Support\Facades\Route;

//Route::post('subscribers', )
Route::patch('sent-mails/{sentMail}/open', OpenSentMailController::class);
Route::patch('sent-mails/{sentMail}/click', ClickSentMailController::class);
