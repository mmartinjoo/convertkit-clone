<?php

namespace Domain\Mail\Exceptions\Broadcast;

use Exception;

class CannotSendBroadcast extends Exception
{
    public static function because(string $message): self
    {
        return new self($message);
    }
}
