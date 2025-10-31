<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface IUserRepository
{
    public function findByUuid(string $uuid): ?User;
    public function create(array $data): ?User;

    public function findUserAllProfiles(string $uuid): Collection;
}