<?php

use App\Http\Controllers\Broadcast\CreateBroadcastController;
use App\Http\Controllers\Broadcast\SendBroadcastController;
use App\Http\Controllers\Sequence\CreateSequenceController;
use App\Http\Controllers\Sequence\CreateSequenceMailController;
use App\Http\Controllers\Sequence\StartSequenceController;
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

Route::post('broadcasts', CreateBroadcastController::class);
Route::post('sent-broadcasts/{broadcast}', SendBroadcastController::class);

Route::post('sequences', CreateSequenceController::class);
Route::post('started-sequences/{sequence}', StartSequenceController::class);
Route::post('sequences/{sequence}/mails', CreateSequenceMailController::class);

// Route::patch('opened-mails/{sentMail}', OpenSentMailController::class);
// Route::patch('clicked-mails/{sentMail}', ClickSentMailController::class);

Route::get('statistics/dashboard', GetDashboardController::class);
Route::get('statistics/daily-subscribers', GetDailySubscribersController::class);
Route::get('statistics/sequence-progresses/{sequence}', GetSequenceProgressController::class);
Route::get('statistics/trackings/broadcasts/{broadcast}', GetBroadcastTrackingController::class);
Route::get('statistics/trackings/sequence-mails/{sequenceMail}', GetSequenceMailTrackingController::class);
Route::get('statistics/trackings/sequences/{sequence}', GetSequenceTrackingController::class);
