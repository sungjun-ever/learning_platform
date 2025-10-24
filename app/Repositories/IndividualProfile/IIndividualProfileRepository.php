<?php

namespace App\Repositories\IndividualProfile;

use App\Models\IndividualProfile;

interface IIndividualProfileRepository
{
    public function create(array $data): ?IndividualProfile;
    public function update(int $userId, array $data): bool;
    public function upsert(array $data): bool;
    public function delete(int $userId): bool;
}