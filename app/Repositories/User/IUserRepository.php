<?php

namespace App\Repositories\User;

use App\Models\User;

interface IUserRepository
{
    public function findByUuid(string $uuid): ?User;
    public function create(array $data): ?User;
}