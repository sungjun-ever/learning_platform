<?php

namespace App\Services;

use App\Dto\CompanyProfile\CreateCompanyProfileData;
use App\Dto\CompanyProfile\UpdateCompanyProfile;
use App\Dto\IndividualProfile\CreateIndividualProfileData;
use App\Dto\IndividualProfile\UpdateIndividualProfileData;
use App\Dto\User\CreateUserData;
use App\Dto\User\UpdateUserData;
use App\Enum\UserType;
use App\Exceptions\User\CreateUserException;
use App\Exceptions\User\UpdateUserException;
use App\Models\User;
use App\Repositories\CompanyProfile\ICompanyProfileRepository;
use App\Repositories\IndividualProfile\IIndividualProfileRepository;
use App\Repositories\User\IUserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

readonly class UserService
{
    public function __construct(
        private IUserRepository              $userRepository,
        private IIndividualProfileRepository $individualProfileRepository,
        private ICompanyProfileRepository    $companyProfileRepository,
    )
    {
    }

    /**
     * uuid로 사용자 가져오기
     * @param string $uuid
     * @return User
     * @throws ModelNotFoundException
     */
    public function getUserUseUuid(string $uuid): User
    {
        $user = $this->userRepository->findByUuid($uuid);

        if (!$user) {
            throw new ModelNotFoundException("사용자를 찾을 수 없습니다.");
        }

        $profile = match ($user->user_type) {
            UserType::INDIVIDUAL->value => 'individualProfile',
            UserType::COMPANY->value => 'companyProfile',
            default => null,
        };

        if ($profile) {
            $user->load($profile);
        }

        return $user;
    }

    /**
     * 개인 회원 프로필 생성
     * @param User $user
     * @param array $data
     * @return void
     * @throws CreateUserException
     */
    private function createIndividualProfile(User $user, array $data): void
    {
        $createProfileDto = new CreateIndividualProfileData(
            userId: $user->id,
            job: $data['job'] ?? null,
            career: $data['career'] ?? null
        );

        $individualProfile = $this->individualProfileRepository->create($createProfileDto->toArray());

        if (!$individualProfile) {
            throw new CreateUserException('개인 회원 프로필 생성 실패');
        }
    }

    /**
     * 기업회원 프로필 생성
     * @param User $user
     * @param array $data
     * @return void
     * @throws CreateUserException
     */
    private function createCompanyProfile(User $user, array $data): void
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

        $companyProfile = $this->companyProfileRepository->create($createProfileDto->toArray());

        if (!$companyProfile) {
            throw new CreateUserException('기업 회원 프로필 생성 실패');
        }
    }

    /**
     * 사용자 생성
     * @param array $data
     * @return string
     * @throws \Throwable
     */
    public function createUser(array $data): string
    {
        $userUuid = null;

        DB::transaction(function () use ($data, &$userUuid) {
            $createUserData = new CreateUserData(
                uuid: Uuid::uuid7()->toString(),
                email: $data['email'],
                password: $data['password'],
                name: $data['name'],
                userType: $data['userType'],
                phone: $data['phone'] ?? null,
                birth: $data['birth'] ?? null,
            );

            $user = $this->userRepository->create($createUserData->toArray());

            if (!$user) {
                throw new CreateUserException('사용자 생성에 실패했습니다.');
            }

            if ($data['userType'] === UserType::INDIVIDUAL->value) {
                $this->createIndividualProfile($user, $data);
            }

            if ($data['userType'] === UserType::COMPANY->value) {
                $this->createCompanyProfile($user, $data);
            }

            $userUuid = $user->uuid;
        });

        return $userUuid;
    }

    /**
     * 개인 회원 프로필 업데이트
     * @param User $user
     * @param array $data
     * @return void
     * @throws UpdateUserException
     */
    private function updateIndividualProfile(User $user, array $data): void
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

    /**
     * 기업 회원 프로필 업데이트
     * @param User $user
     * @param array $data
     * @return void
     * @throws UpdateUserException
     */
    private function updateCompanyProfile(User $user, array $data): void
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

    /**
     * 사용자 정보 수정
     * @param string $uuid
     * @param array $data
     * @return string
     * @throws \Throwable
     */
    public function updateUser(string $uuid, array $data): string
    {
        DB::transaction(function () use ($uuid, $data) {
            $updateUserData = new UpdateUserData(
                name: $data['name'],
                phone: $data['phone'] ?? null,
                birth: $data['birth'] ?? null,
            );

            $user = $this->userRepository->findByUuid($uuid);

            if (!$user) {
                throw new ModelNotFoundException("사용자 가져오기 실패 uuid: $uuid");
            }

            $updateUser = $user->update($updateUserData->toArray());

            if (!$updateUser) {
                throw new UpdateUserException("사용자 수정 실패 uuid: $uuid");
            }

            if ($data['userType'] === UserType::INDIVIDUAL->value) {
                $this->updateIndividualProfile($user, $data);
            }

            if ($data['userType'] === UserType::COMPANY->value) {
                $this->updateCompanyProfile($user, $data);
            }
        });

        return $uuid;
    }

}