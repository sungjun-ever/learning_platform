<?php

namespace App\Repositories\CompanyProfile;

use App\Models\CompanyProfile;

interface ICompanyProfileRepository
{
    public function create(array $data): ?CompanyProfile;
    public function update(int $userId, array $data): bool;
}