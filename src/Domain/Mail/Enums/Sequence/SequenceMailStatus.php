<?php

namespace Domain\Mail\Enums\Sequence;

enum SequenceMailStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
}
