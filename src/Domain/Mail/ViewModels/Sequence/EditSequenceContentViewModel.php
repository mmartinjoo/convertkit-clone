<?php

namespace Domain\Mail\ViewModels\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\ViewModels\Concerns\HasForms;
use Domain\Shared\ViewModels\Concerns\HasTags;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Mail\DataTransferObjects\PerformanceData;

class EditSequenceContentViewModel extends ViewModel
{
    use HasTags;
    use HasForms;

    public function __construct(private readonly Sequence $sequence)
    {
    }

    public function sequence(): SequenceData
    {
        return $this->sequence->load('mails.schedule')->getData();
    }

    public function performance(): PerformanceData
    {
        return $this->sequence->performance();
    }

    public function dummyMail(): SequenceMailData
    {
        return SequenceMailData::dummy();
    }
}
