<?php

namespace App\Repositories\IndividualProfile;

use App\Models\IndividualProfile;

readonly class IndividualProfileRepository implements IIndividualProfileRepository
{
    public function __construct(
        private IndividualProfile $model,
    )
    {
    }

    public function create(array $data): ?IndividualProfile
    {
        return $this->model->create($data);
    }
}