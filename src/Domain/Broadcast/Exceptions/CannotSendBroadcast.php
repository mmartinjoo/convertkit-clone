<?php

namespace Domain\Broadcast\Exceptions;

use Exception;

class CannotSendBroadcast extends Exception
{
    public static function because(string $message): self
    {
        return new self($message);
    }
}
