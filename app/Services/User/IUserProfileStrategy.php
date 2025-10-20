<?php

namespace App\Services\User;

use App\Dto\UserProfile\IProfileData;
use App\Models\User;

interface IUserProfileStrategy
{
    public function createProfile(User $user, IProfileData $dto);
    public function updateProfile(User $user, IProfileData $dto);
}