<?php

namespace Domain\Mail\Enums\Broadcast;

enum BroadcastStatus: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
}
