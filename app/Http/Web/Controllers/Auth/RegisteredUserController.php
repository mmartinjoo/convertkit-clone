<?php

namespace App\Http\Web\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Artisan;
use Database\Seeders\Automation\AutomationSeeder;
use Database\Seeders\Mail\BroadcastSeeder;
use Database\Seeders\Mail\SequenceSeeder;
use Database\Seeders\Subscriber\SubscriberSeeder;
use Domain\Shared\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        config(['app.seeder_email' => $user->email]);

        $seeder = app(SubscriberSeeder::class);
        $seeder->run();

        $seeder = app(BroadcastSeeder::class);
        $seeder->run();

        $seeder = app(SequenceSeeder::class);
        $seeder->run();

        $seeder = app(AutomationSeeder::class);
        $seeder->run();


        return redirect(RouteServiceProvider::HOME);
    }
}
