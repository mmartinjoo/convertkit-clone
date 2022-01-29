<?php

namespace Domain\Sequence\Enums;

enum SequenceMailStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
}
