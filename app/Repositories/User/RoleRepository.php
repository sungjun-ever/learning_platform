<?php

namespace App\Repositories\User;

use App\Models\Role;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class RoleRepository extends BaseRepository implements IRoleRepository
{
    public function __construct()
    {
        parent::__construct(new Role());
    }

    public function create(array $data): ?Role
    {
        return $this->writeConnection()->create($data);
    }

    public function findByRoleCode(string $roleCode): ?Role
    {
        return $this->readConnection()->where('code', $roleCode)->first();
    }


}