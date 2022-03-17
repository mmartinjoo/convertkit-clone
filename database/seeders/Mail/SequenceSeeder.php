<?php

namespace Database\Seeders\Mail;

use Database\Seeders\Subscriber\SubscriberSeeder;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Enums\Sequence\SequenceMailUnit;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\Models\Sequence\SequenceMailSchedule;
use Domain\Subscriber\Models\Subscriber;

class SequenceSeeder extends SubscriberSeeder
{
    public function run()
    {
        $demoUser = $this->demoUser();

        $sequence = Sequence::factory([
            'title' => 'My Newsletter',
            'status' => SequenceStatus::Published,
        ])->for($demoUser)->create();

        $welcomeMail = SequenceMail::factory([
            'subject' => 'Welcome To My Newsletter',
            'content' => "<h1 style='font-size:18px;font-weight:bold;'>Welcome To My Newsletter!</h1><p>Hi there! I'm happy you subscribed to this newsletter. Can't wait to spam the hell outta you!</p><p>Just kidding... I'll only send you one e-mail every week on Wednesday. These e-mails will describe topics such as</p><ul><li>Laravel tips</li><li>Writing clean and high-level code</li><li>Domain-Driven Design concepts</li><li>Test-Driven Development</li><li>...and much more</li></ul><p>Until then, you can</p><button style='background-color:#1677be;color:white;font-weight:bold;padding: 10px;'>Check out my blog</button><p>See you next Wednesday!</p>",
            'status' => SequenceMailStatus::Published,
            'filters' => [
                'form_ids' => [],
                'tag_ids' => [],
            ],
        ])->for($sequence)->for($demoUser)->create();
        $this->everyWednesday($welcomeMail);

        $vueMail = SequenceMail::factory([
            'subject' => 'Vue3 + Laravel9 API',
            'content' => "<h1 style='font-size:18px;font-weight:bold;'>Hey!</h1><p>I just released a new blog post where I build an SPA using the new Vue3 composite API with a Laravel 9 backend.</p><p>I think you're goind to love it:</p><button style='background-color:#1677be;color:white;font-weight:bold;padding: 10px;'>Read tha article</button>",
            'status' => SequenceMailStatus::Published,
            'filters' => [
                'form_ids' => [],
                'tag_ids' => [$this->tagId('Vue'), $this->tagId('Laravel')],
            ],
        ])->for($sequence)->create();
        $this->everyWednesday($vueMail);

        $chapterMail = SequenceMail::factory([
            'subject' => 'A Chapter From My Upcoming Book',
            'content' => "<h1 style='font-size:18px;font-weight:bold;'>Hey!</h1><p>I just finished the first chapter of my upcoming book Domain-Driven Design with Laravel. Since you joined the waiting list, I thought you might want to take a look at it!</p><p>I would approciate any feedback 🙏</p><button style='background-color:#1677be;color:white;font-weight:bold;padding: 10px;'>Download the chapter</button><p>Thanks a ton to show an interest in my work!</p>",
            'status' => SequenceMailStatus::Published,
            'filters' => [
                'form_ids' => [$this->formId('Waiting List')],
                'tag_ids' => [],
            ],
        ])->for($sequence)->create();
        $this->everyWednesday($chapterMail);

        $sequence->subscribers()->sync(Subscriber::select('id')->pluck('id'));
    }

    protected function everyWednesday(SequenceMail $mail): SequenceMailSchedule
    {
        return SequenceMailSchedule::create([
            'sequence_mail_id' => $mail->id,
            'delay' => 1,
            'unit' => SequenceMailUnit::Hour,
            'allowed_days' => [
                'monday' => false,
                'tuesday' => false,
                'wednesday' => true,
                'thursday' => false,
                'friday' => false,
                'saturday' => false,
                'sunday' => false,
            ]
        ]);
    }
}
