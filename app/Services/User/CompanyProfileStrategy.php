<?php

namespace App\Services\User;

use App\Dto\CompanyProfile\CreateCompanyProfileData;
use App\Dto\CompanyProfile\UpdateCompanyProfile;
use App\Exceptions\User\CreateUserException;
use App\Exceptions\User\UpdateUserException;
use App\Models\User;
use App\Repositories\CompanyProfile\ICompanyProfileRepository;

class CompanyProfileStrategy implements IUserProfileStrategy
{
    public ICompanyProfileRepository $companyProfileRepository;
    public function __construct()
    {
        $this->companyProfileRepository = app(ICompanyProfileRepository::class);
    }

    /**
     * 기업회원 프로필 생성
     * @param User $user
     * @param array $data
     * @return void
     * @throws CreateUserException
     */
    public function createProfile(User $user, array $data): void
    {
        $createProfileDto = new CreateCompanyProfileData(
            userId: $user->id,
            companyId: $data['companyId'],
            position: $data['position'] ?? null,
            department: $data['department'] ?? null,
            employeeNumber: $data['employeeNumber'] ?? null,
            joinedAt: $data['joinedAt'] ?? null,
            leftAt: $data['leftAt'] ?? null,
        );

        $creatResult = $this->companyProfileRepository->create($createProfileDto->toArray());

        if (!$creatResult) {
            throw new CreateUserException('기업 회원 프로필 생성 실패');
        }
    }

    /**
     * 기업회원 프로필 수정
     * @param User $user
     * @param array $data
     * @return void
     * @throws UpdateUserException
     */
    public function updateProfile(User $user, array $data): void
    {
        $updateCompanyProfileDto = new UpdateCompanyProfile(
            companyId: $data['companyId'],
            position: $data['position'] ?? null,
            department: $data['department'] ?? null,
            employeeNumber: $data['employeeNumber'] ?? null,
            joinedAt: $data['joinedAt'] ?? null,
            leftAt: $data['leftAt'] ?? null,
        );

        $update = $this->companyProfileRepository->update($user->id, $updateCompanyProfileDto->toArray());

        if (!$update) {
            throw new UpdateUserException("기업 회원 프로필 업데이트 실패 user id: " . $user->id);
        }
    }
}