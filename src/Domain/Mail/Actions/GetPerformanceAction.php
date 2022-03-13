<?php

namespace Domain\Mail\Actions;

use Domain\Mail\DataTransferObjects\PerformanceData;
use Illuminate\Database\Eloquent\Model;

class GetPerformanceAction
{
    public static function execute(Model $model): PerformanceData
    {
        return $model->performance();
    }
}
