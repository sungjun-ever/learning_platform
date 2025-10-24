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

    public function findByRoleName(): ?Role
    {

    }

}