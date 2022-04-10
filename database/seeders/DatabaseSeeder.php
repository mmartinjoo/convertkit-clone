<?php

namespace Database\Seeders;

use Database\Seeders\Automation\AutomationSeeder;
use Database\Seeders\Mail\BroadcastSeeder;
use Database\Seeders\Mail\SequenceSeeder;
use Database\Seeders\Subscriber\SubscriberSeeder;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    protected string $email;
    private const DEMO_USER_EMAIL = 'demo@mailtool.biz';

    public function __construct()
    {
        $this->email = config('app.seeder_email', self::DEMO_USER_EMAIL);
    }

    public function run()
    {
        if ($this->email === self::DEMO_USER_EMAIL) {
            User::factory([
                'name' => 'Demo User',
                'email' => self::DEMO_USER_EMAIL,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ])->create();
        }

        $this->call([
            SubscriberSeeder::class,
            BroadcastSeeder::class,
            SequenceSeeder::class,
            AutomationSeeder::class,
        ]);
    }

    protected function demoUser(): User
    {
        return User::whereEmail($this->email)->firstOrFail();
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
