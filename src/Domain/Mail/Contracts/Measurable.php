<?php

namespace Domain\Mail\Contracts;

use Domain\Mail\DataTransferObjects\PerformanceData;
use Illuminate\Database\Eloquent\Relations\Relation;

interface Measurable
{
    public function performance(): PerformanceData;
    public function sent_mails(): Relation;
}
