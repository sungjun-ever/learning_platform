<?php

namespace App\Repositories\CompanyProfile;

use App\Models\CompanyProfile;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class CompanyProfileRepository extends BaseRepository implements ICompanyProfileRepository
{
    public function __construct()
    {
        parent::__construct(new CompanyProfile());
    }

    public function create(array $data): ?CompanyProfile
    {
        return $this->writeConnection()->create($data);
    }

    public function update(int $userId, array $data): bool
    {
        return $this->writeConnection()->where('user_id', $userId)->update($data);
    }

    public function upsert(array $data): bool
    {
        return $this->writeConnection()->upsert($data, ['user_id']);
    }

    public function delete(int $userId): bool
    {
        return $this->writeConnection()->where('user_id', $userId)->delete();
    }
}