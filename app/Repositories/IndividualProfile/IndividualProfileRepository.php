<?php

namespace App\Repositories\IndividualProfile;

use App\Models\IndividualProfile;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class IndividualProfileRepository extends BaseRepository implements IIndividualProfileRepository
{
    public function __construct()
    {
        parent::__construct(new IndividualProfile());
    }

    public function create(array $data): ?IndividualProfile
    {
        return $this->writeConnection()->create($data);
    }

    public function update(int $userId, array $data): bool
    {
        return $this->writeConnection()->where('user_id', $userId)->update($data);
    }

    public function upsert(array $data): bool {
        return $this->writeConnection()->upsert($data, ['user_id']);
    }

    public function delete(int $userId): bool
    {
        return $this->writeConnection()->where('user_id', $userId)->delete();
    }
}