<?php

namespace Domain\Mail\Enums\Sequence;

enum SequenceStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
}
