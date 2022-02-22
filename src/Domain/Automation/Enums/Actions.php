<?php

namespace Domain\Automation\Enums;

enum Actions: string
{
    case AddToSequence = 'Domain\Automation\Actions\Steps\AddToSequenceAction';
    case AddTag = 'Domain\Automation\Actions\Steps\AddTagAction';
}
