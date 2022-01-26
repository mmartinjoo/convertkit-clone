<?php

namespace Domain\Broadcast\Enums;

enum BroadcastStatus: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
}
