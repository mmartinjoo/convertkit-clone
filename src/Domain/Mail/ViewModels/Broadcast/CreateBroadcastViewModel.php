<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Shared\ViewModels\Concerns\HasForms;
use Domain\Shared\ViewModels\Concerns\HasTags;
use Domain\Shared\ViewModels\ViewModel;

class CreateBroadcastViewModel extends ViewModel
{
    use HasTags;
    use HasForms;
}
