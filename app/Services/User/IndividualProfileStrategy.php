<?php

namespace App\Services\User;

use App\Dto\IndividualProfile\CreateIndividualProfileData;
use App\Dto\IndividualProfile\UpdateIndividualProfileData;
use App\Exceptions\User\CreateUserException;
use App\Exceptions\User\UpdateUserException;
use App\Models\User;
use App\Repositories\IndividualProfile\IIndividualProfileRepository;

class IndividualProfileStrategy implements IUserProfileStrategy
{
    public IIndividualProfileRepository $individualProfileRepository;

    public function __construct()
    {
        $this->individualProfileRepository = app(IIndividualProfileRepository::class);
    }

    /**
     * 개인회원 프로필 생성
     * @param User $user
     * @param array $data
     * @return void
     * @throws CreateUserException
     */
    public function createProfile(User $user, array $data): void
    {
        $createProfileDto = new CreateIndividualProfileData(
            userId: $user->id,
            job: $data['job'] ?? null,
            career: $data['career'] ?? null
        );

        $createResult = $this->individualProfileRepository->create($createProfileDto->toArray());

        if (!$createResult) {
            throw new CreateUserException('개인 회원 프로필 생성 실패');
        }
    }

    /**
     * 개인회원 프로필 수정
     * @param User $user
     * @param array $data
     * @return void
     * @throws UpdateUserException
     */
    public function updateProfile(User $user, array $data)
    {
        $updateIndividualProfileDto = new UpdateIndividualProfileData(
            job: $data['job'] ?? null,
            career: $data['career'] ?? null,
        );

        $update = $this->individualProfileRepository->update($user->id, $updateIndividualProfileDto->toArray());

        if (!$update) {
            throw new UpdateUserException("개인 회원 프로필 업데이트 실패 user id: " , $user->id);
        }
    }
}