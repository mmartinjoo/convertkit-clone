<?php

namespace Domain\Mail\Enums\Sequence;

enum SubscriberStatus: string
{
    case InProgress = 'in-progress';
    case Completed = 'completed';
}
