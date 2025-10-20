<?php

namespace App\Services\User;

use App\Models\User;

interface IUserProfileStrategy
{
    public function createProfile(User $user, array $data);
    public function updateProfile(User $user, array $data);
}