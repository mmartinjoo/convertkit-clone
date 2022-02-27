<?php

namespace Database\Seeders;

use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private const DEMO_USER_EMAIL = 'demo@mailkit.com';

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
            SequenceSeeder::class,
            AutomationSeeder::class,
        ]);
    }

    protected function demoUser(): User
    {
        return User::whereEmail(self::DEMO_USER_EMAIL)->firstOrFail();
    }

    protected function tagId(string $title): int
    {
        return Tag::whereTitle($title)->firstOrFail()->id;
    }

    protected function formId(string $title): int
    {
        return Form::whereTitle($title)->firstOrFail()->id;
    }
}
