<?php

namespace App\Repositories\User;

use App\Models\UserRole;

interface IUserRoleRepository
{
    public function findByUserId(int $userid): UserRole;
    public function create(array $data): bool;
    public function getUserRoleByUserId(int $userid): UserRole;
    public function delete(int $userid): bool;

}