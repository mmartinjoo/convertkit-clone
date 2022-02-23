<?php

namespace Domain\Automation\Enums;

use Domain\Automation\Actions\Steps\AddTagAction;
use Domain\Automation\Actions\Steps\AddToSequenceAction;

enum Actions: string
{
    case AddToSequence = 'addToSequence';
    case AddTag = 'addTag';

    public function createAction()
    {
        return match ($this) {
            self::AddTag => app(AddTagAction::class),
            self::AddToSequence => app(AddToSequenceAction::class),
        };
    }
}
