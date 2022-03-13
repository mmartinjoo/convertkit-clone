<?php

namespace Domain\Mail\Contracts;

interface Measurable
{
    public function totalInstances(): int;
}
