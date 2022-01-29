<?php

namespace Domain\Sequence\Enums;

enum SequenceStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
}
