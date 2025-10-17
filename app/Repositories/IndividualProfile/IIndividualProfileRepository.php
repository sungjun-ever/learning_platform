<?php

namespace App\Repositories\IndividualProfile;

use App\Models\IndividualProfile;

interface IIndividualProfileRepository
{
    public function create(array $data): ?IndividualProfile;
}