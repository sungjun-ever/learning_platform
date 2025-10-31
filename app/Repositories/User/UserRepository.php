<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function __construct()
    {
        parent::__construct(new User());
    }

    public function create(array $data): ?User
    {
        return $this->writeConnection()->create($data);
    }

    public function findByUuid(string $uuid): ?User
    {
        return $this->writeConnection()
            ->where('uuid', $uuid)
            ->first();
    }

    public function findUserAllProfiles(string $uuid): Collection
    {
        return $this->readConnection()
            ->with(['individualProfile', 'companyProfile'])
            ->where('uuid', $uuid)
            ->get();
    }
}