<?php

namespace Domain\Mail\Enums\Broadcast;

enum BroadcastStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
}
