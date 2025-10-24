<?php

namespace App\Repositories\User;

use App\Models\UserRole;
use App\Repositories\BaseRepository;

class UserRoleRepository extends BaseRepository implements IUserRoleRepository
{
    public function __construct()
    {
        parent::__construct(new UserRole());
    }

    public function create(array $data): bool
    {
        return $this->writeConnection()->create($data);
    }
}