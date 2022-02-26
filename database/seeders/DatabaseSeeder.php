<?php

namespace Database\Seeders;

use Domain\Shared\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private const DEMO_USER_EMAIL = 'demo@convertkit-clone.com';

    public function run()
    {
        User::factory([
            'name' => 'Demo User',
            'email' => self::DEMO_USER_EMAIL,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->create();

        $this->call([
            SubscriberSeeder::class,
            BroadcastSeeder::class,
        ]);
    }

    protected function demoUser(): User
    {
        return User::whereEmail(self::DEMO_USER_EMAIL)->firstOrFail();
    }
}
