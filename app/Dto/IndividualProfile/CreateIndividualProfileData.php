<?php

namespace App\Dto\IndividualProfile;

readonly class CreateIndividualProfileData
{

    public function __construct(
        public int     $userId,
        public ?string $job = null,
        public ?int    $career = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'job' => $this->job,
            'career' => $this->career,
        ];
    }
}