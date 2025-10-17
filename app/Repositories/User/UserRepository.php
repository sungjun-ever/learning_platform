<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements IUserRepository
{

    public function __construct(
        private readonly User $model,
    )
    {
    }

    protected function readConnection(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->on('sqlite');
    }

    protected function writeConnection(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->on('sqlite');
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