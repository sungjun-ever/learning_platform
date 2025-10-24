<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

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
}