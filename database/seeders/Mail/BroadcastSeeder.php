<?php

namespace Database\Seeders\Mail;

use Database\Seeders\DatabaseSeeder;
use Domain\Mail\Actions\Broadcast\SendBroadcastAction;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\Models\SentMail;
use Queue;
use function now;

class BroadcastSeeder extends DatabaseSeeder
{
    public function run()
    {
        $demoUser = $this->demoUser();

        $bestLaravelFeatures = Broadcast::factory([
            'subject' => 'Best Laravel Eloquent Features',
            'content' => "<h1 style='font-size:18px;font-weight:bold;'>👋Hey!</h1><p>Eloquent is a really powerful ORM. One of the most essential parts of Laravel. We love it, we use it, but there are a lot of unknown features!</p><p>For example:</p><ul><li>Did you know about invisible database columns?</li><li>The Attribute cast?</li><li>Or helpers like whereBelongsTo or whereRelation?</li><li>…And don’t forget about the Prunable trait!</li></ul><p>I've put together a short 34 pages PDF that contains 35 top-performing Eloquent-related tips. They earned 100000s impressions and 1000s likes on Twitter.</p><p style='font-weight: bold;'>These Eloquent tips will help you write cleaner, more efficient code.</p><p>If you have a few minutes,</p><button style='background-color:#1677be;color:white;font-weight:bold;padding: 10px;'>Download Your PDF</button>",
            'status' => BroadcastStatus::Draft,
            'filters' => [
                'tag_ids' => [$this->tagId('Laravel')],
                'form_ids' => [],
            ],
        ])
        ->for($demoUser)
        ->create();

        $this->sendBroadcast($bestLaravelFeatures);
        $this->consumeBroadcast($bestLaravelFeatures);

        Broadcast::factory([
            'subject' => 'Domain-Driven Design with Laravel Is Out!',
            'content' => "<h1 style='font-size:18px;font-weight:bold;'>👋Hey!</h1><p>I'm very happy to announce that the course Domain-Driven Design with Laravel is available as of today!</p><button style='background-color:#1677be;color:white;font-weight:bold;padding: 10px;'>Check out the course here</button>",
            'status' => BroadcastStatus::Draft,
            'filters' => [
                'tag_ids' => [$this->tagId('Laravel'), $this->tagId('DDD')],
                'form_ids' => [$this->formId('Waiting List')],
            ],
        ])
        ->for($demoUser)
        ->create();
    }

    private function sendBroadcast(Broadcast $broadcast): void
    {
        Queue::fake();

        SendBroadcastAction::execute($broadcast);
    }

    private function consumeBroadcast(Broadcast $broadcast): void
    {
        $mailsCount = $broadcast->sent_mails()->count();
        $openedCount = (int) ($mailsCount * 0.4951);
        $clickedCount = (int) ($mailsCount * 0.0947);

        $openedMailIds = $broadcast->sent_mails->random($openedCount)->pluck('id');
        SentMail::whereIn('id', $openedMailIds)
            ->update([
                'opened_at' => now(),
            ]);

        $clickedMailIds = SentMail::whereIn('id', $openedMailIds)->get()->random($clickedCount)->pluck('id');
        SentMail::whereIn('id', $clickedMailIds)
            ->update([
                'clicked_at' => now(),
            ]);
    }
}
