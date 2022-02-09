<?php

namespace Domain\Mail\Enums\Sequence;

enum SequenceMailStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
}
