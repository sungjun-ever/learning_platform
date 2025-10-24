<?php

namespace App\Repositories\User;

use App\Models\Role;

interface IRoleRepository
{
    public function create(array $data): ?Role;
    public function findByRoleCode(string $roleCode): ?Role;
}