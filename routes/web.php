<?php

use App\Http\Web\Controllers\Automation\AutomationController;
use App\Http\Web\Controllers\Mail\Broadcast\BroadcastController;
use App\Http\Web\Controllers\Mail\Broadcast\PreviewBroadcastController;
use App\Http\Web\Controllers\Mail\Broadcast\SendBroadcastController;
use App\Http\Web\Controllers\Mail\Sequence\PreviewSequenceMailController;
use App\Http\Web\Controllers\Mail\Sequence\PublishSequenceController;
use App\Http\Web\Controllers\Mail\Sequence\SequenceController;
use App\Http\Web\Controllers\Mail\Sequence\SequenceMailController;
use App\Http\Web\Controllers\Mail\Sequence\GetSequenceReportController;
use App\Http\Web\Controllers\GetDashboardController;
use App\Http\Web\Controllers\Subscriber\ImportSubscribersController;
use App\Http\Web\Controllers\Subscriber\SubscriberController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', GetDashboardController::class)->name('dashboard');

    Route::resource('subscribers', SubscriberController::class);
    Route::post('subscribers/import', ImportSubscribersController::class);

    Route::resource('broadcasts', BroadcastController::class);
    Route::patch('broadcasts/{broadcast}/send', SendBroadcastController::class);
    Route::get('broadcasts/{broadcast}/preview', PreviewBroadcastController::class);

    Route::resource('sequences', SequenceController::class);
    Route::get('sequences/{sequence}/reports', GetSequenceReportController::class);
    Route::patch('sequences/{sequence}/publish', PublishSequenceController::class);

    Route::resource('sequences/{sequence}/mails', SequenceMailController::class);
    Route::get('sequences/{sequence}/mails/{mail}/preview', PreviewSequenceMailController::class);

    Route::resource('automations', AutomationController::class);
});

require __DIR__.'/auth.php';
