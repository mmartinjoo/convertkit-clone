<?php

use App\Http\Controllers\Mail\Broadcast\BroadcastController;
use App\Http\Controllers\Statistics\GetDashboardController;
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
    Route::get('subscribers/create', [SubscriberController::class, 'create'])->name('subscribers.create');
    Route::post('subscribers', [SubscriberController::class, 'store'])->name('subscribers.store');
    Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');

    Route::resource('broadcasts', BroadcastController::class);
});

require __DIR__.'/auth.php';
