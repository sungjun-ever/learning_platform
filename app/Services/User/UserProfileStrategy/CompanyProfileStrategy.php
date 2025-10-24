<?php

namespace App\Services\User\UserProfileStrategy;

use App\Dto\UserProfile\IProfileData;
use App\Exceptions\User\CreateUserException;
use App\Exceptions\User\UpdateUserException;
use App\Models\User;
use App\Repositories\CompanyProfile\ICompanyProfileRepository;

readonly class CompanyProfileStrategy implements IUserProfileStrategy
{
    public function __construct(
        private ICompanyProfileRepository $companyProfileRepository
    )
    {
    }

    /**
     * 기업회원 프로필 생성
     * @param User $user
     * @param IProfileData $dto
     * @return void
     * @throws CreateUserException
     */
    public function createProfile(User $user, IProfileData $dto): void
    {
        $createResult = $this->companyProfileRepository->create($dto->toArray());

        if (!$createResult) {
            throw new CreateUserException('기업 회원 프로필 생성 실패');
        }
    }

    /**
     * 기업회원 프로필 수정
     * @param User $user
     * @param IProfileData $dto
     * @return void
     * @throws UpdateUserException
     */
    public function updateProfile(User $user, IProfileData $dto): void
    {
        $update = $this->companyProfileRepository->upsert($dto->toArray());

        if (!$update) {
            throw new UpdateUserException("기업 회원 프로필 업데이트 실패 user id: " . $user->id);
        }
    }
}