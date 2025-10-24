<?php

namespace App\Repositories\User;

interface IUserRoleRepository
{
    public function create(array $data): bool;
}