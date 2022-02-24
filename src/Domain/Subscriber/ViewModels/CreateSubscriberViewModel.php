<?php

namespace Domain\Subscriber\ViewModels;

use Domain\Shared\ViewModels\Concerns\HasForms;
use Domain\Shared\ViewModels\Concerns\HasTags;
use Domain\Shared\ViewModels\ViewModel;

class CreateSubscriberViewModel extends ViewModel
{
    use HasTags;
    use HasForms;
}
