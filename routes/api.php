<?php

use App\Http\Controllers\Mail\Broadcast\CreateBroadcastController;
use App\Http\Controllers\Mail\Broadcast\SendBroadcastController;
use App\Http\Controllers\Mail\SentMail\ClickSentMailController;
use App\Http\Controllers\Mail\SentMail\OpenSentMailController;
use App\Http\Controllers\Mail\Sequence\CreateSequenceController;
use App\Http\Controllers\Mail\Sequence\CreateSequenceMailController;
use App\Http\Controllers\Mail\Sequence\PublishSequenceController;
use App\Http\Controllers\Statistics\GetBroadcastTrackingController;
use App\Http\Controllers\Statistics\GetDailySubscribersController;
use App\Http\Controllers\Statistics\GetDashboardController;
use App\Http\Controllers\Statistics\GetSequenceMailTrackingController;
use App\Http\Controllers\Statistics\GetSequenceProgressController;
use App\Http\Controllers\Statistics\GetSequenceTrackingController;
use App\Http\Controllers\Subscriber\CreateSubscriberController;
use App\Http\Controllers\Subscriber\ImportSubscribersController;
use Illuminate\Support\Facades\Route;

Route::post('subscribers', CreateSubscriberController::class);
Route::post('subscribers/import', ImportSubscribersController::class);

//Route::post('broadcasts', CreateBroadcastController::class);
Route::post('broadcasts/{broadcast}/send', SendBroadcastController::class);

Route::post('sequences', CreateSequenceController::class);
Route::patch('sequences/{sequence}/publish', PublishSequenceController::class);
Route::post('sequences/{sequence}/mails', CreateSequenceMailController::class);

 Route::patch('sent-mails/{sentMail}/open', OpenSentMailController::class);
 Route::patch('sent-mails/{sentMail}/click', ClickSentMailController::class);

Route::get('statistics/daily-subscribers', GetDailySubscribersController::class);
Route::get('statistics/sequence-progresses/{sequence}', GetSequenceProgressController::class);
Route::get('statistics/trackings/broadcasts/{broadcast}', GetBroadcastTrackingController::class);
Route::get('statistics/trackings/sequence-mails/{sequenceMail}', GetSequenceMailTrackingController::class);
Route::get('statistics/trackings/sequences/{sequence}', GetSequenceTrackingController::class);
