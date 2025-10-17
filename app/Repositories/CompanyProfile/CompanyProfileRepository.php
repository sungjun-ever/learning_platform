<?php

namespace App\Repositories\CompanyProfile;

use App\Models\CompanyProfile;

readonly class CompanyProfileRepository implements ICompanyProfileRepository
{
    public function __construct(
        private CompanyProfile $model,
    )
    {
    }

    public function create(array $data): ?CompanyProfile
    {
        return $this->model->create($data);
    }
}