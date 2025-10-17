<?php

namespace App\Repositories\User;

use App\Models\User;

readonly class UserRepository implements IUserRepository
{

    public function __construct(
        private User $model,
    )
    {
    }

    public function create(array $data): ?User
    {
        return $this->model->create($data);
    }

    public function findByUuid(string $uuid): ?User
    {
        return $this->model
            ->where('uuid', $uuid)
            ->first();
    }
}