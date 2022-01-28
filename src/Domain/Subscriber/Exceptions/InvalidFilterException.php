<?php

namespace Domain\Subscriber\Exceptions;

use Exception;

class InvalidFilterException extends Exception
{
    public static function because(string $message): self
    {
        return new self($message);
    }
}
