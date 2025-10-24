<?php

namespace App\Repositories\CompanyProfile;

use App\Models\CompanyProfile;

interface ICompanyProfileRepository
{
    public function create(array $data): ?CompanyProfile;
    public function update(int $userId, array $data): bool;
    public function upsert(array $data): bool;
    public function delete(int $userId): bool;
}