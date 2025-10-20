<?php

namespace App\Services\User\UserProfileStrategy;

use App\Dto\UserProfile\IProfileData;
use App\Exceptions\User\CreateUserException;
use App\Exceptions\User\UpdateUserException;
use App\Models\User;
use App\Repositories\IndividualProfile\IIndividualProfileRepository;

readonly class IndividualProfileStrategy implements IUserProfileStrategy
{
    public function __construct(
        private IIndividualProfileRepository $individualProfileRepository,
    )
    {
    }

    /**
     * 개인회원 프로필 생성
     * @param User $user
     * @param IProfileData $dto
     * @return void
     * @throws CreateUserException
     */
    public function createProfile(User $user, IProfileData $dto): void
    {

        $createResult = $this->individualProfileRepository->create($dto->toArray());

        if (!$createResult) {
            throw new CreateUserException('개인 회원 프로필 생성 실패');
        }
    }

    /**
     * 개인회원 프로필 수정
     * @param User $user
     * @param IProfileData $dto
     * @return void
     * @throws UpdateUserException
     */
    public function updateProfile(User $user, IProfileData $dto): void
    {
        $update = $this->individualProfileRepository->update($user->id, $dto->toArray());

        if (!$update) {
            throw new UpdateUserException("개인 회원 프로필 업데이트 실패 user id: " . $user->id);
        }
    }
}