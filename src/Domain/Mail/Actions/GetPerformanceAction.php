<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Contracts\Measurable;
use Domain\Mail\DataTransferObjects\PerformanceData;

class GetPerformanceAction
{
    public static function execute(Measurable $model): PerformanceData
    {
        return $model->performance();
    }
}
