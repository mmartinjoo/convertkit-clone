<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Statistics\Actions\GetNewSubscribersCountAction;
use Domain\Statistics\DataTransferObjects\NewSubscribersCountData;

class GetNewSubscribersCountController extends Controller
{
    public function __invoke(): NewSubscribersCountData
    {
        return GetNewSubscribersCountAction::execute();
    }
}
