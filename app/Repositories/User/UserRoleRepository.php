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

    public function findByUserId(int $userid): UserRole
    {
        return $this->readConnection()->where('user_id', $userid)->first();
    }

    public function create(array $data): bool
    {
        return $this->writeConnection()->create($data);
    }

    public function getUserRoleByUserId(int $userid): UserRole
    {
        return $this->readConnection()
            ->with(['role'])
            ->where('user_id', $userid)
            ->first();
    }

    public function delete(int $userid): bool
    {
        return $this->writeConnection()
            ->where('user_id', $userid)
            ->delete();
    }
}