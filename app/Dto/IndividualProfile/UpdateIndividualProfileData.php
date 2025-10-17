<?php

namespace App\Dto\IndividualProfile;

readonly class UpdateIndividualProfileData
{

    public function __construct(
        public ?string $job = null,
        public ?int    $career = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'job' => $this->job,
            'career' => $this->career,
        ];
    }
}