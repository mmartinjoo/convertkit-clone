<?php

namespace Database\Seeders;

use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $demoUser = User::factory([
            'name' => 'Demo User',
            'email' => 'demo@convertkit-clone.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->create();

        $tags = Tag::factory()->for($demoUser)->count(10)->create();
        $forms = Form::factory()->for($demoUser)->count(3)->create();

        foreach (range(1, 200) as $i) {
            $subscribers = Subscriber::factory([
                'form_id' => rand(0, 1) ? $forms->random() : null,
            ])
            ->for($demoUser)
            ->create();
        }

        $subscribers->each(function (Subscriber $subscriber) use ($tags) {
            if (rand(0, 1)) {
                $tags->take(rand(1, 10))
                    ->each(fn (Tag $tag) => $subscriber->tags()->attach($tag->id));
            }
        });

        // Sequence::factory()
        //     ->count(5)
        //     ->has(SequenceMail::factory()->count(10), 'mails')
        //     ->create();
    }
}
