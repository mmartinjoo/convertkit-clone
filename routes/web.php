<?php

use App\Http\Controllers\Automation\AutomationController;
use App\Http\Controllers\Automation\GetAutomationEventsController;
use App\Http\Controllers\Mail\Broadcast\BroadcastController;
use App\Http\Controllers\Mail\Broadcast\PreviewBroadcastController;
use App\Http\Controllers\Mail\Broadcast\SendBroadcastController;
use App\Http\Controllers\Mail\Sequence\PublishSequenceController;
use App\Http\Controllers\Mail\Sequence\SequenceController;
use App\Http\Controllers\Mail\Sequence\SequenceMailController;
use App\Http\Controllers\Mail\Sequence\GetSequenceReportController;
use App\Http\Controllers\Statistics\GetDashboardController;
use App\Http\Controllers\Subscriber\ImportSubscribersController;
use App\Http\Controllers\Subscriber\SubscriberController;
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

    Route::resource('automations', AutomationController::class);
});

require __DIR__.'/auth.php';
