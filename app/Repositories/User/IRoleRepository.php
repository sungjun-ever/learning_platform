<?php

namespace App\Repositories\User;

use App\Models\Role;

interface IRoleRepository
{
    public function findByRoleName(): ?Role;
}