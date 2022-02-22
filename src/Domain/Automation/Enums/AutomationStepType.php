<?php

namespace Domain\Automation\Enums;

enum AutomationStepType: string
{
    case Event = 'event';
    case Action = 'action';
}
