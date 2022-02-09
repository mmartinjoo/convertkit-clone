<?php

namespace Domain\Mail\Enums\Sequence;

enum SequenceStatus: string
{
    case DRAFT = 'draft';
    case STARTED = 'started';
}
